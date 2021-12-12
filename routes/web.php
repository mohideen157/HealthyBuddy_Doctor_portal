<?php 

Route::get('register', function() {
	dd("Archito Testing");
});

Route::get('auth/{provider}', 'UserController@redirectToProvider');
Route::get('auth/{provider}/callback', 'UserController@handleProviderCallback');
Route::get('getaccesstoken', 'UserController@getToken');
Route::get('register', 'HomeController@register');
Route::post('register_user', 'HomeController@register_user');
Route::get('register-success', 'HomeController@registersuccess');

//Medcheck User Register
Route::get('registermedcheck/{id}', 'MedcheckUserRegController@registermedcheck');
Route::post('registermedcheckuser', 'MedcheckUserRegController@registermedcheckuser');
Route::get('registermedchecksuccess', 'MedcheckUserRegController@registermedchecksuccess');

Route::group(['prefix' => 'admin','middleware'=>['auth', 'isAdmin']], function(){
	Route::get('allergy', 'Admin\AllergyController@index');
	Route::get('disease', 'Admin\DiseaseController@index');
	Route::get('medication', 'Admin\MedicationController@index');	
});

Route::group(['middleware'=>['auth', 'isAdmin']], function(){
	Route::resource('datatable/allergy', 'DataTable\AllergyController');
	Route::resource('datatable/disease', 'DataTable\DiseaseController');
	Route::resource('datatable/medication', 'DataTable\MedicationController');
});

Route::group(['middleware' => ['auth', 'isTenant'], 'prefix' => '{slug?}'], function(){
//Route::group(['middleware' => ['auth', 'isTenant'], 'prefix' => 'tenant'], function(){
	//Tenants Medcheck Readings
	Route::get('tenantmedcheck', 'API\TenantPatientMedcheckReadingController@index')->name('tenant.medcheck');
	Route::get('tenantmedcheck/abnormal', 'API\TenantPatientMedcheckReadingController@abnormal')->name('tenant.medcheck.abnormal');
	Route::get('tenantmedcheck/abnormalecg', 'API\TenantPatientMedcheckReadingController@abnormalecg')->name('tenant.medcheck.abnormalecg');
	Route::get('tenantmedcheck/abnormalspo2', 'API\TenantPatientMedcheckReadingController@abnormalspo2')->name('tenant.medcheck.abnormalspo2');
	Route::get('tenantmedcheck/show/{id}','API\TenantPatientMedcheckReadingController@show')->name('tenant.medcheck.show');
	Route::get('tenantmedcheck/store/{id}','API\TenantPatientMedcheckReadingController@store')->name('tenant.medcheck.store');
	
});
