<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use App\Helpers\Helper;

use Mail;
use URL;

class VerificationCodes extends Model
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'verification_codes';

	public static function sendActivationMail($user, $token){
		if ($user->active == 1) {
			$user->active = 0;
			$user->save();
		}

		$email = $user->email;
		$name = $user->name;
		$mobileno = $user->mobile_no;

		$verification_code = new VerificationCodes();
		$verification_code->sent_to = $email;
		$verification_code->type = 'email';
		$verification_code->code = $token;
		$verification_code->save();

		$link = 'account/activate/'.$token;

		$data = array(
			'email' => $email,
			'name' => $name,
			'link' => $link
		);

		// Send Mail
		$sendemail = Mail::send('emails.account.activate', $data, function ($message) use ($data)
		{
			$message->to($data['email'], $data['name']);
			$message->subject('Activate your SheDoctr account');
		});

		// Send SMS
		$msgtxt = "Welcome to SheDoctr.com Activation link has been sent to : ".$data['email'];

		$msgData = array(
			'recipient_no' => $mobileno,
			'msgtxt' => $msgtxt
		);

		$sendsms = Helper::sendSMS($msgData);
 
		return $verification_code;
	}
}
