$(document).ready(function(){
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
	$('.book_appt_btn').click(function(){
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
});
// calandar script starts here
$(document).ready(function(){
	$('.prevapp').hide();
	var today_date = new Date();
	console.log(today_date);

	var today_day = today_date.getDate();
	var today_month = today_date.getMonth();
	var today_days = today_date.getDay();
	var today_year = today_date.getFullYear();

	$('.nextapp').attr('year',today_year);
	if(today_month == 0){
		today_month = "Jan";
	}else if(today_month == 1){
		today_month = "Feb";
	}else if(today_month == 2){
		today_month = "Mar";
	}else if(today_month == 3){
		today_month = "Apr";
	}else if(today_month == 4){
		today_month = "May";
	}else if(today_month == 5){
		today_month = "Jun";
	}else if(today_month == 6){
		today_month = "Jul";
	}else if(today_month == 7){
		today_month = "Aug";
	}else if(today_month == 8){
		today_month = "Sep";
	}else if(today_month == 9){
		today_month = "Oct";
	}else if(today_month == 10){
		today_month = "Nov";
	}else if(today_month == 11){
		today_month = "Dec";
	}else{}
	if(today_days==0){
		today_day1 = "Sun";
	}else if(today_days==1){
		today_day1 = "Mon";
	}else if(today_days==2){
		today_day1 = "Tue";
	}else if(today_days==3){
		today_day1 = "Wed";
	}else if(today_days==4){
		today_day1 = "Thu";
	}else if(today_days==5){
		today_day1 = "Fri";
	}else if(today_days==6){
		today_day1 = "Sat";
	}else{}
	$('.today_day').text(today_day1);
	$('.today_date').text(today_day);
	$('.today_month').text(today_month);
	var tomorrow_full_date = new Date(today_date.getTime() + (86400000));
	var tomorrow_date = tomorrow_full_date.getDate();
	var tomorrow_month = tomorrow_full_date.getMonth();
	if(tomorrow_month == 0){
		tomorrow_month = "Jan";
	}else if(tomorrow_month == 1){
		tomorrow_month = "Feb";
	}else if(tomorrow_month == 2){
		tomorrow_month = "Mar";
	}else if(tomorrow_month == 3){
		tomorrow_month = "Apr";
	}else if(tomorrow_month == 4){
		tomorrow_month = "May";
	}else if(tomorrow_month == 5){
		tomorrow_month = "Jun";
	}else if(tomorrow_month == 6){
		tomorrow_month = "Jul";
	}else if(tomorrow_month == 7){
		tomorrow_month = "Aug";
	}else if(tomorrow_month == 8){
		tomorrow_month = "Sep";
	}else if(tomorrow_month == 9){
		tomorrow_month = "Oct";
	}else if(tomorrow_month == 10){
		tomorrow_month = "Nov";
	}else if(tomorrow_month == 11){
		tomorrow_month = "Dec";
	}else{}

	var tomorrow_day = tomorrow_full_date.getDay();
	if(tomorrow_day==0){
		tomorrow_day = "Sun";
	}else if(tomorrow_day==1){
		tomorrow_day = "Mon";
	}else if(tomorrow_day==2){
		tomorrow_day = "Tue";
	}else if(tomorrow_day==3){
		tomorrow_day = "Wed";
	}else if(tomorrow_day==4){
		tomorrow_day = "Thu";
	}else if(tomorrow_day==5){
		tomorrow_day = "Fri";
	}else if(tomorrow_day==6){
		tomorrow_day = "Sat";
	}else{}
	$('.tomorrow_date').text(tomorrow_date);
	$('.tomorrow_month').text(tomorrow_month);
	$('.tomorrow_day').text(tomorrow_day);
	var thirdDay_full_date = new Date(today_date.getTime() + (86400000*2));
	var thirdDay_date = thirdDay_full_date.getDate();
	var thirdDay_month = thirdDay_full_date.getMonth();
	var thirdDay_day = thirdDay_full_date.getDay();
	if(thirdDay_month == 0){
		thirdDay_month = "Jan";
	}else if(thirdDay_month == 1){
		thirdDay_month = "Feb";
	}else if(thirdDay_month == 2){
		thirdDay_month = "Mar";
	}else if(thirdDay_month == 3){
		thirdDay_month = "Apr";
	}else if(thirdDay_month == 4){
		thirdDay_month = "May";
	}else if(thirdDay_month == 5){
		thirdDay_month = "Jun";
	}else if(thirdDay_month == 6){
		thirdDay_month = "Jul";
	}else if(thirdDay_month == 7){
		thirdDay_month = "Aug";
	}else if(thirdDay_month == 8){
		thirdDay_month = "Sep";
	}else if(thirdDay_month == 9){
		thirdDay_month = "Oct";
	}else if(thirdDay_month == 10){
		thirdDay_month = "Nov";
	}else if(thirdDay_month == 11){
		thirdDay_month = "Dec";
	}else{}

	if(thirdDay_day==0){
		thirdDay_day = "Sun";
	}else if(thirdDay_day==1){
		thirdDay_day = "Mon";
	}else if(thirdDay_day==2){
		thirdDay_day = "Tue";
	}else if(thirdDay_day==3){
		thirdDay_day = "Wed";
	}else if(thirdDay_day==4){
		thirdDay_day = "Thu";
	}else if(thirdDay_day==5){
		thirdDay_day = "Fri";
	}else if(thirdDay_day==6){
		thirdDay_day = "Sat";
	}else{}
	$('.thirdDay_day').text(thirdDay_day);
	$('.thirdDay_month').text(thirdDay_month);
	$('.thirdDay_date').text(thirdDay_date);
	var fourthDay_full_date = new Date(today_date.getTime() + (86400000*3));
	var fourthDay_date = fourthDay_full_date.getDate();
	var fourthDay_month = fourthDay_full_date.getMonth();
	var fourthDay_day = fourthDay_full_date.getDay();
	if(fourthDay_month == 0){
		fourthDay_month = "Jan";
	}else if(fourthDay_month == 1){
		fourthDay_month = "Feb";
	}else if(fourthDay_month == 2){
		fourthDay_month = "Mar";
	}else if(fourthDay_month == 3){
		fourthDay_month = "Apr";
	}else if(fourthDay_month == 4){
		fourthDay_month = "May";
	}else if(fourthDay_month == 5){
		fourthDay_month = "Jun";
	}else if(fourthDay_month == 6){
		fourthDay_month = "Jul";
	}else if(fourthDay_month == 7){
		fourthDay_month = "Aug";
	}else if(fourthDay_month == 8){
		fourthDay_month = "Sep";
	}else if(fourthDay_month == 9){
		fourthDay_month = "Oct";
	}else if(fourthDay_month == 10){
		fourthDay_month = "Nov";
	}else if(fourthDay_month == 11){
		fourthDay_month = "Dec";
	}else{}

	if(fourthDay_day==0){
		fourthDay_day = "Sun";
	}else if(fourthDay_day==1){
		fourthDay_day = "Mon";
	}else if(fourthDay_day==2){
		fourthDay_day = "Tue";
	}else if(fourthDay_day==3){
		fourthDay_day = "Wed";
	}else if(fourthDay_day==4){
		fourthDay_day = "Thu";
	}else if(fourthDay_day==5){
		fourthDay_day = "Fri";
	}else if(fourthDay_day==6){
		fourthDay_day = "Sat";
	}else{}
	$('.fourthDay_day').text(fourthDay_day);
	$('.fourthDay_month').text(fourthDay_month);
	$('.fourthDay_date').text(fourthDay_date);
	var fifthDay_full_date = new Date(today_date.getTime() + (86400000*4));
	var fifthDay_date = fifthDay_full_date.getDate();
	var fifthDay_month = fifthDay_full_date.getMonth();
	var fifthDay_day = fifthDay_full_date.getDay();
	if(fifthDay_month == 0){
		fifthDay_month = "Jan";
	}else if(fifthDay_month == 1){
		fifthDay_month = "Feb";
	}else if(fifthDay_month == 2){
		fifthDay_month = "Mar";
	}else if(fifthDay_month == 3){
		fifthDay_month = "Apr";
	}else if(fifthDay_month == 4){
		fifthDay_month = "May";
	}else if(fifthDay_month == 5){
		fifthDay_month = "Jun";
	}else if(fifthDay_month == 6){
		fifthDay_month = "Jul";
	}else if(fifthDay_month == 7){
		fifthDay_month = "Aug";
	}else if(fifthDay_month == 8){
		fifthDay_month = "Sep";
	}else if(fifthDay_month == 9){
		fifthDay_month = "Oct";
	}else if(fifthDay_month == 10){
		fifthDay_month = "Nov";
	}else if(fifthDay_month == 11){
		fifthDay_month = "Dec";
	}else{}

	if(fifthDay_day==0){
		fifthDay_day = "Sun";
	}else if(fifthDay_day==1){
		fifthDay_day = "Mon";
	}else if(fifthDay_day==2){
		fifthDay_day = "Tue";
	}else if(fifthDay_day==3){
		fifthDay_day = "Wed";
	}else if(fifthDay_day==4){
		fifthDay_day = "Thu";
	}else if(fifthDay_day==5){
		fifthDay_day = "Fri";
	}else if(fifthDay_day==6){
		fifthDay_day = "Sat";
	}else{}
	$('.fifthDay_day').text(fifthDay_day);
	$('.fifthDay_month').text(fifthDay_month);
	$('.fifthDay_date').text(fifthDay_date);
	var sixthDay_full_date = new Date(today_date.getTime() + (86400000*5));
	var sixthDay_date = sixthDay_full_date.getDate();
	var sixthDay_month = sixthDay_full_date.getMonth();
	var sixthDay_day = sixthDay_full_date.getDay();
	if(sixthDay_month == 0){
		sixthDay_month = "Jan";
	}else if(sixthDay_month == 1){
		sixthDay_month = "Feb";
	}else if(sixthDay_month == 2){
		sixthDay_month = "Mar";
	}else if(sixthDay_month == 3){
		sixthDay_month = "Apr";
	}else if(sixthDay_month == 4){
		sixthDay_month = "May";
	}else if(sixthDay_month == 5){
		sixthDay_month = "Jun";
	}else if(sixthDay_month == 6){
		sixthDay_month = "Jul";
	}else if(sixthDay_month == 7){
		sixthDay_month = "Aug";
	}else if(sixthDay_month == 8){
		sixthDay_month = "Sep";
	}else if(sixthDay_month == 9){
		sixthDay_month = "Oct";
	}else if(sixthDay_month == 10){
		sixthDay_month = "Nov";
	}else if(sixthDay_month == 11){
		sixthDay_month = "Dec";
	}else{}

	if(sixthDay_day==0){
		sixthDay_day = "Sun";
	}else if(sixthDay_day==1){
		sixthDay_day = "Mon";
	}else if(sixthDay_day==2){
		sixthDay_day = "Tue";
	}else if(sixthDay_day==3){
		sixthDay_day = "Wed";
	}else if(sixthDay_day==4){
		sixthDay_day = "Thu";
	}else if(sixthDay_day==5){
		sixthDay_day = "Fri";
	}else if(sixthDay_day==6){
		sixthDay_day = "Sat";
	}else{}
	$('.sixthDay_day').text(sixthDay_day);
	$('.sixthDay_month').text(sixthDay_month);
	$('.sixthDay_date').text(sixthDay_date);
	var seventhDay_full_date = new Date(today_date.getTime() + (86400000*6));
	var seventhDay_date = seventhDay_full_date.getDate();
	var seventhDay_month = seventhDay_full_date.getMonth();
	var seventhDay_day = seventhDay_full_date.getDay();
	if(seventhDay_month == 0){
		seventhDay_month = "Jan";
	}else if(seventhDay_month == 1){
		seventhDay_month = "Feb";
	}else if(seventhDay_month == 2){
		seventhDay_month = "Mar";
	}else if(seventhDay_month == 3){
		seventhDay_month = "Apr";
	}else if(seventhDay_month == 4){
		seventhDay_month = "May";
	}else if(seventhDay_month == 5){
		seventhDay_month = "Jun";
	}else if(seventhDay_month == 6){
		seventhDay_month = "Jul";
	}else if(seventhDay_month == 7){
		seventhDay_month = "Aug";
	}else if(seventhDay_month == 8){
		seventhDay_month = "Sep";
	}else if(seventhDay_month == 9){
		seventhDay_month = "Oct";
	}else if(seventhDay_month == 10){
		seventhDay_month = "Nov";
	}else if(seventhDay_month == 11){
		seventhDay_month = "Dec";
	}else{}

	if(seventhDay_day==0){
		seventhDay_day = "Sun";
	}else if(seventhDay_day==1){
		seventhDay_day = "Mon";
	}else if(seventhDay_day==2){
		seventhDay_day = "Tue";
	}else if(seventhDay_day==3){
		seventhDay_day = "Wed";
	}else if(seventhDay_day==4){
		seventhDay_day = "Thu";
	}else if(seventhDay_day==5){
		seventhDay_day = "Fri";
	}else if(seventhDay_day==6){
		seventhDay_day = "Sat";
	}else{}
	$('.seventhDay_day').text(seventhDay_day);
	$('.seventhDay_month').text(seventhDay_month);
	$('.seventhDay_date').text(seventhDay_date);
});

// calandar script ends here

$(document).ready(function(){
	var morning_hours=8;
	for(morning_hours; morning_hours<12; morning_hours++){
		var minutes = 00;
			for(minutes; minutes<=45; minutes+=15){
				if(minutes==0){
					$('ul.morning-time').append('<li> '+morning_hours+' : 00 AM</li>');
				}else{
					$('ul.morning-time').append('<li> '+morning_hours+' : '+minutes+' AM</li>');
				}
			}
	}
	var afternoon_hours=12;
	for(afternoon_hours; afternoon_hours<16; afternoon_hours++){
		var minutes = 00;
		var a_h= 0;
		if(afternoon_hours>=13){a_h = afternoon_hours-12}else{a_h = afternoon_hours}
			for(minutes; minutes<=45; minutes+=15){
				if(minutes==0){
					$('ul.afternoon-time').append('<li> '+ a_h+' : 00 PM</li>');
				}else{
					$('ul.afternoon-time').append('<li> '+ a_h+' : '+minutes+' PM</li>');
				}
			}
	}
	var evening_time=16;
	for(evening_time; evening_time<20; evening_time++){
		var minutes = 00;
		var a_h= 0;
		if(evening_time>=13){a_h = evening_time-12}else{a_h = evening_time}
			for(minutes; minutes<=45; minutes+=15){
				if(minutes==0){
					$('ul.evening-time').append('<li> '+ a_h+' : 00 PM</li>');
				}else{
					$('ul.evening-time').append('<li> '+ a_h+' : '+minutes+' PM</li>');
				}
			}
	}
	var night_time=20;
	for(night_time; night_time<22; night_time++){
		var minutes = 00;
		var a_h= 0;
		if(night_time>=13){a_h = night_time-12}else{a_h = night_time}
			for(minutes; minutes<=45; minutes+=15){
				if(minutes==0){
					$('ul.night-time').append('<li> '+ a_h+' : 00 PM</li>');
				}else{
					$('ul.night-time').append('<li> '+ a_h+' : '+minutes+' PM</li>');
				}
			}
	}
});
$(document).ready(function(){
	$('.meridion_selection .tab-content ul').append('<input type="hidden" name="booking_time" class="booking_time">');
	$('.meridion_selection .tab-content ul li').click(function(){
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
});
function reset_filters(){
	document.getElementById('filters_form').reset();
}
$(function() {
  $( "#slider-range" ).slider({
    range: true,
    min: 0,
    max: 3000,
    values: [ 900, 1900 ],
    slide: function( event, ui ) {
     $( "#amount" ).val(ui.values[ 0 ] );
      $( "#amount2" ).val(ui.values[ 1 ] );
    }
  });
  $( "#amount" ).val($( "#slider-range" ).slider( "values", 0 ) );
   $( "#amount2" ).val( $( "#slider-range" ).slider( "values", 1 )  );
});
$(document).ready(function(){
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
});
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
 $(function(){
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
var i = 0;
	$('.nextapp').on('click',function(){
		$('.prevapp').show();
		if(i <= 3){
			var length = $(this).parent().parent().children().length-2;
			var myyear;var mydate; var mymonth;
			myyear = $('.nextapp').attr('year');
			$.each($(this).parent().parent().children(),function(k,v){
				$(this).removeClass('active');
				if(k >= 1 && k <= length){
					mydate = $(this).children().children().next().children().first().html();
					mymonthname = $(this).children().children().next().children().next().html();
					mymonth = getmonthindex(mymonthname);
					var presentdate = new Date(myyear,mymonth,mydate);
					var nextdate = new Date(presentdate.getTime() + (86400000*7));
					$(this).children().children().next().children().first().html(nextdate.getDate());
					$(this).children().children().next().children().next().html(getmonthname(nextdate.getMonth()));
					$(this).children().children().first().html(getdayname(nextdate.getDay()));
					$('.nextapp').attr('year',nextdate.getFullYear())
				}
			});
			i++;
			if(i == 4){
				$('.nextapp').hide();
			}
		}
	});

	$('.prevapp').on('click',function(){
		$('.nextapp').show();
		if(i > 0){
			var length = $(this).parent().parent().children().length-2;
			var myyear;var mydate; var mymonth;
			myyear = $('.nextapp').attr('year');
			$.each($(this).parent().parent().children(),function(k,v){
				if(k >= 1 && k <= length){
					mydate = $(this).children().children().next().children().first().html();
					mymonthname = $(this).children().children().next().children().next().html();
					mymonth = getmonthindex(mymonthname);
					var presentdate = new Date(myyear,mymonth,mydate);
					var nextdate = new Date(presentdate.getTime() - (86400000*7));
					$(this).children().children().next().children().first().html(nextdate.getDate());
					$(this).children().children().next().children().next().html(getmonthname(nextdate.getMonth()));
					$(this).children().children().first().html(getdayname(nextdate.getDay()));
					$('.nextapp').attr('year',nextdate.getFullYear());
				}
				if(i == 1 && k == 1){$(this).addClass('active');}
			});
			i--;
			if(i == 0){
				$('.prevapp').hide();
			}
		}
	});
});
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
 function uploadDoctorProfilePicure(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
		    $('#doctor-profile-picute-set').attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}
}
$(document).ready(function(){
	$('#change-profile-click').on('click',function(){
		$('#browse-image').trigger('click');
	});
	$('#browse-image').on('change',function(){
		uploadDoctorProfilePicure(this);
	});
	$('#add-specialization').on('click',function(){
		var specialization=prompt("Enter The Area You Are Specialized In","");
		$('.doctor-specialization').append('<li>'+specialization+'<i class="fa fa-times remove-specialization"></i>'+'</li>');
	});
	$('.common-padding-doctor').on('click','li i',function(){
		$(this).parent().remove();
	});
	 $("#carousel-example-generic").carousel({
		interval : 6000,
		pause: false
     });
});
