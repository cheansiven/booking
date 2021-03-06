<?php namespace App\Http\Controllers;

use App\Addon_Room;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Room as Room;
use App\RoomName as RoomName;
use App\Addon as Addon;
use App\Include_Model as Includes;
use App\Rate as Rate;
use App\Addon_Room as AddonRoom;
use App\BookingUser as BookingUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class FrontendController extends Controller
{

    public function index()
    {
        $room = new Room();
        $rooms = $room->getRoomWithRateList('all');

        dd($rooms);

        $includes = Includes::all();
        $rates = Rate::all();
        $addons = Addon::all();

        $addons_room = new Addon_Room();
        $addons_room = $addons_room->allWithName();;

        return view('frontend.index')
            ->with(
                [
                    'rooms' => $rooms,
                    'includes' => $includes,
                    'rates' => $rates,
                    'addons' => $addons,
                    'addons_room' => $addons_room
                ]
            );
    }


    public function store()
    {
        $status = Input::get('status');
        $firstname = Input::get('firstname');
        $lastname = Input::get('lastname');
        $email = Input::get('email');
        $country = Input::get('country');
        $checkin = Input::get('checkin');
        $checkout = Input::get('checkout');
        $totalnight = Input::get('totalnight');
        $totalrooms = Input::get('totalrooms');
        $totalprice = Input::get('totalprice');
        $room1 = Input::get('room1');
        $room2 = Input::get('room2');
        $room3 = Input::get('room3');
        BookingUser::create(['status' => $status,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'country' => $country,
            'checkin' => $checkin,
            'checkout' => $checkout,
            'totalnight' => (int)$totalnight,
            'totalrooms' => (int)$totalrooms,
            'totalprice' => (int)$totalprice,
        ]);
        $data = array('status' => $status,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'checkin' => $checkin,
            'checkout' => $checkout,
            'room1' => $room1,
            'room2' => $room2,
            'room3' => $room3,
            'totalnight' => $totalnight,
            'totalrooms' => $totalrooms,
            'totalprice' => $totalprice

        );

        \Mail::send('email_confirm.index',
            $data, function ($message) {
                $message->to(Input::get('email'))->bcc('info@lox-design.com', 'Lox-Design')->subject('Booking Confirmation');
            });

        /*		\Mail::send('admin_email',
                    $data, function($message)
                    {
                        $message->to('info@crystaltours.travel')->subject('Visa Team');
                    });*/

        return view('frontend.confirm')->with('status', $status)
            ->with('firstname', $firstname)
            ->with('lastname', $lastname)
            ->with('email', $email)
            ->with('country', $country)
            ->with('checkin', $checkin)
            ->with('checkout', $checkout)
            ->with('room1', $room1)
            ->with('room2', $room2)
            ->with('room3', $room3)
            ->with('totalnight', $totalnight)
            ->with('totalrooms', $totalrooms)
            ->with('totalprice', $totalprice);


    }


}
