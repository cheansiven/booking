<?php namespace App\Http\Controllers;

use App\Addon;
use App\AddonRoom;
use App\Booking;
use App\BookingRoom;
use App\BookingRoomAddon;
use App\Http\Requests;
use App\Rate;
use App\Room;
use App\StandardInclude;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Mail;

class BookingController extends Controller
{

    public function index()
    {
        $room = new Room();
        $rooms = $room->getRoomList('today');

        $includes = StandardInclude::all();
        $rates = Rate::all();
        $addons = Addon::all();

        $addons_room = new AddonRoom();
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

    private function calcTotalNights($checkin, $checkout)
    {
        $ts1 = strtotime($checkin);
        $ts2 = strtotime($checkout);

        return (($ts2 - $ts1) / 3600 / 24) + 1;
    }

    public function calcRoomPrice()
    {
        $checkin = date('Y-m-d', strtotime(Input::get('checkin')));
        $checkout = date('Y-m-d', strtotime(Input::get('checkout')));
        $id = Input::get('id');

        $room = Room::find($id);
        $standard_price = $room->standard_rate;

        $room = new Room();
        $calculated_prices = $room->getPromoBetweenDates($checkin, $checkout, $id);
        if(count($calculated_prices) > 0) {
            $promo_start_date = $calculated_prices[0]['promo_start_date'];
            $promo_close_date = $calculated_prices[0]['promo_close_date'];
            $promo_price = $calculated_prices[0]['price'];

            if ($checkin >= $promo_start_date) {
                if ($checkout <= $promo_close_date) {
                    $data['in_promo'] = [
                        'dates' => [$checkin, $checkout],
                        'total_nights' => $this->calcTotalNights($checkin, $checkout),
                        'price' => $promo_price
                    ];
                } else {
                    $data['in_promo'] = [
                        'dates' => [$checkin, $promo_close_date],
                        'total_nights' => $this->calcTotalNights($checkin, $promo_close_date),
                        'price' => $promo_price
                    ];
                    $data['after_promo'] = [
                         'dates' => [
                            date('Y-m-d', strtotime($promo_close_date . "+1 days")),
                            $checkout
                        ],
                        'total_nights' => $this->calcTotalNights(date('Y-m-d', strtotime($promo_close_date . "+1 days")), $checkout),
                        'price' => $standard_price
                    ];
                }
            } else {
                $data['before_promo'] = [
                    'dates' => [
                        $checkin,
                        date('Y-m-d', strtotime($promo_start_date . "-1 days"))
                    ],
                    'total_nights' => $this->calcTotalNights($checkin, date('Y-m-d', strtotime($promo_start_date . "-1 days"))),
                    'price' => $standard_price
                ];
                if ($checkout <= $promo_close_date) {
                    $data['in_promo'] = [
                        'dates' => [$promo_start_date, $checkout],
                        'total_nights' => $this->calcTotalNights($promo_start_date, $checkout),
                        'price' => $promo_price
                    ];
                } else {
                    $data['in_promo'] = [
                        'dates' => [$promo_start_date, $promo_close_date],
                        'total_nights' => $this->calcTotalNights($promo_close_date, $promo_close_date),
                        'price' => $promo_price
                    ];
                    $data['after_promo'] = [
                        'dates' => [
                            date('Y-m-d', strtotime($promo_close_date . "+1 days")),
                            $checkout
                        ],
                        'total_nights' => ($this->calcTotalNights(date('Y-m-d', strtotime($promo_close_date . "+1 days")), $checkout)),
                        'price' => $standard_price
                    ];
                }
            }
        } else {
            $data['no_promo'] = [
                'dates' => [$checkin, $checkout],
                'total_nights' => $this->calcTotalNights($checkin, $checkout),
                'price' => $standard_price
            ];
        }

        return Response::json([
            'success' => true,
            'datas' => $data
        ]);
    }

    public function confirm($id)
    {
        $booking = Booking::find($id);
        $booking_rooms = new BookingRoom();

        $booking_rooms = $booking_rooms->getGroupedRoomByBookingId($id);

        return view('frontend.confirm')
            ->with('status', $booking->status)
            ->with('firstname', $booking->firstname)
            ->with('lastname', $booking->lastname)
            ->with('email', $booking->email)
            ->with('country', $booking->country)
            ->with('checkin', $booking->checkin)
            ->with('checkout', $booking->checkout)
            ->with('totalnight', $booking->total_nights)
            ->with('totalrooms', $booking->total_rooms)
            ->with('totalprice', $booking->total_price)
            ->with('booking_rooms', $booking_rooms);
    }

    public function store()
    {
        $status = Input::get('status');
        $firstname = Input::get('firstname');
        $lastname = Input::get('lastname');
        $email = Input::get('email');
        $contact_phone = Input::get('contact_phone');
        $country = Input::get('country');
        $number_of_guests = Input::get('number_of_guests');
        $checkin = Input::get('checkin');
        $checkout = Input::get('checkout');
        $total_nights = Input::get('total_nights');
        $total_rooms = Input::get('total_rooms');
        $total_price = Input::get('total_price_all_rooms');
        $first_time_guest = Input::exists('first_time_guest');

        $room_with_addons = Input::get('room_with_addons');

        /*
         * Insert booking
         */
        $booking_id_inserted = Booking::create([
            'status' => $status,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'contact_phone' => $contact_phone,
            'country' => $country,
            'number_of_guests' => $number_of_guests,
            'checkin' => date('Y-m-d', strtotime($checkin)),
            'checkout' => date('Y-m-d', strtotime($checkout)),
            'total_nights' => (int)$total_nights,
            'total_rooms' => (int)$total_rooms,
            'total_price' => (double)$total_price,
            'first_time_guest' => $first_time_guest,
        ])->id; //id of last inserted booking id

        foreach ($room_with_addons as $values) {
            $string_exploded = explode('=>', rtrim($values, ','));

            $room_id = $string_exploded[0];

            /*
             * Insert booking rooms
             */
            $booking_room_insert_id = BookingRoom::create([
                'booking_id' => $booking_id_inserted,
                'room_id' => $room_id
            ])->id; //id of last inserted booking room

            $room_addons = explode(',', rtrim($string_exploded[1], ','));
            foreach ($room_addons as $addon_id) {

                if ($addon_id) {

                    /*
                     * Insert booking room addons
                     */
                    BookingRoomAddon::create([
                        'booking_room_id' => $booking_room_insert_id,
                        'addon_id' => $addon_id
                    ]);
                }
            }
        }

        $this->sendConfirmEmail($booking_id_inserted);

        return redirect('confirm/' . $booking_id_inserted);
    }

    private function sendConfirmEmail($booking_id)
    {
        $booking = Booking::find($booking_id);
        $booking_rooms = new BookingRoom();

        $booking_rooms = $booking_rooms->getGroupedRoomByBookingId($booking_id);

        $data = [
            'status' => $booking->status,
            'firstname' => $booking->firstname,
            'lastname' => $booking->lastname,
            'email' => $booking->email,
            'country' => $booking->country,
            'checkin' => $booking->checkin,
            'checkout' => $booking->checkout,
            'totalnight' => $booking->total_nights,
            'totalrooms' => $booking->total_rooms,
            'totalprice' => $booking->total_price,
            'booking_rooms' => $booking_rooms
        ];

        $email = $booking->email;

        return Mail::send('frontend.confirm',
            $data, function ($message) use ($email){
                $message->to($email)->subject('Booking Confirmation');
            });

    }

}
