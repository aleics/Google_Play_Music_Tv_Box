function logout(){
	var x = document.getElementById("logoutbutton");
	//alert("pressed");

	$.ajax({
       	type: "POST",
       	url: "./php/ajax.php",
      	data: { fname: "logout"},
       	success: function(msg){ 
            alert('Success!');
       	}
   	});
};

/*$(document).ready(function () {

var page = 0;
        $('.arrowbtn').click(function(e){

                if($(this).attr('value') == 1){page++;}
                else if($(this).attr('value') == -1){page--;}

                if(page>0){$("#arrowbtnleft").show(); }
                else if(page==0){$("#arrowbtnleft").hide(); }
                else if(page=maxPages){$('#arrowbtnright').hide();}

	
		window.location.href = "http://ec2-54-195-232-8.eu-west-1.compute.amazonaws.com/GooglePlayWebTv/html/MyLibrary.php?page=" + page;
	

});


});*/



$(document).ready(function () {
		
	if($('#arrowbtnleft').attr('value').val < 0) $("#arrowbtnleft").hide()
	 
});















	/*$('#arrowbtnleft').click(function(e){

                var left =  $(this).attr('value');
		value--;
                e.preventDefault();
                $.ajax({
                type: "POST",
                url: "http://ec2-54-195-232-8.eu-west-1.compute.amazonaws.com/GooglePlayWebTv/php/ajax.php",
                data: { 'value': value },
                success: function(msg){
                   alert('Success!');
                },
                error: function(msg){
                        alert('Error!');
                }
                });
        });*/


/*function send(){
document.theform.submit();
alert('Submitted!');
}*/
/*$(document).ready(function () {
   document.getElementById('plusplaylist').onclick = function() {
   alert("button was clicked");
};*/


//document.getElementById('logoutbutton').onclick = function() {};

/*$('.button').click(function(){
        var clickBtnValue = $(this).val();
        var ajaxurl = 'ajax.php',
        data =  {'action': clickBtnValue};
        $.post(ajaxurl, data, function (response) {
            // Response div goes here.
            alert("action performed successfully");
        });
    });*/


//$('#logoutbutton').live('click', function() {
  //  $.get('../php/functions.php?functionName=logout');
    //return false;
//});

//});




/*$(document).ready(function () {
document.getElementById('logoutbutton').onclick = function() {
$.ajax({
  type: "POST",
  url: "../php/ajax.php",
  data: { name: "logout" }
}).done(function( msg ) {
  alert( "Data Saved: " + msg );
});
};
});*/
/* var Playlists = new Array();
Playlists = document.getElementById('Playlists'); */
