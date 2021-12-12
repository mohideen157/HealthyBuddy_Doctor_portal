<?php

namespace App\Model\Orders;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
	 * Get the ordered medicines
	 */
	public function medicines()
	{
		return $this->hasMany('App\Model\Orders\OrderMedicines', 'order_id', 'id');
	}

	/**
	 * Get the ordered labtests
	 */
	public function labtests()
	{
		return $this->hasMany('App\Model\Orders\OrderLabTests', 'order_id', 'id');
	}
}
