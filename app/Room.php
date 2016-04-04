<?php
namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\RoomAvailable;
use Illuminate\Support\Facades\Event;

class Room extends Model
{

    protected $table = 'room';

    protected $primaryKey = 'id';

    protected $fillable = ['name', 'max_room', 'max_capacity', 'standard_rate', 'include_id'];

    public function room_available()
    {
        return $this->hasMany('App\RoomAvailable');
    }

    public function booking_room()
    {
        return $this->hasMany('App\BookingRoom');
    }

    /**
     * @param string $display_by today|this-week|this-month|all
     * @return mixed
     */
    public function getRoomList($display_by = 'today')
    {

        $display_by_clause = "(rate.start_date <= CURRENT_DATE and rate.close_date >= CURRENT_DATE)";

        if ($display_by == 'this-week') {
            $display_by_clause = "WEEKOFYEAR(rate.start_date) <= WEEKOFYEAR(now()) and WEEKOFYEAR(rate.close_date) >= WEEKOFYEAR(now())";
        } else if ($display_by == 'this-month') {
            $display_by_clause = "MONTH(rate.start_date) <= MONTH(now()) and MONTH(rate.close_date) >= MONTH(now())";
        } else if ($display_by == 'all') {
            $display_by_clause = "1";
        }

        return
            DB::table('room')
                ->select(
                    'room.id',
                    'room.name',
                    'room.photo',
                    'room.standard_rate',
                    'rate.price',
                    'rate.start_date as promotion_start_date',
                    'rate.close_date as promotion_close_date'
                )
                ->selectRaw('ifnull(room_available.number_room_available, room.max_room) as number_room_available')
                ->selectRaw('ifnull(rate.price, room.standard_rate) as current_rate')
                ->selectRaw('ifnull(booking_room.number_booked_room, "-") as number_booked_room')
                ->leftJoin('rate', function ($join) use ($display_by_clause) {
                    $join
                        ->on('rate.room_id', '=', 'room.id')
                        ->on(DB::raw($display_by_clause), DB::raw(''), DB::raw(''));
                })
                ->leftJoin('room_available', function ($join) {
                    $join
                        ->on('room_available.room_id', '=', 'room.id')
                        ->on(DB::raw('CURDATE() between room_available.start_date and room_available.close_date'), DB::raw(''), DB::raw(''));
                })
                ->leftJoin(DB::raw('(select room_id, count(*) as number_booked_room from booking_room group by room_id) as booking_room'), function ($join) {
                    $join->on('booking_room.room_id', '=', 'room.id');
                })
                ->groupBy('room.id')
                ->orderBy('room.id')
                ->get();
    }

    /**
     * @param $date1
     * @param $date2
     * @param $id
     */
    public function getPromoBetweenDates($date1, $date2, $id)
    {
        return
            DB::select(
                DB::raw("select price, start_date as promo_start_date, close_date as promo_close_date from rate where ((:checkin1 between start_date and close_date) or (:checkout1  between start_date and close_date) or (start_date between :checkin2 and :checkout2) or (close_date between :checkin3 and :checkout3)) and room_id = :id"), [
                    $date1,
                    $date2,
                    $date1,
                    $date2,
                    $date1,
                    $date2,
                    $id
                ]
            );

    }


}
