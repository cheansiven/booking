<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomAvailable extends Model {

	protected $table = 'room_available';

    protected $primaryKey = 'id';

    protected $fillable = ['number_room_available', 'room_id', 'created_at', 'updated_at', 'start_date', 'close_date'];

    public function room()
    {
        return $this->belongsTo('App\Room');
    }

}
