<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
	protected $fillable = [
		'afib',
		'arrhythmia',
		'artrialage',
		'bp',
		'hrvlevel',
		'hr',
		'rpwv',
		'synched',
		'date',
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
