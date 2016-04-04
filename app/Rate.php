<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Rate extends Model
{

    protected $table = 'rate';
    protected $fillable = ['price', 'percentage', 'room_avaiable', 'start_date', 'close_date', 'achive', 'include_id', 'room_id'];

    public function getRateListByRoomId($id)
    {
        return
            DB::table('rate')
                ->select('rate.*')
                ->where('rate.room_id', '=', $id)
                ->get();
    }

}
