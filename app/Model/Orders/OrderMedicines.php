<?php

namespace App\Model\Orders;

use Illuminate\Database\Eloquent\Model;

class OrderMedicines extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_medicines';

    /**
	 * Get the order
	 */
	public function order()
	{
		return $this->belongsTo('App\Model\Orders\Order', 'order_id', 'id');
	}
}
