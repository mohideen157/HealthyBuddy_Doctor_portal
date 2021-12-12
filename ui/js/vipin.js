
	$('.expand_btn').hide();
	$('.top_header_left_sort .pull-right').click(function(){
		$('.specialitis_list ul').slideToggle();
		$(this).children().find('i').toggleClass('fa-plus fa-minus')
	});
	$('.top_header_left_sort2 .pull-right').click(function(){
		$(this).parent().parent().parent().children('.right_section_filters').slideToggle();
		$(this).children().find('i').toggleClass('fa-plus fa-minus')
	});

	$('.doctor_calander').hide();
	$('.doctorsContainer').on('click','.book_appt_btn',function(){
		$(this).parent().parent().parent().parent().children('.doctor_calander').slideToggle();
		if($(this).text()=='Book Appointment'){
			$(this).text('Hide Slots');
		}else{
			$(this).text('Book Appointment');
		}
	});
	$('.sort_left ul li').click(function(){
		$('.sort_left ul li').removeClass('active_left_list');
		$(this).toggleClass('active_left_list');
	});
// calandar script starts here
// $(document).ready(function(){
	// $('.prevapp').hide();
	var today_date = new Date();
	console.log(today_date);

	var today_day = today_date.getDate();
	var today_month = today_date.getMonth();
	var today_days = today_date.getDay();
	var today_year = today_date.getFullYear();

var days = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
var months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];

 var today_date = new Date();
 var today_day = today_date.getDate();
 var today_month = today_date.getMonth();
 var today_days = today_date.getDay();
 var today_year = today_date.getFullYear();

  $('.nextapp').attr('year',today_year);
 
 today_month = months[today_month];
 today_day1 = days[today_days];
 
 $('.today_day').text(today_day1);
 $('.today_date').text(today_day);
 $('.today_month').text(today_month);
 var tomorrow_full_date = new Date(today_date.getTime() + (86400000));
 var tomorrow_date = tomorrow_full_date.getDate();
 var tomorrow_month = tomorrow_full_date.getMonth();
 

 var tomorrow_day = tomorrow_full_date.getDay();
 tomorrow_month = months[tomorrow_month];
 tomorrow_day = days[tomorrow_day];
 
 $('.tomorrow_date').text(tomorrow_date);
 $('.tomorrow_month').text(tomorrow_month);
 $('.tomorrow_day').text(tomorrow_day);
 var thirdDay_full_date = new Date(today_date.getTime() + (86400000*2));
 console.log(thirdDay_full_date);
 var thirdDay_date = thirdDay_full_date.getDate();
 var thirdDay_month = thirdDay_full_date.getMonth();
 var thirdDay_day = thirdDay_full_date.getDay();
 
 thirdDay_month = months[thirdDay_month];
 thirdDay_day = days[thirdDay_day];
 
 $('.thirdDay_day').text(thirdDay_day);
 $('.thirdDay_month').text(thirdDay_month);
 $('.thirdDay_date').text(thirdDay_date);
 var fourthDay_full_date = new Date(today_date.getTime() + (86400000*3));
 var fourthDay_date = fourthDay_full_date.getDate();
 var fourthDay_month = fourthDay_full_date.getMonth();
 var fourthDay_day = fourthDay_full_date.getDay();
 
 fourthDay_month = months[fourthDay_month];
 fourthDay_day = days[fourthDay_day];
 
 $('.fourthDay_day').text(fourthDay_day);
 $('.fourthDay_month').text(fourthDay_month);
 $('.fourthDay_date').text(fourthDay_date);
 var fifthDay_full_date = new Date(today_date.getTime() + (86400000*4));
 var fifthDay_date = fifthDay_full_date.getDate();
 var fifthDay_month = fifthDay_full_date.getMonth();
 var fifthDay_day = fifthDay_full_date.getDay();
 
 fifthDay_month = months[fifthDay_month];
 fifthDay_day = days[fifthDay_day];
 
 $('.fifthDay_day').text(fifthDay_day);
 $('.fifthDay_month').text(fifthDay_month);
 $('.fifthDay_date').text(fifthDay_date);
 var sixthDay_full_date = new Date(today_date.getTime() + (86400000*5));
 var sixthDay_date = sixthDay_full_date.getDate();
 var sixthDay_month = sixthDay_full_date.getMonth();
 var sixthDay_day = sixthDay_full_date.getDay();
 
 sixthDay_month = months[sixthDay_month];
 sixthDay_day = days[sixthDay_day];
 
 $('.sixthDay_day').text(sixthDay_day);
 $('.sixthDay_month').text(sixthDay_month);
 $('.sixthDay_date').text(sixthDay_date);
 var seventhDay_full_date = new Date(today_date.getTime() + (86400000*6));
 var seventhDay_date = seventhDay_full_date.getDate();
 var seventhDay_month = seventhDay_full_date.getMonth();
 var seventhDay_day = seventhDay_full_date.getDay();
 
 seventhDay_month = months[seventhDay_month];
 seventhDay_day = days[seventhDay_day];

 $('.seventhDay_day').text(seventhDay_day);
 $('.seventhDay_month').text(seventhDay_month);
 $('.seventhDay_date').text(seventhDay_date);
