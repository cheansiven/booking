<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingRoomAddon extends Model
{

    protected $table = 'booking_room_addon';
    protected $fillable = ['booking_room_id', 'addon_id'];

    public function booking_room()
    {
        return $this->belongsTo('App\BookingRoom');
    }

    public function addon()
    {
        return $this->belongsTo('App\Addon');
    }

    public function getAddon()
    {
        return $this->addon;
    }

    public function getAddonName()
    {
        return $this->addon->name;
    }

}
