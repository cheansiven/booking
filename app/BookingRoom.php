<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BookingRoom extends Model
{

    protected $table = 'booking_room';
    protected $fillable = ['booking_id', 'room_id'];

    public function room()
    {
        return $this->belongsTo('App\Room');
    }

    public function getRooms()
    {
        return $this->room;
    }

    public function booking_room_addon()
    {
        return $this->hasMany('App\BookingRoomAddon');
    }

    public function booking()
    {
        return $this->belongsTo('App\Booking');
    }

    public function getBooking() {
        return $this->booking;
    }

    public function getBookingRoomAddons()
    {
        return $this->booking_room_addon;
    }

    public function getGroupedRoomByBookingId($id)
    {
        return
            DB::table('booking_room')
                ->select(
                    'booking_id',
                    'room.name',
                    DB::raw('count(*) as total_room')
                )
                ->join('room', 'room.id', '=', 'booking_room.room_id')
                ->groupBy('booking_room.booking_id', 'booking_room.room_id')
                ->where('booking_room.booking_id', '=', $id)
                ->get();
    }

}
