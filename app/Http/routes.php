<?php error_reporting(E_ALL);
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
	return view('shedoctr_welcome');
})->name('/');

Route::get('{slug?}/login', 'Auth\AuthController@showLoginForm')->middleware('slugCheck');

Route::redirect('/login', '/');

Route::post('login', 'Auth\AuthController@login');
Route::get('logout', 'Auth\AuthController@logout');
Route::get('account/activate/{token}', 'AppAuthController@activateAccount');

//Routes written by shanu
Route::get('reset-password/{token}', "ResetPasswordController@show")->name('reset.password');
Route::post('reset-password', 'ResetPasswordController@store')->name('reset.password.store');

Route::group(['prefix' => 'admin','middleware'=>['auth', 'isAdmin']], function(){
	Route::get('/','Admin\AdminController@index')->name('admin');
	Route::resource('coupon','Admin\AdminCoupanController');
	Route::get('coupon/{id}/status','Admin\AdminCoupanController@status');
	// Specialty
	Route::resource('specialty','Admin\AdminSpecialtyController');

	// Symptoms
	Route::resource('symptom','Admin\AdminSymptomController');

	// Settings
	Route::resource('settings','Admin\AdminSettingsController', ['except' => ['create', 'show', 'destroy']]);

	// Medicine Type
	Route::resource('medicine-types','Admin\AdminMedicineTypeController', ['except' => ['create', 'show', 'edit']]);

	// Languages
	Route::resource('languages','Admin\AdminLanguageController', ['except' => ['create', 'show', 'edit']]);

	//Doctor
    Route::get('doctors/appointmentslist', 'Admin\AdminDoctorController@appointmentslist');
	Route::get('doctors/inactive', 'Admin\AdminDoctorController@inactiveDoctors');
	Route::get('doctors/active', 'Admin\AdminDoctorController@activeDoctors');
    Route::get('doctors/specialty_list', 'Admin\AdminDoctorController@specialty_list');
	Route::get('doctors/approve', 'Admin\AdminDoctorController@approve');
	Route::get('doctors/activate', 'Admin\AdminDoctorController@activate');
	Route::get('doctors/deactivate', 'Admin\AdminDoctorController@deactivate');
	Route::get('doctors/showOnHomepage', 'Admin\AdminDoctorController@showOnHomepage');
	Route::get('doctors/removeFromHomepage', 'Admin\AdminDoctorController@removeFromHomepage');
	Route::get('doctors/markPriority', 'Admin\AdminDoctorController@markPriority');
	Route::get('doctors/unmarkPriority', 'Admin\AdminDoctorController@unmarkPriority');
	Route::put('doctors/documents', 'Admin\AdminDoctorController@documentStatusUpdate');

	Route::get('doctors/{id}/commission-slab', 'Admin\AdminDoctorController@commissionSlab');
	Route::put('doctors/commission-slab/{id}', 'Admin\AdminDoctorController@updateCommissionSlab');

	Route::get('doctors/ledger', 'Admin\AdminDoctorLedgerController@index');
	Route::get('doctors/{id}/ledger', 'Admin\AdminDoctorLedgerController@show');

	Route::get('doctors/{id}/bank-details', 'Admin\AdminDoctorBankDetailsController@show');
	Route::get('doctors/{id}/profile', 'Admin\AdminDoctorController@show');

	// Route::get('create-ledger', 'Admin\AdminDoctorLedgerController@createLedger');

	//Doctor
	Route::get('articles/inactive', 'Admin\AdminArticlesController@inactiveArticles');
	Route::get('articles/active', 'Admin\AdminArticlesController@activeArticles');
	Route::get('articles/activate', 'Admin\AdminArticlesController@activate');
	Route::get('articles/deactivate', 'Admin\AdminArticlesController@deactivate');
	Route::get('articles/{id}', 'Admin\AdminArticlesController@show');
	Route::post('articles/update-image/{id}', 'Admin\AdminArticlesController@updateArticleImage');

	// Payments
	Route::resource('payments','Admin\AdminPaymentsController', ['except' => ['show', 'delete']]);

	// Notifications
	Route::get('notifications', 'Admin\AdminNotificationsController@index');
	Route::put('notifications/{id}/clear', 'Admin\AdminNotificationsController@clear');
	Route::put('notifications/clear-all', 'Admin\AdminNotificationsController@clearAll');

	// Medicine Order
	Route::get('medicine-orders', 'Admin\AdminMedicineOrdersController@index');
	Route::get('medicine-order/{id}', 'Admin\AdminMedicineOrdersController@show');
	Route::get('medicine-order/{id}/prescription', 'Admin\AdminMedicineOrdersController@prescription');
	Route::put('medicine-order/{id}', 'Admin\AdminMedicineOrdersController@update');

	// Lab Test Order
	Route::get('lab-test-orders', 'Admin\AdminLabTestOrdersController@index');
	Route::get('lab-test-order/{id}', 'Admin\AdminLabTestOrdersController@show');
	Route::get('lab-test-order/{id}/prescription', 'Admin\AdminLabTestOrdersController@prescription');
	Route::put('lab-test-order/{id}', 'Admin\AdminLabTestOrdersController@update');

	// Feedback
	Route::get('feedback', 'Admin\AdminFeedbackController@index');
	Route::get('call-feedback', 'Admin\AdminCallFeedbackController@index');

	// Fee Slabs
	Route::resource('cancel-fee-slabs', 'Admin\AdminCancelSlabsController', ['except' => ['create', 'show']]);
	Route::resource('reschedule-fee-slabs', 'Admin\AdminRescheduleSlabsController', ['except' => ['create', 'show']]);
	Route::resource('doctor-commission-slabs', 'Admin\AdminDoctorCommissionSlabController', ['except' => ['create', 'show']]);

	// Patients
	Route::get('patients', 'Admin\AdminPatientController@index');
	Route::get('patients/activate', 'Admin\AdminPatientController@activate');
	Route::get('patients/deactivate', 'Admin\AdminPatientController@deactivate');
	Route::get('patient/{id}/credits', 'Admin\AdminPatientCreditsController@edit');
	Route::put('patient/{id}/credits', 'Admin\AdminPatientCreditsController@update');

	// User
	Route::get('user/{id}/edit', 'Admin\AdminUserController@edit');
	Route::put('user/{id}', 'Admin\AdminUserController@update');
	Route::resource('promo-code-banner', 'Admin\AdminPromoCodeBannerController');

	//Route addded by shanu
	//Tenants
	Route::get('tenant', 'Admin\AdminTenantController@index')->name('admin.tenant');
	Route::get('tenant/create', 'Admin\AdminTenantController@create')->name('admin.tenant.create');
	Route::post('tenant/store', 'Admin\AdminTenantController@store')->name('admin.tenant.store');
	Route::get('tenant/delete', 'Admin\AdminTenantController@delete')->name('admin.tenant.delete');
	Route::get('tenant/edit/{id}', 'Admin\AdminTenantController@edit')->name('admin.tenant.edit');
	Route::post('tenant/update/{id}', 'Admin\AdminTenantController@update')->name('admin.tenant.update');

	//Expertise
	Route::get('expertise', 'Admin\AdminExpertiseController@index')->name('admin.expertise');
	Route::post('expertise/create', 'Admin\AdminExpertiseController@create')->name('admin.expertise.create');
	Route::get('expertise/delete', 'Admin\AdminExpertiseController@delete')->name('admin.expertise.delete');

	//Doctor
	Route::get('doctor', 'Admin\DoctorController@index')->name('admin.doctor');
	Route::get('doctor/create', 'Admin\DoctorController@create')->name('admin.doctor.create');
	Route::post('doctor/store', 'Admin\DoctorController@store')->name('admin.doctor.store');
	Route::get('doctor/delete', 'Admin\DoctorController@delete')->name('admin.doctor.delete');
	Route::get('doctor/edit/{id}', 'Admin\DoctorController@edit')->name('admin.doctor.edit');
	Route::post('doctor/update/{id}', 'Admin\DoctorController@update')->name('admin.doctor.update');

	//Organisation
	Route::get('organisation', 'Admin\AdminOrganisationController@index')->name('admin.organisation');
	Route::get('organisation/edit/{id}', 'Admin\AdminOrganisationController@edit')->name('admin.organisation.edit');
	Route::post('organisation/update/{id}', 'Admin\AdminOrganisationController@update')->name('admin.organisation.update');
	Route::get('organisation/delete', 'Admin\AdminOrganisationController@delete')->name('admin.organisation.delete');


	//Assign doctor to organisation
	Route::get('assign/doctor', 'Admin\AssignDoctorController@index')->name('admin.assign.doctor');
	Route::post('assign/doctor', 'Admin\AssignDoctorController@store')->name('admin.assign.doctor.store');
	Route::get('assign/doctor/delete', 'Admin\AssignDoctorController@delete')->name('admin.assign.doctor.delete');

	//Patient profile
	Route::get('patient-profile', 'Admin\PatientProfileController@index')->name('admin.patient.profile');
	Route::get('patient-profile/filter/afib', 'Admin\PatientProfileController@filter_by_afib')->name('admin.patient.profile.filter.afib');
	Route::get('patient-profile/filter/arrhythmia', 'Admin\PatientProfileController@filter_by_arrhythmia')->name('admin.patient.profile.filter.arrhythmia');
	Route::get('patient-profile/filter/abnormal', 'Admin\PatientProfileController@filter_abnormal')->name('admin.patient.profile.filter.abnormal');

	//History
	// Route::get('history', 'Admin\AdminHistoryController@index')->name('admin.history');
	// Route::get('history/detail/{user}', 'Admin\AdminHistoryController@show')->name('admin.history.show');
	// Route::get('history/graph/{history}', 'Admin\AdminHistoryController@graph')->name('admin.history.graph');

	// Advice To User
	Route::post('patient/advice', 'Admin\PatientAdviceController@store')->name('admin.patient.advise.store');

	//Routes for Article
	Route::get('article', 'Admin\ArticleController@index')->name('admin.article');
	Route::get('article/create', 'Admin\ArticleController@create')->name('admin.article.create');
	Route::post('article/store', 'Admin\ArticleController@store')->name('admin.article.store');
	Route::get('article/edit/{id}', 'Admin\ArticleController@edit')->name('admin.article.edit');
	Route::post('article/update/{id}', 'Admin\ArticleController@update')->name('admin.article.update');
	Route::get('article/delete', 'Admin\ArticleController@delete')->name('admin.article.delete');

    //Routes for covid19
	Route::get('covid19', 'Admin\AdminCovidController@index')->name('admin.covid');

    Route::get('medcheck', 'Admin\AdminPatientMedcheckReadingController@index')->name('admin.medcheck');

    Route::get('medcheck/show/{id}','Admin\AdminPatientMedcheckReadingController@show')->name('admin.medcheck.show');

    Route::get('medcheck/store/{id}','Admin\AdminPatientMedcheckReadingController@store')->name('admin.medcheck.store');




	
});


