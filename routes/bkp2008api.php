<?php



Route::group(['prefix' => '/rest/V1', 'middleware' => 'api'], function() {
	 // For android app
	Route::group(['namespace' => 'App\Http\Controllers'], function(){
		Route::post('authenticate/login', 'AppAuthController@applogin');
		Route::post('authenticate/register', 'AppAuthController@register');
		Route::post('send/otp', 'AppAuthController@send_otp');
		Route::post('mobile/verification', 'AppAuthController@mobileVerification');
		Route::post('authenticate/forgot-password', 'AppAuthController@forgotPassword');
		Route::post('authenticate/reset-password', 'AppAuthController@resetPassword');

		// Routes by shanu
		Route::get('tenant', 'c2pApi\TenantApiController@index');
		Route::get('tenant_organisation/{id}', 'c2pApi\TenantApiController@tenant_organisation');
	});

	Route::group(['middleware' => 'jwtauth', 'namespace' => 'Myaibud\Controllers'], function(){
		Route::get('allergy', 'API\AllergyController@index');
		Route::get('allergy/search', 'API\AllergyController@search');
		Route::get('disease', 'API\DiseaseController@index');
		Route::get('disease/search', 'API\DiseaseController@search');
		Route::get('medication', 'API\MedicationController@index');
		Route::get('medication/search', 'API\MedicationController@search');
		// Route::post('authenticate/register', 'AppAuthController@register');

		Route::group(['prefix' => 'patient'], function() {
			Route::get('getHraBandData', 'API\Patient\PatientHealthProfileController@getPatientHraBandData');
			Route::post('upsertHraBandData', 'API\Patient\PatientHealthProfileController@upsertPatientHraBandData');

			Route::get('profile', 'API\Patient\PatientController@getProfile');
			Route::post('profile', 'API\Patient\PatientController@upsertProfile');
			Route::get('profile/info', 'API\Patient\PatientController@get_patient_info');
			
			Route::get('profile/image', 'API\Patient\PatientController@getProfileImage');
			Route::post('profile/image', 'API\Patient\PatientController@upsertProfileImage');
			Route::get('profile/showProfile', 'API\Patient\PatientController@show_profile');


			/*************************************************************************
			 * HEALTH PROFILE API CALLBACKS
			 *************************************************************************/
			Route::get('healthProfile/travelFrequency/{travelType}', 'API\Patient\PatientHealthProfileController@getTravelFrequncy');
			Route::post('healthProfile/travelFrequency', 'API\Patient\PatientHealthProfileController@upsertTravelFrequncy');

			Route::get('healthProfile/diet/{parentKey}', 'API\Patient\PatientHealthProfileController@getDietData');
			Route::post('healthProfile/diet/{parentKey}', 'API\Patient\PatientHealthProfileController@upsertDietData');

			Route::get('healthProfile/alcohol', 'API\Patient\PatientHealthProfileController@getAlcohol');
			Route::get('healthProfile/all-alcohol-data', 'API\Patient\PatientHealthProfileController@getAllAlcoholData');
			Route::post('healthProfile/alcohol', 'API\Patient\PatientHealthProfileController@upsertAlcohol');

			Route::get('healthProfile/alcohol/alcohol-interval', 'API\Patient\PatientHealthProfileController@getAlcoholInterval');
			Route::post('healthProfile/alcohol/alcohol-interval', 'API\Patient\PatientHealthProfileController@upsertAlcoholInterval');


			Route::get('healthProfile/alcohol/alcohol-dosage/{type}', 'API\Patient\PatientHealthProfileController@getAlcoholDosageData');
			Route::post('healthProfile/alcohol/alcohol-dosage/{type}', 'API\Patient\PatientHealthProfileController@upsertAlcoholDosageData');


			Route::get('healthProfile/all-smoking-data', 'API\Patient\PatientHealthProfileController@getAllSmokingData');

			Route::get('healthProfile/smoking', 'API\Patient\PatientHealthProfileController@getSmoking');
			Route::post('healthProfile/smoking', 'API\Patient\PatientHealthProfileController@upsertSmoking');

			Route::get('healthProfile/smoking/smoking-interval', 'API\Patient\PatientHealthProfileController@getSmokingInterval');
			Route::post('healthProfile/smoking/smoking-interval', 'API\Patient\PatientHealthProfileController@upsertSmokingInterval');


			Route::get('healthProfile/smoking/start-age', 'API\Patient\PatientHealthProfileController@getSmokingStartAge');
			Route::post('healthProfile/smoking/start-age', 'API\Patient\PatientHealthProfileController@upsertSmokingStartAge');

			Route::get('healthProfile/smoking/end-age', 'API\Patient\PatientHealthProfileController@getSmokingEndAge');
			Route::post('healthProfile/smoking/end-age', 'API\Patient\PatientHealthProfileController@upsertSmokingEndAge');

			Route::get('healthProfile/smoking/dosage', 'API\Patient\PatientHealthProfileController@getSmokingDosage');
			Route::post('healthProfile/smoking/dosage', 'API\Patient\PatientHealthProfileController@upsertSmokingDosage');

			Route::get('healthProfile/smoking/tobacco', 'API\Patient\PatientHealthProfileController@getSmokingTobaccoDosage');
			Route::post('healthProfile/smoking/tobacco', 'API\Patient\PatientHealthProfileController@upsertSmokingTobaccoDosage');

			Route::get('healthProfile/vigorus-physical-activity', 'API\Patient\PatientHealthProfileController@getVigorusPhysicalActivity');
			Route::post('healthProfile/vigorus-physical-activity', 'API\Patient\PatientHealthProfileController@upsertVigorusPhysicalActivity');


			Route::get('healthProfile/moderate-physical-activity', 'API\Patient\PatientHealthProfileController@getModeratePhysicalActivity');
			Route::post('healthProfile/moderate-physical-activity', 'API\Patient\PatientHealthProfileController@upsertModeratePhysicalActivity');


			Route::get('healthProfile/light-physical-activity', 'API\Patient\PatientHealthProfileController@getLightPhysicalActivity');
			Route::post('healthProfile/light-physical-activity', 'API\Patient\PatientHealthProfileController@upsertLightPhysicalActivity');


			Route::get('healthProfile/diebetic', 'API\Patient\PatientHealthProfileController@getDiebetic');
			Route::post('healthProfile/diebetic', 'API\Patient\PatientHealthProfileController@upsertDiebetic');


			Route::get('healthProfile/diebetic/medicine', 'API\Patient\PatientHealthProfileController@getDiebeticMedicine');
			Route::post('healthProfile/diebetic/medicine', 'API\Patient\PatientHealthProfileController@upsertDiebeticMedicine');

			Route::get('healthProfile/blood-cholestrol', 'API\Patient\PatientHealthProfileController@getBloodCholestrol');
			Route::post('healthProfile/blood-cholestrol', 'API\Patient\PatientHealthProfileController@upsertBloodCholestrol');

			Route::get('healthProfile/get-blood-pressure-all-data', 'API\Patient\PatientHealthProfileController@getBloodPressureAllData');

			Route::get('healthProfile/blood-pressure', 'API\Patient\PatientHealthProfileController@getBloodPressure');
			Route::post('healthProfile/blood-pressure', 'API\Patient\PatientHealthProfileController@upsertBloodPressure');

			Route::get('healthProfile/blood-pressure/systolic', 'API\Patient\PatientHealthProfileController@getSystolicBloodPressure');
			Route::post('healthProfile/blood-pressure/systolic', 'API\Patient\PatientHealthProfileController@upsertSystolicBloodPressure');

			Route::get('healthProfile/blood-pressure/diastolic', 'API\Patient\PatientHealthProfileController@getDiastolicBloodPressure');
			Route::post('healthProfile/blood-pressure/diastolic', 'API\Patient\PatientHealthProfileController@upsertDiastolicBloodPressure');

			Route::get('healthProfile/cardiovascular-or-stroke', 'API\Patient\PatientHealthProfileController@getCardiovascular');
			Route::post('healthProfile/cardiovascular-or-stroke', 'API\Patient\PatientHealthProfileController@upsertCardiovascular');


			Route::get('healthProfile/stroke', 'API\Patient\PatientHealthProfileController@getStroke');
			Route::post('healthProfile/stroke', 'API\Patient\PatientHealthProfileController@upsertStroke');


			Route::get('healthProfile/stroke/reason', 'API\Patient\PatientHealthProfileController@getStrokeReason');
			Route::post('healthProfile/stroke/reason', 'API\Patient\PatientHealthProfileController@upsertStrokeReason');


			Route::get('healthProfile/disease', 'API\Patient\PatientHealthProfileController@getDisease');
			Route::post('healthProfile/disease', 'API\Patient\PatientHealthProfileController@upsertDisease');

			Route::get('healthProfile/disease/disease-details', 'API\Patient\PatientHealthProfileController@getDiseaseDetails');
			Route::post('healthProfile/disease/disease-details', 'API\Patient\PatientHealthProfileController@upsertDiseaseDetails');
			Route::delete('healthProfile/disease/disease-details/delete', 'API\Patient\PatientHealthProfileController@deleteDiseaseDetails');

			Route::get('healthProfile/allergy', 'API\Patient\PatientHealthProfileController@getAllergy');
			Route::post('healthProfile/allergy', 'API\Patient\PatientHealthProfileController@upsertAllergy');

			Route::get('healthProfile/allergy/allergy-details', 'API\Patient\PatientHealthProfileController@getAllergyDetails');
			Route::post('healthProfile/allergy/allergy-details', 'API\Patient\PatientHealthProfileController@upsertAllergyDetails');
			Route::delete('healthProfile/allergy/allergy-details/delete', 'API\Patient\PatientHealthProfileController@deleteAllergyDetails');

			Route::get('healthProfile/medication', 'API\Patient\PatientHealthProfileController@getMedication');
			Route::post('healthProfile/medication', 'API\Patient\PatientHealthProfileController@upsertMedication');

			Route::get('healthProfile/medication/medication-details', 'API\Patient\PatientHealthProfileController@getMedicationDetails');
			Route::post('healthProfile/medication/medication-details', 'API\Patient\PatientHealthProfileController@insertMedicationDetails');
			Route::post('healthProfile/medication/medication-details/{id}/update', 'API\Patient\PatientHealthProfileController@updateMedicationDetails');
			Route::delete('healthProfile/medication/medication-details/delete', 'API\Patient\PatientHealthProfileController@deleteMedicationDetails');



			Route::get('healthProfile/tia', 'API\Patient\PatientHealthProfileController@getTia');
			Route::post('healthProfile/tia', 'API\Patient\PatientHealthProfileController@upsertTia');


			Route::get('healthProfile/tia/regular-treatment', 'API\Patient\PatientHealthProfileController@getTiaTreatment');
			Route::post('healthProfile/tia/regular-treatment', 'API\Patient\PatientHealthProfileController@upsertTiaTreatment');

			Route::get('healthProfile/get-cardiovascular-or-stroke-all-data', 'API\Patient\PatientHealthProfileController@getAllCardiovascularData');

			Route::get('healthProfile/cardiovascular-or-stroke/coronary-heart-ischemic-heart', 'API\Patient\PatientHealthProfileController@getCoronary');
			Route::post('healthProfile/cardiovascular-or-stroke/coronary-heart-ischemic-heart', 'API\Patient\PatientHealthProfileController@upsertCoronary');


			Route::get('healthProfile/cardiovascular-or-stroke/angina-pain', 'API\Patient\PatientHealthProfileController@getAnginaPain');
			Route::post('healthProfile/cardiovascular-or-stroke/angina-pain', 'API\Patient\PatientHealthProfileController@upsertAnginaPain');


			Route::get('healthProfile/cardiovascular-or-stroke/regular-medication', 'API\Patient\PatientHealthProfileController@getRegularMedication');
			Route::post('healthProfile/cardiovascular-or-stroke/regular-medication', 'API\Patient\PatientHealthProfileController@upsertRegularMedication');


			Route::get('healthProfile/cardiovascular-or-stroke/heart-attack', 'API\Patient\PatientHealthProfileController@getHeartAttack');
			Route::post('healthProfile/cardiovascular-or-stroke/heart-attack', 'API\Patient\PatientHealthProfileController@upsertHeartAttack');


			Route::get('healthProfile/cardiovascular-or-stroke/ecg', 'API\Patient\PatientHealthProfileController@getEcg');
			Route::post('healthProfile/cardiovascular-or-stroke/ecg', 'API\Patient\PatientHealthProfileController@upsertEcg');


			Route::get('healthProfile/cardiovascular-or-stroke/coronary-angiography', 'API\Patient\PatientHealthProfileController@getCoronaryAngiography');
			Route::post('healthProfile/cardiovascular-or-stroke/coronary-angiography', 'API\Patient\PatientHealthProfileController@upsertCoronaryAngiography');

			Route::get('healthProfile/cardiovascular-or-stroke/bypass-surgery', 'API\Patient\PatientHealthProfileController@getBypassSurgery');
			Route::post('healthProfile/cardiovascular-or-stroke/bypass-surgery', 'API\Patient\PatientHealthProfileController@upsertBypassSurgery');


			Route::get('healthProfile/cardiovascular-or-stroke/stent-placement', 'API\Patient\PatientHealthProfileController@getStentPlacement');
			Route::post('healthProfile/cardiovascular-or-stroke/stent-placement', 'API\Patient\PatientHealthProfileController@upsertStentPlacement');


			Route::get('healthProfile/cardiovascular-or-stroke/valve-surgery', 'API\Patient\PatientHealthProfileController@getValveSurgery');
			Route::post('healthProfile/cardiovascular-or-stroke/valve-surgery', 'API\Patient\PatientHealthProfileController@upsertValveSurgery');

			Route::get('healthProfile/get-hra-score', 'API\Patient\PatientHealthProfileController@getHraScore');

			Route::post('healthProfile/hereditary', 'API\Patient\PatientHealthProfileController@upsertHereditary');
			Route::get('healthProfile/hereditary', 'API\Patient\PatientHealthProfileController@getHereditary');

			//PadoMeter Api
			Route::post('healthProfile/padometer', 'API\Patient\PatientHealthProfileController@upsertPadoMeterData');

			// Route::post('healthProfile/hereditary', 'API\Patient\PatientHealthProfileController@upsertHereditaryChild');
			// Route::get('healthProfile/hereditary', 'API\Patient\PatientHealthProfileController@getHereditaryChild');

			// ADD HRA BAND DATA
			Route::post('healthProfile/hra-band-data/ecg-score', 'API\Patient\PatientHealthProfileController@upsertEcgScore');
			Route::post('healthProfile/hra-band-data/ppg-score', 'API\Patient\PatientHealthProfileController@upsertPpgScore');

			Route::post('healthProfile/hra-band-data/device-2', 'API\Patient\PatientHealthProfileController@upsertHraBandDataDevice2');
			Route::get('healthProfile/hra-band-data/device-2', 'API\Patient\PatientHealthProfileController@getHraBandDataDevice2');

			Route::post('healthProfile/nutrition', 'API\Patient\PatientHealthProfileController@upsertNutritionData');
			Route::get('healthProfile/nutrition', 'API\Patient\PatientHealthProfileController@getNutritionData');
			Route::get('healthProfile/nutrition/delete/{id}', 'API\Patient\PatientHealthProfileController@deleteNutrition');
			Route::post('healthProfile/set-calories-target', 'API\Patient\PatientHealthProfileController@setCaloriesTarget');
			Route::get('healthProfile/get-calories-target', 'API\Patient\PatientHealthProfileController@getCaloriesTarget');

			Route::get('healthProfile/patient-profile-completion', 'API\Patient\PatientHealthProfileController@getpatientHealthProfile');
			
			Route::post('history', 'API\HistoryController@syncHistory');
			Route::get('get-bp', 'API\HistoryController@getBp');
			Route::get('get-rpwv', 'API\HistoryController@getRpwv');
			Route::get('get-afib', 'API\HistoryController@getAfib');
			Route::get('get-arrhythmia', 'API\HistoryController@getArrhythmia');
			Route::get('get-hr', 'API\HistoryController@getHr');
			Route::get('get-calories', 'API\HistoryController@getCalories');


			//Routes for Articles
			Route::get('get-articles', 'API\ArticleController@index');

			//Routes for Patient Advice
			Route::get('get-advice', 'API\Patient\AdviceController@index');

			//Routes for Excercise
			Route::get('healthProfile/excercise', 'API\Patient\PatientHealthProfileController@getExcerciseData');
			Route::post('healthProfile/excercise', 'API\Patient\PatientHealthProfileController@upsertExercise');
			Route::get('healthProfile/excercise/delete/{id}', 'API\Patient\PatientHealthProfileController@deleteExcercise');
			/*************************************************************************
			 * HEALTH PROFILE API CALLBACKS END HERE
			 *************************************************************************/


			Route::get('question/all', 'API\ProfileQuestionController@index');
			Route::post('question', 'API\ProfileQuestionController@upsert');
			Route::get('question/{id}', 'API\ProfileQuestionController@editById');

			Route::get('questionSlug/{questionSlug}', 'API\ProfileQuestionController@edit');
			Route::get('hhi', 'API\Patient\PatientHealthProfileController@get_hhi');

		});
	});
});

Route::group(['namespace' => 'Myaibud\Controllers'], function(){
	Route::get('patientProfile/{id}', 'API\Patient\PatientController@getPatientProfile');
});
