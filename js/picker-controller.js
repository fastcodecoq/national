 
var control = 0;
var firstime = true;

 function ini(){


	var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
 
  var checkin = $('#contact-ddeparture').datepicker({
    
}).on('changeDate', function(ev) {
      
  

   checkin.hide();

   if(firstime){
   
   checkout.show();
   firstime = false;

    }


}).data('datepicker');

var checkout = $('#contact-darrival').datepicker({
 
}).on('changeDate', function(ev) {
  
if ( (ev.date.valueOf() > checkin.date.valueOf()) ) {


    var newDate = new Date(ev.date)
    newDate.setDate(newDate.getDate());
    checkout.setValue(newDate);
    checkout.hide();

    temp = ev.date;

  }else if(ev.date.valueOf() < checkin.date.valueOf()){

    var newDate = new Date(ev.date)
    newDate.setDate(newDate.getDate() - 1);
    checkin.setValue(newDate);

   $('#contact-ddeparture')[0].focus();
    checkout.hide();



  }else{

      checkout.hide();

  }



}).data('datepicker');


$("body div:not('a[href^='#!']')").click(function(){


	$("a[href^='#!']").each(function(){  
	   
	    $(this).removeClass("active");

	});

});

  $("a[href^='#!']").live("click", function(e){

  	e.preventDefault();
  	e.stopPropagation();

  	var a = $(this);
  	var dp = $(a.attr("rel"));

  	if(a.hasClass("active")){
   	 
   	  dp.datepicker("hide");
   	  a.removeClass("active");

   	 } else {

   	 	dp.datepicker("show");
   	    a.addClass("active");

   	 }

     });

 }

    $(document).ready(ini);
