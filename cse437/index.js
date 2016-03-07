/*

	index.js
*/


$(document).ready(function(){

	//alert(' JS is working');
	pop_modules();
});



function pop_modules(){
	
	//alert("pop called");
	
	var mods = ['mod1', 'mod2', 'mod3'];
	var mod_list = $("#mod-list");
	for (var m = 0; m < mods.length; m++){
		//console.log(m);
		mod_list.append("<li class='list-group-item'> <a = href = 'index.html'>" + mods[m] + "</a></li>");
		
	}
	
	
	
	
}