// calandar script ends here

// $(document).ready(function(){
	// var morning_hours=8;
	// for(morning_hours; morning_hours<12; morning_hours++){
	// 	var minutes = 00;
	// 		for(minutes; minutes<=45; minutes+=15){
	// 			if(minutes==0){
	// 				$('ul.morning-time').append('<li> '+morning_hours+' : 00 AM</li>');
	// 			}else{
	// 				$('ul.morning-time').append('<li> '+morning_hours+' : '+minutes+' AM</li>');
	// 			}
	// 		}
	// }
	// var afternoon_hours=12;
	// for(afternoon_hours; afternoon_hours<16; afternoon_hours++){
	// 	var minutes = 00;
	// 	var a_h= 0;
	// 	if(afternoon_hours>=13){a_h = afternoon_hours-12}else{a_h = afternoon_hours}
	// 		for(minutes; minutes<=45; minutes+=15){
	// 			if(minutes==0){
	// 				$('ul.afternoon-time').append('<li> '+ a_h+' : 00 PM</li>');
	// 			}else{
	// 				$('ul.afternoon-time').append('<li> '+ a_h+' : '+minutes+' PM</li>');
	// 			}
	// 		}
	// }
	// var evening_time=16;
	// for(evening_time; evening_time<20; evening_time++){
	// 	var minutes = 00;
	// 	var a_h= 0;
	// 	if(evening_time>=13){a_h = evening_time-12}else{a_h = evening_time}
	// 		for(minutes; minutes<=45; minutes+=15){
	// 			if(minutes==0){
	// 				$('ul.evening-time').append('<li> '+ a_h+' : 00 PM</li>');
	// 			}else{
	// 				$('ul.evening-time').append('<li> '+ a_h+' : '+minutes+' PM</li>');
	// 			}
	// 		}
	// }
	// var night_time=20;
	// for(night_time; night_time<22; night_time++){
	// 	var minutes = 00;
	// 	var a_h= 0;
	// 	if(night_time>=13){a_h = night_time-12}else{a_h = night_time}
	// 		for(minutes; minutes<=45; minutes+=15){
	// 			if(minutes==0){
	// 				$('ul.night-time').append('<li> '+ a_h+' : 00 PM</li>');
	// 			}else{
	// 				$('ul.night-time').append('<li> '+ a_h+' : '+minutes+' PM</li>');
	// 			}
	// 		}
	// }
