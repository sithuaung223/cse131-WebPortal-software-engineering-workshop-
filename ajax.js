// ajax.js

//register
function registerAjax(event){
	var username = document.getElementById("Rusername").value; // Get the username from the form
	var password = document.getElementById("Rpassword").value; // Get the password from the form
 
	// Make a URL-encoded string for passing POST data:
	var dataString = "username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password);
 
	var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "insert.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
	xmlHttp.addEventListener("load", function(event){
		document.getElementById("Rusername").value= ""; // clear the username 
		document.getElementById("Rpassword").value= ""; // clear the password 
		var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
		if(jsonData.success){  // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
			alert("You've been Registered!");
		}else{
			alert("You were not Registered.  "+jsonData.message);
		}
	}, false); // Bind the callback to the load event
	xmlHttp.send(dataString); // Send the data
}

document.getElementById("register_btn").addEventListener("click", registerAjax, false); // Bind the AJAX call to button click

//login 
function loginAjax(event){
	var username = document.getElementById("Lusername").value; // Get the username from the form
	var password = document.getElementById("Lpassword").value; // Get the password from the form
 
	// Make a URL-encoded string for passing POST data:
	var dataString = "username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password);
 
	var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "select.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
	xmlHttp.addEventListener("load", function(event){
		document.getElementById("Lusername").value= ""; // clear the username
		document.getElementById("Lpassword").value= ""; // clear the password
		var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
		if(jsonData.success){  // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
			// alert("You've been Logged In!");
			window.location="http://ec2-54-174-37-57.compute-1.amazonaws.com/~sithuaung/131website/index.html";
		}else{
			alert("You were not logged in.  "+jsonData.message);
		}
	}, false); // Bind the callback to the load event
	xmlHttp.send(dataString); // Send the data
}

document.getElementById("login_btn").addEventListener("click", loginAjax, false); // Bind the AJAX call to button click

