function checkLabGrade(){
	var lab= document.getElementById('lab');
	var labName= lab.value;

	var dataString = "labName=" + encodeURIComponent(labName); 

			// Send the file to back end
			var xmlHttp = new XMLHttpRequest(); 
			xmlHttp.open("POST", "getLabStatus.php", true); 
			xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xmlHttp.addEventListener("load", function(event){
				alert(event.target.responseText);
			}, false); 
			xmlHttp.send(dataString); 
}

function watchVideo(){

	var moduleName= document.getElementById('module_name').value;
	var video= document.getElementById('video');
	var videoName= video.value;

	var dataString = "moduleName=" + encodeURIComponent(moduleName)+"&videoName=" + encodeURIComponent(videoName); 

			// Send the file to back end
			var xmlHttp = new XMLHttpRequest(); 
			xmlHttp.open("POST", "watchVideo.php", true); 
			xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xmlHttp.addEventListener("load", function(event){
				alert(event.target.responseText);
			}, false); 
			xmlHttp.send(dataString); 
}
//call when document is loaded
document.addEventListener("DOMContentLoaded", function(event) { 
	//button Listeners for Upload and Delete
	document.getElementById('watch_video').addEventListener('click', watchVideo, false);
	document.getElementById('check_lab').addEventListener('click', checkLabGrade, false);

});