// });
// $(document).ready(function(){
	$('.meridion_selection .tab-content ul').append('<input type="hidden" name="booking_time" class="booking_time">');
	$(document).on('click','.meridion_selection .tab-content ul li',function(){
	// $('.meridion_selection .tab-content ul li').click(function(){
		$('.meridion_selection .tab-content ul li').removeClass('active_time_list');
		$(this).addClass('active_time_list');
		var booking_time = $(this).text();
		$('.booking_time').val(booking_time);
	});
	$('.meridion_selection .nav-tabs>li, .calander_dates_heading .nav-tabs>li').on('click', function(){
		$('.booking_time').val('');
		$('.meridion_selection .tab-content ul li').removeClass('active_time_list');
	});
	$('.rangee .row .col-xs-6').prepend("<li class='fa fa-inr'></li>");
// });
function reset_filters(){
	document.getElementById('filters_form').reset();
}
$(function() {
  $( "#slider-range" ).slider({
    range: true,
    min: 0,
    max: 1000,
    values: [ 100, 900 ],
    slide: function( event, ui ) {
     $( "#amount" ).val(ui.values[ 0 ] );
      $( "#amount2" ).val(ui.values[ 1 ] );
    }
  });
  $( "#amount" ).val($( "#slider-range" ).slider( "values", 0 ) );
   $( "#amount2" ).val( $( "#slider-range" ).slider( "values", 1 )  );
});
// $(document).ready(function(){
	$('.clearall').on('click',function(){
    $(function() {
      $( "#slider-range" ).slider({
      range: true,
      min: 0,
      max: 1000,
      values: [ 100, 900 ],
      slide: function( event, ui ) {
         $( "#amount" ).val( ui.values[ 0 ] );
         $( "#amount2" ).val(ui.values[ 1 ] );
        }
      });
      $( "#amount" ).val( $( "#slider-range" ).slider( "values", 0 ) );
       $( "#amount2" ).val( $( "#slider-range" ).slider( "values", 1 ));
    	});
	});
	$('.hideAndShow').hide();
	$('.btn-common-pink').click(function(){
		$('.hideAndShow').toggle();
		if($(this).text()=='Book Appointment'){
			$(this).text('Hide Slots');
		}else{
			$(this).text('Book Appointment');
		}
	});
	if($('#new_patient').is(':checked')){
		$('#signupPatientFields').show();
		$('#signupDoctorFields').hide();
	}
	$('.signUpAs').on('click',function(){
		if($('#new_patient').is(':checked')){
		$('#signupPatientFields').show();
		$('#signupDoctorFields').hide();
	}
	else if($('#new_doctor').is(':checked')){
		$('#signupPatientFields').hide();
		$('#signupDoctorFields').show();
	}
	});
