//creating check box function
function createNewCheckboxt(name, id){
    var checkbox = document.createElement('input'); 
    checkbox.type= 'checkbox';
    checkbox.name = name;
    checkbox.id = id;
    return checkbox;
}

//find cloumns
var table= document.getElementById("class_content");
var tr=table.getElementsByTagName("TR");
for (var i= 0; i< tr.length; i++){
 	var td=tr[i].getElementsByTagName("TD");
 	if (td.length> 3){
 		//find Assigned column
 		var link= td[td.length-2].getElementsByTagName("A");
 			//insert check box 
 			for (var index= 0; index< link.length; index++){
 				var cb= createNewCheckboxt("assignment_checkbox", i);
				link[index].parentNode.insertBefore(cb, link[index].nextSibling);
 			}
 			//find Due column
 		var link= td[td.length-1].getElementsByTagName("A");
 			//insert check box 
 			for (var index= 0; index< link.length; index++){
 				var cb= createNewCheckboxt("due_checkbox", i);
				link[index].parentNode.insertBefore(cb, link[index].nextSibling);
 			}
 	}
}

//all video lecture
var list= document.getElementsByTagName("A");
for (var i= 0; i< list.length; i++){
 	var cb= createNewCheckboxt("video_checkbox",i);
 	if ( list[i].target=="videonew"){
		list[i].parentNode.insertBefore(cb, list[i].nextSibling);
	}
}
