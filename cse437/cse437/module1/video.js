function videoAjax(event){
	var module = document.getElementById("module_name").value; // Get the module name
	var url = document.getElementById("video_url").value;
	var vid= url.split('v=')[1];
	var ampersandPosition = vid.indexOf('&');
	if (ampersandPosition != -1){
	    vid= vid.substring(0, ampersandPosition);
	}

	var dataString = "module=" + encodeURIComponent(module) + "&vid=" + encodeURIComponent(vid);

	var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "video.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
	xmlHttp.addEventListener("load", function(event){
		var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
		if(jsonData.success){  // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
			alert("You have uploaded video");

		}else{
			alert("Video is not uploaded");
		}
	}, false); // Bind the callback to the load event
	xmlHttp.send(dataString); // Send the data

}

document.getElementById("submit").addEventListener("click", videoAjax, false); // Bind the AJAX call to button click

//show list of video
