/*

	index.js
*/


$(document).ready(function(){

	//alert(' JS is working');

	pop_modules();
	$(".side-pane-item").on('click', function () {
        $("iframe").attr("src",  $(this).attr('val'));
    });
   	$('a:contains("calendar")').click();// auto click calendar when document is ready - sithu


	//logout function - sithu
	 
	function logoutAjax(event){
		var logout = document.getElementById("logout_btn").value; // Get the logout from the form
		var dataString = "logout=" + encodeURIComponent(logout); 

		var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
		xmlHttp.open("POST", "select.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
		xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
		xmlHttp.addEventListener("load", function(event){
			var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
			if(jsonData.success){  // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
				// alert("You've been Logged Out!");
				window.location="http://ec2-54-174-37-57.compute-1.amazonaws.com/~sithuaung/131website/testing.html";
			}else{
				alert("You have not logged Out.  "+jsonData.message);
			}
		}, false); // Bind the callback to the load event
		xmlHttp.send(dataString); // Send the data
	}

	document.getElementById("logout_btn").addEventListener("click", logoutAjax, false); // Bind the AJAX call to button click
});






function pop_modules(){
	
	//alert("pop called");
	
	var mods = ['syllabus', 'calendar', 'modules'];
	var links = ['placeholder.html', 'calendar/calendar_v1.html', 'modules/module1/module1.html']
	var mod_list = $("#mod-list");
	for (var m = 0; m < mods.length; m++){
		//console.log(m);
		mod_list.append("<li class='list-group-item'> <a class = 'side-pane-item' val = '" + links[m] + "' href = '#' >" + mods[m] + "</a></li>");
		
	}
	
	
	
	
}