if($('#noReport').is(':checked')){
		$('.uploadedReports').hide();
}
$('.sheReportYN').on('click',function(){
	if($('#noReport').is(':checked')){
		$('.uploadedReports').hide();
	}
	else{
		$('.uploadedReports').show();
	}
});
if($('#noMedication').is(':checked')){
		$('.describeMedication').hide();
}
$('.descMedication').on('click',function(){
	if($('#noMedication').is(':checked')){
		$('.describeMedication').hide();
	}
	else{
		$('.describeMedication').show();
	}
});
if($('#noAllergy').is(':checked')){
		$('.describeAllergy').hide();
}
$('.allergyType').on('click',function(){
	if($('#noAllergy').is(':checked')){
		$('.describeAllergy').hide();
	}
	else{
		$('.describeAllergy').show();
	}
});
if($('#other').is(':checked')){
		$('.width70').show();
}
$('.appointAs').on('click',function(){
	if($('#other').is(':checked')){
		$('.width70').show();
	}
	else{
		$('.width70').hide();
	}
// });
if($('#doctor_status').is(':checked')){
	$('#doctor_status').parent().next().html('You are Online');
}else{
	$('#doctor_status').parent().next().html('You are Offline');
}
$('#doctor_status').on('change',function(){
	if($('#doctor_status').is(':checked')){
		$('#doctor_status').parent().next().html('You are Online');
	}else{
		$('#doctor_status').parent().next().html('You are Offline');
	}
})
 // $(function(){
	$('#filterDate').datepicker({
		todayHighlight:true,
	});
	$('.ledger-from').datepicker({
		todayHighlight:true,
	});
	$('.ledger-from').datepicker({
		todayHighlight:true,
	});

	$('.added-account-details').hide();
	$('#add_now').on('click',function(){
		$('.added-account-details').show();
		$('.add-account-details').hide();
	});
	$('#image_upload_preview').hide();
	$("#signature-upload").change(function () {
	   readURL(this);
	   $('#image_upload_preview').show();
	   $('.custom-file-upload').hide();
	});
$('#health-tip_upload_preview').hide();
$("#health-tip-upload").change(function () {
        something(this);
       $('#health-tip_upload_preview').show();
       $('.custom-file-upload').hide();
});
$('.cancel-sign').on('click',function(){
	 $('#image_upload_preview').hide();
   $('.custom-file-upload').show();
   $('.danger').html('Image Size maximum 70kb in size');
   $('.danger').css('color','');
});
$('.edit-receptionist,.reception-third,.reception-second').hide();
$('.btn-add-disable').on('click','.add-receptionist',function(){
	$('.reception-second').show();
	$('.reception-first').hide();
	$(this).addClass('save-receptionst');
	$(this).removeClass('add-receptionist');
})
$('.btn-add-disable').on('click','.save-receptionst',function(){
	$('.reception-third').show();
	$('.reception-second').hide();
	$('.btn-add-disable').hide();
});
});
$('.cancel-edit-reception').on('click',function(){
	$('.reception-third').show();
	$('.edit-receptionist').hide();
});
$('#edit-reception-details').on('click',function(){
	$('.reception-third').hide();
	$('.edit-receptionist').show();
});
$('.write-health-tip-content').hide();
$('#write-health-tip').on('click',function(){
	$('.write-health-tip-content').show();
	$('.health-tips-content').hide();
});
$('#show-health-tip').on('click',function(){
	$('.write-health-tip-content').hide();
	$('.health-tips-content').show();
});
$('.doctor-menu-list li').click(function(){
	$('.doctor-menu-list li').not($(this)).removeClass('active');
});
$('.heightWeightComn li:last-child').click(function(){
	$(this).parent().next().toggle();
	$(this).parent().children().children('li i').toggleClass('fa-check fa-times');
	if($(this).parent().next().is(':visible')){
		$(this).parent().css('background-color','#00A69C');
		$(this).parent().children().children('li span').css('color','#FFF');
		$(this).parent().children('li').css('color','#FFF');
		$(this).parent().children('li:last-child').css('background-color','#35BCAE');
	}else{
		$(this).parent().css('background-color','#F1F1F1');
		$(this).parent().children().children('li span').css('color','#7D7D7F');
		$(this).parent().children('li').css('color','#000');
		$(this).parent().children('li:last-child').css('background-color','#CCC');
	}
});



// var i = 0;
// $('.doctorsContainer').on('click','.nextapp',function(){
// 	$('.prevapp').show();
// 	if(i <= 3){
// 		var length = $(this).parent().parent().children().length-2;
// 		var myyear;var mydate; var mymonth;
// 		myyear = $('.nextapp').attr('year');
// 		$.each($(this).parent().parent().children(),function(k,v){
// 			$(this).removeClass('active');
// 			if(k >= 1 && k <= length){
// 				mydate = $(this).children().children().next().children().first().html();
// 				mymonthname = $(this).children().children().next().children().next().html();
// 				mymonth = getmonthindex(mymonthname);
// 				var presentdate = new Date(myyear,mymonth,mydate);
// 				var nextdate = new Date(presentdate.getTime() + (86400000*7));
// 				$(this).children().children().next().children().first().html(nextdate.getDate());
// 				$(this).children().children().next().children().next().html(getmonthname(nextdate.getMonth()));
// 				$(this).children().children().first().html(getdayname(nextdate.getDay()));
// 				$('.nextapp').attr('year',nextdate.getFullYear())
// 			}
// 		});
// 		i++;
// 		if(i == 4){
// 			$('.nextapp').hide();
// 		}
// 	}
// });

