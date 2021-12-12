<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'notifications';

	/**
	 * Get the user
	 */
	public function user()
	{
		return $this->belongsTo('App\User', 'user_id', 'id');
	}

	public function scopeUnread($query)
	{
		return $query->where('is_read', '=', 0);
	}

	/**
	 * Create the notification
	 */
	public function withSubject($subject)
	{
		$this->subject = $subject; 
		return $this;
	}
 
	public function withBody($body)
	{
		$this->body = $body; 
		return $this;
	}
 
	public function withType($type)
	{
		$this->type = $type; 
		return $this;
	}
 
	public function regarding($object)
	{
		if(is_object($object))
		{
			$this->object_id   = $object->id;
			$this->object_type = get_class($object);
		}
 
		return $this;
	}
 
	public function deliver()
	{
		$this->save(); 
		return $this;
	}
}
