<?php namespace App\Http\Controllers;

use App\AddonRoom;
use App\Booking;
use App\Http\Requests;
use App\Room as Room;
use App\Addon as Addon;
use App\Rate as Rate;
use App\RoomAvailable;
use App\StandardInclude;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view('rooms.index');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ajaxGetRoomList(Request $request)
    {
        $room = new Room();

        return response()->json([
            'rooms' => $room->getRoomList($request->display_by)
        ]);
    }

    public function ajaxUpdateName()
    {
        $room = Room::find(Input::get('id'));

        if(Input::get('new_name') == '' || count($room) == 0) {
            return response()->json([
                'error' => 'Server received bad request.'
            ]);
        }

        $room = Room::find(Input::get('id'));
        $room->name = Input::get('new_name');
        $room->save();

        $saved_name = Room::find(Input::get('id'))->name;
        return response()->json([
            'saved_name' => $saved_name
        ]);
    }

    public function ajaxRemoveRate()
    {
        $rate_id = Input::get('id');

        Rate::find($rate_id)->delete();
    }

    public function ajaxRemoveRoomAvailable()
    {
        $rate_id = Input::get('id');

        RoomAvailable::find($rate_id)->delete();
    }

    public function ajaxPostUploadRoomImage()
    {
        $file = Input::file('image');
        $input = array('image' => $file);
        $rules = array(
            'image' => 'image'
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return Response::json(['success' => false, 'errors' => $validator->getMessageBag()->toArray()]);
        } else {
            $destinationPath = 'public/uploads/';
            $filename = $file->getClientOriginalName();
            Input::file('image')->move($destinationPath, $filename);
            return Response::json([
                'success' => true,
                'file' => asset($destinationPath . $filename),
            ]);
        }

    }

    public function ajaxUpdateImage()
    {
        if (!Input::get('image')) {
            return Response::json(['success' => false, 'errors' => $validator->getMessageBag()->toArray()]);
        }

        $photo = str_replace(url(), null, Input::get('image'));
        $photo = ltrim($photo, '/');

        $room = Room::find(Input::get('id'));
        $room->photo = $photo;
        $room->save();

        return response()->json([
            'success' => true,
            'saved_photo' => Input::get('image')
        ]);
    }

    public function ajaxRemoveImage()
    {
        if (!Input::get('image')) {
            return Response::json(['success' => false, 'errors' => $validator->getMessageBag()->toArray()]);
        }

        $file = str_replace(url(), null, Input::get('image'));
        $file = ltrim($file, '/');

         File::delete($file);

        return Response::json([
            'success' => true,
            'file' => null,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $addons = Addon::all();
        $Include = StandardInclude::all();
        return view('rooms.create')->with('Addons', $addons)
            ->with('Include', $Include);
    }

    public function edit($id)
    {
        $include = StandardInclude::all();

        $room = Room::findOrFail($id);

        $room_available = Room::with('room_available')->where('id', '=', $id)->get();

        $room_include = \DB::table('include')
            ->join('room', 'include.id', '=', 'room.include_id')
            ->select('include.*')
            ->where('room.id', '=', $room->id)
            ->get();

        $rate = new Rate();
        $rates = $rate->getRateListByRoomId($room->id);

        $rate_include = \DB::table('include')
            ->join('rate', 'include.id', '=', 'rate.include_id')
            ->join('room', 'rate.room_id', '=', 'room.id')
            ->select('include.*')
            ->where('room.id', '=', $room->id)
            ->get();

        $addon = new Addon();
        $addons = $addon->getAllWithAddonRoomMatched($id);

        return
            view('rooms.create')->with(
                [
                    'room' => $room_available,
                    'addons' => $addons,
                    'includes' => $include,
                    'room_include' => $room_include,
                    'rates' => $rates,
                    'rate_include' => $rate_include,
                    'addon_room' => $addons
                ]
            );
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $room_id = $id;

        $room = Room::findOrFail($id);

        $max_room = Input::get('max_room');
        $standard_rate = Input::get('standard_rate');
        $standard_include = Input::get('include');
        $max_capacity = count(Input::get('capacity'));

        /*
         * Update room
         */
        $room = Room::find($room_id);
        $room->max_room = $max_room;
        $room->max_capacity = $max_capacity;
        $room->standard_rate = $standard_rate;
        $room->include_id = $standard_include;

        $room->save();

        /*
         * Update or/and create room available
         */
        if (Input::get('room_available_duration_dates')) {
            $room_available_duration_dates = array_filter(Input::get('room_available_duration_dates'));
            $number_room_available = array_filter(Input::get('number_room_available'));
            $room_available_ids = Input::get('room_available_id');

            foreach ($room_available_duration_dates as $index => $room_available_duration_date) {
                $dates = explode(' - ', $room_available_duration_date);

                $start_date = date('Y-m-d', strtotime(trim($dates[0])));
                $close_date = date('Y-m-d', strtotime(trim($dates[1])));

                $room_available_id = isset($room_available_ids[$index]) ? $room_available_ids[$index] : '50';

                $find_room_available = RoomAvailable::find($room_available_id);

                if(count($find_room_available) > 0) {
                    $room_available = $find_room_available;
                } else {
                    $room_available = new RoomAvailable();
                }

                $room_available->room_id = $room_id;
                $room_available->number_room_available = $number_room_available[$index];
                $room_available->start_date = $start_date;
                $room_available->close_date = $close_date;

                $room_available->save();
            }
        }

        /*
         * Update or/and create rates
         */
        if (Input::get('rate')) {
            $rates = Input::get('rate');

            foreach ($rates as $rate) {
                $rate = explode(',', $rate);

                $dates = explode(' - ', explode('=>', $rate[3])[1]); //duration dates

                $rate_id = (trim(explode('=>', $rate[0])[1]));
                $price = trim(explode('=>', $rate[1])[1]);
                $include_id = trim(explode('=>', $rate[2])[1]);
                $start_date = date('Y-m-d', strtotime(trim($dates[0])));
                $close_date = date('Y-m-d', strtotime(trim($dates[1])));

                $rate = Rate::find($rate_id);

                if ($rate != null) {
                    $rate->room_id = $room_id;
                    $rate->price = $price;
                    $rate->include_id = $include_id;
                    $rate->start_date = $start_date;
                    $rate->close_date = $close_date;

                    $rate->save();
                } else {
                    $rate = new Rate();

                    $rate->room_id = $room_id;
                    $rate->price = $price;
                    $rate->include_id = $include_id;
                    $rate->start_date = $start_date;
                    $rate->close_date = $close_date;

                    $rate->save();
                }
            }
        }

        /*
         * Update or/and create room addons
         */
        if (Input::get('addon_value')) {
            $room_addons = Input::get('addon_value');

            foreach ($room_addons as $room_addon) {
                $addons_value = explode('_', $room_addon);
                $addon_id = trim($addons_value[0]);
                $addon_room_id = trim($addons_value[1]);
                $addon_price = trim($addons_value[2]);

                $addon_room = AddonRoom::find($addon_room_id);

                if ($addon_room != null) {
                    $addon_room->room_id = $room_id;
                    $addon_room->price = $addon_price;
                    $addon_room->addon_id = $addon_id;

                    $addon_room->save();
                } else {
                    $addon_room = new AddonRoom();

                    $addon_room->room_id = $room_id;
                    $addon_room->price = $addon_price;
                    $addon_room->addon_id = $addon_id;

                    $addon_room->save();
                }
            }
        }

        Session::flash('flash_message', 'Room has been updated.');

        return redirect('rooms');
    }

    public function recap()
    {
        $rooms = Room::with('room_available')->get();

        $first_date = date('Y-m-d');
        $last_last = date('Y-m-d', strtotime(date('Y-m-d') . '+14 days'));

        $bookings =
            Booking::where('checkin', '>=', $first_date)
                ->where('checkout', '>=', $last_last)
                ->with('booking_room')
                ->get();

        return view('rooms.recap')->with(
            [
                'rooms' => $rooms,
                'bookings' => $bookings
            ]
        );
    }

}