// $('.doctorsContainer').on('click','.prevapp',function(){
// 		$('.nextapp').show();
// 		if(i > 0){
// 			var length = $(this).parent().parent().children().length-2;
// 			var myyear;var mydate; var mymonth;
// 			myyear = $('.nextapp').attr('year');
// 			$.each($(this).parent().parent().children(),function(k,v){
// 				if(k >= 1 && k <= length){
// 					mydate = $(this).children().children().next().children().first().html();
// 					mymonthname = $(this).children().children().next().children().next().html();
// 					mymonth = getmonthindex(mymonthname);
// 					var presentdate = new Date(myyear,mymonth,mydate);
// 					var nextdate = new Date(presentdate.getTime() - (86400000*7));
// 					$(this).children().children().next().children().first().html(nextdate.getDate());
// 					$(this).children().children().next().children().next().html(getmonthname(nextdate.getMonth()));
// 					$(this).children().children().first().html(getdayname(nextdate.getDay()));
// 					$('.nextapp').attr('year',nextdate.getFullYear());
// 				}
// 				if(i == 1 && k == 1){$(this).addClass('active');}
// 			});
// 			i--;
// 			if(i == 0){
// 				$('.prevapp').hide();
// 			}
// 		}
// 	});
// });

var days = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
var months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
function getmonthindex(mymonthname){
	var mymonth;
	$.each(months,function(key,value){
		 if(value == mymonthname){
	        mymonth = key;
	    }
	});
	return mymonth;
}
function getmonthname(myindex){
	var nextmonth;
	$.each(months,function(key,value){
	    if(key == myindex){
	        nextmonth = value;
	    }
	});
	return nextmonth;
}
function getdayname(dayindex){
	var nextday;
	$.each(days,function(key,value){
	    if(key == dayindex){
	        nextday = value;
	    }
	});
	return nextday;
}
$('#fixappoint').on('click',function(e){
	e.preventDefault();
	$('.appointmentSummary').show();
	$('.doctor-more-info').hide();
	$('#whoIsPatient').modal('hide');
	$('#oneid').hide();
});
function isNumber(evt,ele) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    if(ele.val().length == 0){
    	ele.parent().next().children('input').focus();
    }
    return true;
}
function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    var img_size = (input.files[0].size/1000);
    if(img_size <= 70){
    	$('.danger').html('Image Size is '+ img_size+'kb in size');
    }else{
    	var exe = img_size-70;
    	$('.danger').html('Image Size exceeding '+ exe+'kb in size');
    	$('.danger').css('color','red');
    }
    reader.onload = function (e) {
        $('#image_upload_preview').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}
function something(input) {
if (input.files && input.files[0]) {
    var reader = new FileReader();
		reader.onload = function (e) {
        $('#health-tip_upload_preview').attr('src', e.target.result);
    }
		reader.readAsDataURL(input.files[0]);
	}
}
$('.doctorsContainer').on('click','a[data-toggle="tab"]',function(event){
	event.preventDefault();
});

var day = 7;

$('.calander_dates_heading ul>li').css('display','none');
$('.calander_dates_heading ul>li').slice(0,7).css('display','block');

$('.doctorsContainer').on('click','.nextapp',function(){
	day = day + 1;
	old = day - 7;
	console.log(day +' and '+ old);
	if(day <=22 ){
		console.log('here');
		$('.calander_dates_heading ul>li').css('display','none');
		$('.calander_dates_heading ul>li').slice(old,day).css('display','block');
	}
});

$('.doctorsContainer').on('click','.prevapp',function(){
	day = day - 1;
	old = day - 7;
	if(old >= 0 ){
		$('.calander_dates_heading ul>li').css('display','none');
		$('.calander_dates_heading ul>li').slice(old,day).css('display','block');
	}
});