// All route for organisation
Route::group(['middleware' => 'isOrganisation', 'prefix' => 'organisation'], function(){
	Route::get('dashboard', 'Organisation\HomeController@index')->name('organisation.home');

	// Patient profile
	Route::get('patient-profile', 'Organisation\PatientProfileController@index')->name('organisation.patient.profile');
	Route::get('patient-profile/filter/afib', 'Organisation\PatientProfileController@filter_by_afib')->name('organisation.patient.profile.filter.afib');
	Route::get('patient-profile/filter/arrhythmia', 'Organisation\PatientProfileController@filter_by_arrhythmia')->name('organisation.patient.profile.filter.arrhythmia');
	Route::get('patient-profile/filter/abnormal', 'Organisation\PatientProfileController@filter_abnormal')->name('organisation.patient.profile.filter.abnormal');
});

// All route for doctor
Route::group(['middleware' => 'isDoctor', 'prefix' => 'doctor'], function(){
 
	Route::get('dashboard', 'Doctor\HomeController@index');
	// Patient profile
	Route::get('patient-profile', 'Doctor\PatientProfileController@index')->name('doctor.patient.profile');
	Route::get('patient-profile/filter/afib', 'Doctor\PatientProfileController@filter_by_afib')->name('doctor.patient.profile.filter.afib');
	Route::get('patient-profile/filter/arrhythmia', 'Doctor\PatientProfileController@filter_by_arrhythmia')->name('doctor.patient.profile.filter.arrhythmia');
	Route::get('patient-profile/filter/abnormal', 'Doctor\PatientProfileController@filter_abnormal')->name('doctor.patient.profile.filter.abnormal');

	// Advice To User
	Route::post('patient/advice', 'Admin\PatientAdviceController@store')->name('doctor.patient.advise.store');

	//Article Routes for doctors
	Route::get('article', 'Doctor\ArticleController@index')->name('doctor.article');
	Route::get('article/create', 'Doctor\ArticleController@create')->name('doctor.article.create');
	Route::post('article/store', 'Doctor\ArticleController@store')->name('doctor.article.store');
	Route::get('article/edit/{id}', 'Doctor\ArticleController@edit')->name('doctor.article.edit');
	Route::post('article/update/{id}', 'Doctor\ArticleController@update')->name('doctor.article.update');
	Route::get('article/delete', 'Doctor\ArticleController@delete')->name('doctor.article.delete');
});
///Caregiver
Route::group(['middleware' => 'isCaregiver', 'prefix' => 'caregiver'], function(){
	 Route::get('dashboard', 'Caregiver\HomeController@index');
     
     Route::get('patient', 'Caregiver\PatientController@index');
     Route::get('patient/create', 'Caregiver\PatientController@create');
     Route::get('patient/edit/{id}', 'Caregiver\PatientController@edit');
     Route::post('patient/store', 'Caregiver\PatientController@store');
     Route::post('patient/update/{id}', 'Caregiver\PatientController@update');

     Route::get('diet-plan', 'Caregiver\DietController@index');   
	 Route::get('diet/create', 'Caregiver\DietController@create');
	 Route::get('diet/edit/{id}', 'Caregiver\DietController@edit');
     Route::post('diet/store', 'Caregiver\DietController@store');
	 Route::post('diet/update/{id}', 'Caregiver\DietController@update');
	 Route::get('diet/delete', 'Caregiver\DietController@delete');


     Route::get('organisation', 'Caregiver\OrganisationController@index');
     Route::get('organisation/create', 'Caregiver\OrganisationController@create');
     Route::get('organisation/edit/{id}/{pid}', 'Caregiver\OrganisationController@edit');
     Route::post('organisation/store', 'Caregiver\OrganisationController@store');
     Route::post('organisation/update/{id}/{pid}', 'Caregiver\OrganisationController@update');
     Route::get('patient/show/{id}', 'Caregiver\PatientProfileController@show');
});


