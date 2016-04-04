<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{

    protected $table = 'booking';

    protected $fillable = [
        'status',
        'firstname',
        'lastname',
        'email',
        'contact_phone',
        'country',
        'number_of_guests',
        'checkin',
        'checkout',
        'total_nights',
        'total_rooms',
        'total_price',
        'first_time_guest',
        'is_paid'
    ];

    protected $appends = ['booking_room_addon'];

    public function booking_room()
    {
        return $this->hasMany('App\BookingRoom');
    }

}
