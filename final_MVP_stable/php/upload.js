/*
Javascript for upload.html
All functions have ajax call
*/


// input: a group of radio buttons which represent files' name in the File System
// output: get a checked radio button(the file's name) and called deleteFile() with that radio button as an argument
//restriction: function is called when "delete" button is clicked
function clickDelete(category){
	var fileName;
	var files= document.getElementsByName(category +"s");
	for(var i=0; i< files.length; i++){
		if(files[i].checked){
			var fileName= files[i].value;
			deleteFile(fileName, category);
			break;
		}
	}
}

// input: Name of a file
// output: Delete the file
// restriction: category (video, lab, studio) 
function deleteFile(fileName, category){
	//TODO get module name to variable moduleName dynamically
	var moduleName= 'module1';

	// encoding data to send
	var dataString = "moduleName=" + encodeURIComponent(moduleName)+"&fileName=" + encodeURIComponent(fileName) +"&category=" + encodeURIComponent(category); 

	// fire ajax request and handle response
	var xmlHttp = new XMLHttpRequest(); 
	xmlHttp.open("POST", "deleteFile.php", true); 
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlHttp.addEventListener("load", function(event){
		alert(event.target.responseText);
		var jsonData = JSON.parse(event.target.responseText); 
		if (jsonData.success){
			alert("Delete success");
			getFileList();
		}
		else {
			alert("Delete File Failed");
		}	
	}, false); 
	xmlHttp.send(dataString); 
}

//input: empty div which represent a list of files in a module of File System
//output: div will have the list of files as a radio button
//restriction: function is called when document is loaded; OR delete button is clicked; OR upload button is clicked
function getFileList(moduleName){
	// encoding data to send
	
	var dataString = "modulename=" + encodeURIComponent(moduleName); 

	// fire ajax request and handle response
	var xmlHttp = new XMLHttpRequest(); 
	xmlHttp.open("POST", "getFileList.php", true); 
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlHttp.addEventListener("load", function(event){

		var jsonData = JSON.parse(event.target.responseText); 
		if (jsonData.success){
			var videos= jsonData.videos;
			var labs= jsonData.labs;
			var studios= jsonData.studios;
		}
		else {
			alert("no File");
		}	
	}, false); 

	xmlHttp.send(dataString); 
}

//input: a file to be uploaded
//output: the file is uploaded to File System; its name and path are uploaded to Database
//restriction: file size is limited; video cannot be uploaded 
function uploadFile(category){

	var x= document.getElementById('uploadfile_input');
	if ('files' in x){
		if (x.files.length == 0){
			// No files selected
		}
		else {
			//TODO: use the following line instead of hard coding
			var moduleName= document.getElementById('module_name').value;
			
			for (var i=0; i< x.files.length; i++){

				var file= x.files[i];

				//create FormData object to store the information of the file
				var data= new FormData();
				data.append('SelectedFile', file);
				data.append('moduleName', moduleName);
				data.append('category', category);

				// Send the file to back end
				var xmlHttp = new XMLHttpRequest(); 
				xmlHttp.open("POST", "upload.php", true); 
				xmlHttp.addEventListener("load", function(event){
					alert(event.target.responseText);
					getFileList();
				}, false); 
				xmlHttp.send(data); 
			}
		}
	}
}

function clickEdit(category){
		var fileName;
		var files= document.getElementsByName(category +"s");
		for(var i=0; i< files.length; i++){
			if(files[i].checked){
				var fileName= files[i].value;
				editFile(fileName, category);
				break;
			}
		}
}

function editFile(fileName, category){
		var moduleName= $("#module_name").val();
		var full_path= '../resources/'+ moduleName + '/' + category + 's/' + fileName;
		$.get( full_path, function(data, status){
				alert("Data: " + data + "\nStatus: " + status);
		});
}
//call when document is loaded
document.addEventListener("DOMContentLoaded", function(event) { 
	getFileList();
	//button Listeners for Upload and Delete
	document.getElementById('edit_lab').addEventListener('click', function(){
				clickEdit('lab');
	}, false);
	document.getElementById('edit_studio').addEventListener('click', function(){
				clickEdit('studio');
	}, false);
	document.getElementById('upload_video').addEventListener('click', function(){
				uploadFile('video');
	}, false);
	document.getElementById('upload_lab').addEventListener('click', function(){
				uploadFile('lab');
	}, false);
	document.getElementById('upload_studio').addEventListener('click', function(){
				uploadFile('studio');
	}, false);

	document.getElementById('delete_video').addEventListener('click', function(){
				clickDelete('video');
	}, false);
	document.getElementById('delete_lab').addEventListener('click', function(){
				clickDelete('lab');
	}, false);
	document.getElementById('delete_studio').addEventListener('click', function(){
				clickDelete('studio');
	}, false);

});
