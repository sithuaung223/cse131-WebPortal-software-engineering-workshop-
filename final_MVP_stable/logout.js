function logoutAjax(event){
		 
		var dataString = "logout=" + encodeURIComponent("logout"); 

		var xmlHttp = new XMLHttpRequest();
		xmlHttp.open("POST", "php/logout.php", true); 
		xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
		xmlHttp.addEventListener("load", function(event){
			var jsonData = JSON.parse(event.target.responseText); 
			if(jsonData.success){  
				//alert("You've been Logged Out!");
				window.location = "Login.html";
			}else{
				alert("You have not logged Out.  "+jsonData.message);
			}
		}, false);
		xmlHttp.send(dataString); 
	}