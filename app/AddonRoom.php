<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AddonRoom extends Model
{

    protected $table = 'addon_room';
    protected $fillable = ['room_id', 'addon_id', 'rate'];

    public function room()
    {
        return $this->belongsTo('App\Room');
    }

    public function addon()
    {
        return $this->belongsTo('App\Addon');
    }

    public function allWithName()
    {
        return
            DB::table('addon_room')
                ->select(
                    'addon_room.id',
                    'addon_room.addon_id',
                    'addon_room.room_id',
                    'addon.name',
                    'addon_room.price'
                )
                ->join('addon', 'addon.id', '=', 'addon_room.addon_id')
                ->get();
    }

}
