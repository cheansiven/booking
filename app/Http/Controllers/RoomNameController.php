<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Room as Room;
use App\RoomName as RoomName;
use App\Addon as Addon;
use App\Include_Model as Includes;
use App\Rate as Rate;
use App\Addon_Rate as AddonRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class RoomNameController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index()
    {
        $RoomName = RoomName::all();
        return view('rooms.index')->with('RoomName', $RoomName);
    }

    public function edit($id)
    {
        $Addons = Addon::all();
        $Include = Includes::all();
        $RoomName = RoomName::findOrFail($id);
        $Room = \DB::table('room')
            ->select('room.*')
            ->where('room.name', '=', $RoomName->name)
            ->get();

        $Room_Include = \DB::table('include')
            ->join('room', 'include.id', '=', 'room.include_id')
            ->select('include.*')
            ->where('room.name', '=', $RoomName->name)
            ->get();

        $Rate = \DB::table('rate')
            ->select('rate.*')
            ->where('rate.room_id', '=', $RoomName->id)
            ->get();

        $Rate_Include = \DB::table('include')
            ->join('rate', 'include.id', '=', 'rate.include_id')
            ->join('room', 'rate.room_id', '=', 'room.id')
            ->select('include.*')
            ->where('room.name', '=', $RoomName->name)
            ->get();
        $Addon_Room = \DB::table('addon_rate')
            ->select('addon_rate.*')
            ->where('addon_rate.room_id', '=', $RoomName->id)
            ->get();

        return view('rooms.create', compact('RoomName'))->with('Room', $Room)
            ->with('Addons', $Addons)
            ->with('Include', $Include)
            ->with('Room_Include', $Room_Include)
            ->with('Rate', $Rate)
            ->with('Rate_Include', $Rate_Include)
            ->with('Addon_Room', $Addon_Room);
    }

    public function update($id, Request $request)
    {
        $RoomName = RoomName::findOrFail($id);
        $max_num = Input::get('max_num');
        $standard_rate = Input::get('standard_rate');
        $include = Input::get('include');
        $max_capacity = Input::get('capacity');
        //////////// Price & Rate \\\\\\\\\\\\\\\\\\\
        $set_price = Input::get('set_price');
        $set_percent = Input::get('set_percent');
        $rate_inc = Input::get('rate_inc');
        $datefilter = Input::get('datefilter');
        for ($i = 0; $i < count($datefilter); $i++) {
            $date[] = explode("-", $datefilter[$i]);
        }
        //	$date = explode("-",$datefilter);
        //////////// Avaliable Rooms \\\\\\\\\\\\
        $num_ava_room = Input::get('num_ava_room');
        /////////// Addon \\\\\\\\\\\\\\\\\\\\
        $addon_name = Input::get('addon_name');
        $RoomDelete = \DB::table('room')
            ->select('room.*')
            ->where('room.name', '=', $RoomName->name)
            ->delete();
        $Room_IncludeDelete = \DB::table('include')
            ->join('room', 'include.id', '=', 'room.include_id')
            ->select('include.*')
            ->where('room.name', '=', $RoomName->name)
            ->delete();

        $RateDelete = \DB::table('rate')
            ->select('rate.*')
            ->where('rate.room_id', '=', $RoomName->id)
            ->delete();

        $Rate_IncludeDelete = \DB::table('include')
            ->join('rate', 'include.id', '=', 'rate.include_id')
            ->join('room', 'rate.room_id', '=', 'room.id')
            ->select('include.*')
            ->where('room.name', '=', $RoomName->name)
            ->delete();
        $Addon_RoomDelete = \DB::table('addon_rate')
            ->select('addon_rate.*')
            ->where('addon_rate.room_id', '=', $RoomName->id)
            ->delete();
        Room::create(['name' => $RoomName->name,
            'max_room' => $max_num,
            'max_capacity' => count($max_capacity),
            'standard_rate' => $standard_rate,
            'include_id' => $include,
        ]);
        if (count($datefilter) > 0) {
            for ($i = 0; $i < count($datefilter); $i++) {
                $inc_id = $i + 1;
                Rate::create(['price' => $set_price[$i],
                    'percentage' => $set_percent[$i],
                    'room_avaiable' => $num_ava_room[$i],
                    'start_date' => $date[$i][0],
                    'close_date' => $date[$i][1],
                    'achive' => 0,
                    'include_id' => (int)Input::get("rate_inc$inc_id"),
                    'room_id' => $id,
                ]);
            }
        }

        for ($i = 0; $i < count($addon_name); $i++) {
            if ($addon_name[$i] != "") {
                AddonRate::create([
                    'room_id' => $id,
                    'addon_id' => $i,
                    'rate' => $addon_name[$i],
                ]);
            }
        }

        \Session::flash('flash_message', 'Room has been updated.');
        return redirect('rooms');
    }
}
