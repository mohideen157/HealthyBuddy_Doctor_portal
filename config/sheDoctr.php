<?php

return [
	'mVayoo' => [
		'user' => 'surendrainfosys@gmail.com',
		'pass' => 'Veda@2006',
		'senderID' => 'SHEDOC',
		'pretend' => false,
		'allow_send' => true,
		//'pretend_to' => '9873894001'
	],
	'webapp' => [
		'url' => 'http://bit.ly/2kBRQOc',
		'code_expiry' => 60,
		'time_slot_expiry' => 15, // Limit for Advance Bookings,
		'temp_booking_expiry' => 15, // Limit For Temp Bookings
		'payment_pending_booking_expiry' => 15, // Limit for bookings that are payment pending
		'booking_buffer' => 10
	],
	'db' => [
		'doctorPrefix' => 'C2PDR',
		'patientPrefix' => 'C2PPAT',
		'organisationPrefix' => 'C2PORG',
		'tenantPrefix' => 'C2PTEN',
		'receptionistPrefix' => 'SHDCTRRC',
		'appointmentPrefix' => 'SHDCTRAP',
		'medicineOrderPrefix' => 'SHDCTRMO',
		'labTestOrderPrefix' => 'SHDCTRLO',
		'numberLength' => '6'
	]
];