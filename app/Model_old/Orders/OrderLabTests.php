<?php

namespace App\Model\Orders;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class OrderLabTests extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_lab_tests';

    /**
	 * Get the order
	 */
	public function order()
	{
		return $this->belongsTo('App\Model\Orders\Order', 'order_id', 'id');
	}


    /**
     * Return Test Date and Time as a carbon object
     */
    public function getDateTimeAttribute(){
        return Carbon::parse($this->attributes['test_date'].' '.$this->attributes['test_time']);
    }
}
