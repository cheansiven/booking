<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Addon extends Model
{

    protected $table = 'addon';
    protected $fillable = ['name', 'des'];

    public function addon_room()
    {
        return $this->hasMany('App\AddonRoom');
    }

    public function getPrice($room_id = null)
    {
        if($room_id != null) {
            foreach($this->addon_room as $addon_room) {
                if($addon_room == $room_id) {
                    return $addon_room->price;
                }
            }
        }

        return $this->addon_room[0]->price;
    }

    public function booking_addon_room()
    {
        return $this->hasMany('App\AddonRoom');
    }

    public function getAllWithAddonRoomMatched($room_id)
    {
        return
            DB::table('addon')
                ->select(
                    'addon.id',
                    'addon_room.id as addon_room_id',
                    'addon_room.room_id',
                    'addon.name',
                    'addon_room.price'
                )
                ->leftJoin('addon_room', function ($join) use ($room_id) {
                    $join
                        ->on('addon_room.addon_id', '=', 'addon.id')
                        ->on('addon_room.room_id', '=', DB::raw($room_id));
                })
                ->orderBy('addon.name', 'asc')
                ->get();
    }

}