//end Caregiver
// Common Patient Profile Route 
Route::group(['middleware' => 'auth'], function(){
	Route::get('patient-profile/show/{id}', 'Common\PatientProfileController@show')->name('common.patient.profile.show');
	Route::get('patient-profile/additional-info/history', 'Common\PatientProfileController@additional_info_history')->name('common.patient.profile.additional-info.history');
	Route::get('patient-profile/nutrition/history', 'Common\PatientProfileController@nutrition_history')->name('common.patient.profile.nutrition.history');
	Route::get('patient-profile/ecg-ppg/history', 'Common\PatientProfileController@ecg_ppg_history')->name('common.patient.profile.ecg.ppg.history');
	Route::get('patient-profile/bp/history', 'Common\PatientProfileController@bp_history')->name('common.patient.profile.bp.history');
	Route::get('patient-profile/hr/history', 'Common\PatientProfileController@hr_history')->name('common.patient.profile.hr.history');

	Route::get('patient-profile/arrhythmia/history', 'Common\PatientProfileController@arrhythmia_history')->name('common.patient.profile.arrhythmia.history');
	Route::get('patient-profile/arterial/history', 'Common\PatientProfileController@arterial_history')->name('common.patient.profile.arterial.history');
	Route::get('patient-profile/afib/history', 'Common\PatientProfileController@afib_history')->name('common.patient.profile.afib.history');
	Route::get('patient-profile/rpwv/history', 'Common\PatientProfileController@rpwv_history')->name('common.patient.profile.rpwv.history');
	Route::get('patient-profile/calories/history', 'Common\PatientProfileController@calories_history')->name('common.patient.profile.calories.history');
});

//Ajax route
//get Organisation by tenant id
Route::get('get-organisation-by-tenant', 'Tenant\OrganisationController@get_organisation')->name('get.organisation.by.tenant');

// Api Routes
Route::group(['prefix' => 'v1','middleware' => 'cors'], function(){
	// Auth Routes
	Route::post('authenticate', 'AppAuthController@authenticate');
	Route::post('authenticate/login', 'AppAuthController@applogin'); // For android app
	Route::post('authenticate/register', 'AppAuthController@register');
	Route::get('authenticate/user', 'AppAuthController@getAuthenticatedUser');
	Route::get('authenticate/forgot-password', 'AppAuthController@forgotPassword');
	Route::get('authenticate/resend-code', 'AppAuthController@resendResetCode');
	Route::post('authenticate/reset-password', 'AppAuthController@resetPassword');
	Route::post('authenticate/sendotp', 'AppAuthController@sendOtp');

	// Notification
	Route::get('deviceRegistration', 'AppNotification@deviceRegistration');
	// App Routes
	Route::get('getPromoCodes', 'AppController@getPromoCodes');
	Route::get('getBanks', 'AppController@getBanks');
	Route::get('getLabTestsList', 'AppController@getLabTestsList');
	Route::get('getSpecialties', 'AppController@getSpecialties');
	Route::get('getSpecialtiesTree', 'AppController@getSpecialtyTree');
	Route::get('getSymptoms', 'AppController@getSymptoms');
	Route::get('getSymptomsSpeciality', 'AppController@getSymptomsSpeciality');
	Route::get('getMedicineType', 'AppController@getMedicineType');
	Route::get('getLangPriceMedicine', 'AppController@getLangPriceMedicine');
	Route::get('getLanguages', 'AppController@getLanguages');
	Route::get('getUploadTypes', 'AppController@getUploadTypes');
	Route::get('getArticles', 'AppController@getArticles');
	Route::get('getAllArticles', 'AppController@getAllArticles');
	Route::get('getArticleBySlug', 'AppController@getArticleBySlug');
	Route::get('getSpecialtyBySlug', 'AppController@getSpecialtyBySlug');
	Route::get('getDoctorBySlug', 'AppController@getDoctorBySlug');
	Route::get('getConsultationPriceMinMax', 'AppController@getConsultationPriceMinMax');

	// App Link
	Route::get('sendAppLink', 'AppController@sendAppLink');
	Route::get('getAppLink', 'AppController@getAppLink');

	// Doctors
	Route::get('getHomepageDoctors', 'AppController@getHomepageDoctors');
	Route::get('searchDoctors', 'AppController@searchDoctors');
	Route::get('searchDoctorsNew', 'AppController@searchDoctorsNew');
	Route::get('getAllDoctors', 'AppController@getAllDoctors');

	// Time Slots
	Route::get('getDoctorAvailableTimeSlots', 'AppDoctorController@getDoctorAvailableTimeSlots');

	// Routes that only logged in users can access and the jwt token will refresh once the api hits these routes
	Route::group(['middleware' => ['jwtauth']], function(){
	Route::post('coupandetails', 'Api\Payment\PaymentController@coupan');
		Route::post('confirmPayment', 'Api\Payment\PaymentController@index');
		// Notifications
		Route::get('notifications', 'AppNotificationsController@index');
		Route::post('notifications', 'AppNotificationsController@clearAll');
		Route::post('notifications/{id}', 'AppNotificationsController@clear');

		// File Uploads
		Route::any('upload', 'AppFileController@uploadFile');

		// Booking Appointments
		Route::post('callNow', 'AppBookingController@callNow');
		Route::get('checkSlotAvailabilityAndCreateTempBooking', 'AppBookingController@checkSlotAvailabilityAndCreateTempBooking');
		Route::get('cancelTempBooking', 'AppBookingController@cancelTempBooking');
		Route::post('updateTempBooking', 'AppBookingController@updateTempBooking');
		Route::get('getTempAppointmentSummary', 'AppBookingController@getTempAppointmentSummary');
		Route::get('checkTempBooking/{id}', 'AppBookingController@checkTempBooking');
		Route::post('confirmAppointment', 'AppBookingController@confirmBooking');

		// Patient Profile
		Route::get('getPatientProfile', 'AppPatientController@getPatientProfile');
		Route::get('getPatientCredits', 'AppPatientController@getPatientCredits');

		// Call Feedback
		Route::post('callFeedback', 'Api\Appointment\CallController@callFeedback');

		Route::group(['prefix' => 'doctor', 'middleware' => ['accessCheck:doctor']], function(){
			// Documents
			Route::post('documents', 'Api\Doctor\DocumentsController@create');
			Route::post('update-documents', 'Api\Doctor\DocumentsController@update');

			// Call Status
			Route::post('callStatus', 'Api\Doctor\CallStatusController@update');

			// Upcoming Appointments
			Route::get('upcomingAppointments', 'Api\Doctor\UpcomingAppointmentController@index');
			Route::post('cancelAppointment', 'Api\Doctor\UpcomingAppointmentController@cancelAppointment');

                        Route::post('appointmentByDate', 'Api\Doctor\AppointmentDateController@index');

            // Other Appointments
			Route::get('otherAppointments', 'Api\Doctor\OtherAppointmentController@index');

			// Past Appointments
			Route::get('pastAppointments', 'Api\Doctor\PastAppointmentController@index');

			// Prescription
			Route::get('prescription', 'Api\Doctor\PrescriptionController@index');
			Route::post('prescription', 'Api\Doctor\PrescriptionController@store');
			Route::post('prescriptionPreview', 'Api\Doctor\PrescriptionController@preview');
			Route::get('appointmentDoctorPatientDetails', 'Api\Doctor\PrescriptionController@appointmentDoctorPatientDetails');

			// Consultation Time
			Route::get('consultationTime', 'Api\Doctor\ConsultationTimeController@index');
			Route::post('consultationTime', 'Api\Doctor\ConsultationTimeController@update');

			// Consultation Time
			Route::get('consultationFees', 'Api\Doctor\ConsultationFeesController@index');
			Route::post('consultationFees', 'Api\Doctor\ConsultationFeesController@update');

			// Consultation Time
			Route::get('consultationSlot', 'Api\Doctor\ConsultationSlotController@index');
			Route::get('consultationSlotMin', 'Api\Doctor\ConsultationSlotController@min');
			Route::post('consultationSlot', 'Api\Doctor\ConsultationSlotController@update');

			// Health Tip
			Route::resource('healthTips', 'Api\Doctor\HealthTipController', ['except' => ['create', 'edit', 'update']]);
			Route::post('updateHealthTips/{id}', 'Api\Doctor\HealthTipController@updateqwe');

			// Profile
			Route::get('shortProfile', 'Api\Doctor\ProfileController@shortProfile');
			Route::post('changeProfilePic', 'Api\Doctor\ProfileController@changeProfilePic');
			Route::get('statusToggle', 'Api\Doctor\ProfileController@statusToggle');
			Route::get('profile', 'Api\Doctor\ProfileController@index');
			Route::post('profile', 'Api\Doctor\ProfileController@update');

			// Login Details
			Route::post('loginDetails', 'Api\Auth\LoginDetailsController@update');

			// Ledger
			Route::get('ledger', 'Api\Doctor\LedgerController@index');

			// Payments
			Route::get('payments', 'Api\Doctor\PaymentsController@index');

			// Bank Details
			Route::get('bankDetails', 'Api\Doctor\BankDetailsController@index');
			Route::post('bankDetails', 'Api\Doctor\BankDetailsController@create');
			Route::delete('bankDetails', 'Api\Doctor\BankDetailsController@delete');

			// Signature
			Route::get('signature', 'Api\Doctor\SignatureController@index');
			Route::post('signature', 'Api\Doctor\SignatureController@create');

			// Feedback
			Route::post('feedback', 'Api\Doctor\FeedbackController@create');

			// Receptionist
			Route::resource('receptionist', 'Api\Doctor\ReceptionistController', ['except' => ['create', 'edit']]);

			// Call
			Route::post('call', 'Api\Appointment\CallController@saveCallLog');
		});

		Route::group(['prefix' => 'receptionist', 'middleware' => ['accessCheck:receptionist']], function(){
			// Doctor Status
			Route::get('doctorStatus', 'Api\Receptionist\DoctorStatusController@index');
			Route::post('doctorStatus', 'Api\Receptionist\DoctorStatusController@update');

			// Appointment
			Route::get('appointments', 'Api\Receptionist\AppointmentController@index');
			Route::post('cancelAppointment', 'Api\Receptionist\AppointmentController@cancel');

			// Consultation Fees
			Route::get('consultationFees', 'Api\Receptionist\ConsultationFeesController@index');
			Route::post('consultationFees', 'Api\Receptionist\ConsultationFeesController@update');

			// Consultation Time
			Route::get('consultationTime', 'Api\Receptionist\ConsultationTimeController@index');
			Route::post('consultationTime', 'Api\Receptionist\ConsultationTimeController@update');

			// Manage Consultation Time
			Route::get('consultationSlot', 'Api\Receptionist\ConsultationSlotController@index');
			Route::get('consultationSlotMin', 'Api\Receptionist\ConsultationSlotController@min');
			Route::post('consultationSlot', 'Api\Receptionist\ConsultationSlotController@update');
		});

		Route::group(['prefix' => 'patient', 'middleware' => ['accessCheck:patient']], function(){
			// Upcoming Appointments
			Route::get('upcomingAppointments', 'Api\Patient\UpcomingAppointmentsController@index');
			Route::post('rescheduleAppointment', 'Api\Patient\UpcomingAppointmentsController@rescheduleAppointment');
			Route::post('cancelAppointment', 'Api\Patient\UpcomingAppointmentsController@cancelAppointment');

			// Past Appointments
			Route::get('pastAppointments', 'Api\Patient\PastAppointmentsController@index');

			// Other Appointments
			Route::get('otherAppointments', 'Api\Patient\OtherAppointmentController@index');

			// Profile
			Route::get('shortProfile', 'Api\Patient\ProfileController@shortProfile');
			Route::post('changeProfilePic', 'Api\Patient\ProfileController@changeProfilePic');
			Route::get('profile', 'Api\Patient\ProfileController@index');
			Route::post('profile', 'Api\Patient\ProfileController@update');

			// Prescription
			Route::get('prescription', 'Api\Patient\PrescriptionController@index');
			Route::get('prescription/{id}', 'Api\Patient\PrescriptionController@show');

			// Delivery Address
			Route::resource('deliveryAddress', 'Api\Patient\DeliveryAddressController', ['except' => ['create', 'show', 'edit']]);

			// Medicine Order
			Route::get('medicinesOrder', 'Api\Patient\MedicinesOrderController@index');
			Route::get('medicinesOrder/{id}', 'Api\Patient\MedicinesOrderController@show');
			Route::post('medicinesOrder', 'Api\Patient\MedicinesOrderController@store');

			// Lab Test Order
			Route::get('labTestOrder', 'Api\Patient\LabTestOrderController@index');
			Route::get('labTestOrder/{id}', 'Api\Patient\LabTestOrderController@show');
			Route::post('labTestOrder', 'Api\Patient\LabTestOrderController@store');

			// Order
			Route::get('orderPrescription/{id}', 'Api\Orders\OrderPrescriptionController@show');

			// Uploads
			Route::get('uploads', 'Api\Patient\UploadsController@index');
			Route::post('uploads', 'Api\Patient\UploadsController@create');
			Route::delete('uploads/{id}', 'Api\Patient\UploadsController@destroy');

			// Customer Support
			Route::post('support', 'Api\Patient\SupportController@create');

			// Feedback
			Route::post('feedback', 'Api\Patient\FeedbackController@create');
			Route::post('callFeedback', 'Api\Patient\FeedbackController@callFeedback');

			// Login Details
			Route::post('loginDetails', 'Api\Auth\LoginDetailsController@update');

			// Send Referral
			Route::post('refer', 'Api\Patient\ReferralsController@send');

			// Credit History
			Route::get('credits', 'Api\Patient\CreditsController@index');

			// Call
			Route::post('call', 'Api\Appointment\CallController@saveCallLog');
		});
	});
});

	
// All route for tenant
Route::group(['middleware' => ['auth', 'isTenant'], 'prefix' => '{slug?}'], function(){
	//Route::group(['middleware' => ['auth', 'isTenant'], 'prefix' => 'tenant'], function(){

	Route::get('organisation', 'Tenant\OrganisationController@index')->name('tenant.organisation');
	Route::get('organisation/create', 'Tenant\OrganisationController@create')->name('tenant.organisation.create');
	Route::post('organisation/store', 'Tenant\OrganisationController@store')->name('tenant.organisation.store');
	Route::get('organisation/edit/{id}', 'Tenant\OrganisationController@edit')->name('tenant.organisation.edit');
	Route::post('organisation/update/{id}', 'Tenant\OrganisationController@update')->name('tenant.organisation.update');
	Route::get('organisation/delete', 'Tenant\OrganisationController@delete')->name('tenant.organisation.delete');

	//Tenants Medcheck Readings
	//Route::get('tenantmedcheck', 'Tenant\TenantPatientMedcheckReadingController@index')->name('tenant.medcheck');
	//Route::get('tenantmedcheck/show/{id}','Tenant\TenantPatientMedcheckReadingController@show')->name('tenant.medcheck.show');
	//Route::get('tenantmedcheck/store/{id}','Tenant\TenantPatientMedcheckReadingController@store')->name('tenant.medcheck.store');
	/*Route::get('tenantmedcheck', 'Tenant\TenantPatientMedcheckReadingController@index');
	Route::get('tenantmedcheck/show/{id}','Tenant\TenantPatientMedcheckReadingController@show');
	Route::get('tenantmedcheck/store/{id}','Tenant\TenantPatientMedcheckReadingController@store');*/
	
	// Patient profile
	Route::get('patient-profile', 'Tenant\PatientProfileController@index')->name('tenant.patient.profile');
	Route::get('patient-profile/filter/afib', 'Tenant\PatientProfileController@filter_by_afib')->name('tenant.patient.profile.filter.afib');
	Route::get('patient-profile/filter/arrhythmia', 'Tenant\PatientProfileController@filter_by_arrhythmia')->name('tenant.patient.profile.filter.arrhythmia');
	Route::get('patient-profile/filter/abnormal', 'Tenant\PatientProfileController@filter_abnormal')->name('tenant.patient.profile.filter.abnormal');

	Route::get('patient-profile/show/{id}', 'Tenant\PatientProfileController@show')->name('tenant.patient.profile.show');
	Route::get('patient-profile/additional-info/history', 'Tenant\PatientProfileController@additional_info_history')->name('tenant.patient.profile.additional-info.history');
	Route::get('patient-profile/nutrition/history', 'Tenant\PatientProfileController@nutrition_history')->name('tenant.patient.profile.nutrition.history');
	Route::get('patient-profile/ecg-ppg/history', 'Tenant\PatientProfileController@ecg_ppg_history')->name('tenant.patient.profile.ecg.ppg.history');
	Route::get('patient-profile/bp/history', 'Tenant\PatientProfileController@bp_history')->name('tenant.patient.profile.bp.history');
	Route::get('patient-profile/arrhythmia/history', 'Tenant\PatientProfileController@arrhythmia_history')->name('tenant.patient.profile.arrhythmia.history');
	Route::get('patient-profile/arterial/history', 'Tenant\PatientProfileController@arterial_history')->name('tenant.patient.profile.arterial.history');
	Route::get('patient-profile/afib/history', 'Tenant\PatientProfileController@afib_history')->name('tenant.patient.profile.afib.history');
	Route::get('patient-profile/rpwv/history', 'Tenant\PatientProfileController@rpwv_history')->name('tenant.patient.profile.rpwv.history');
	Route::get('patient-profile/hr/history', 'Tenant\PatientProfileController@hr_history')->name('tenant.patient.profile.hr.history');
	Route::get('patient-profile/calories/history', 'Tenant\PatientProfileController@calories_history')->name('tenant.patient.profile.calories.history');
});
