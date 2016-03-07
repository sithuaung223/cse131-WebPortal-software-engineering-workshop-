/*

	index.js
*/


$(document).ready(function(){

	//alert(' JS is working');
	pop_modules();
	$(".side-pane-item").on('click', function () {
        $("iframe").attr("src",  $(this).attr('val'));
    });
});





function pop_modules(){
	
	//alert("pop called");
	
	var mods = ['syllabus', 'calendar', 'modules'];
	var links = ['placholder.html', '../calendar/calendar_v1.html', '../module/module1.html']
	var mod_list = $("#mod-list");
	for (var m = 0; m < mods.length; m++){
		//console.log(m);
		mod_list.append("<li class='list-group-item'> <a class = 'side-pane-item' val = '" + links[m] + "' href = '#' >" + mods[m] + "</a></li>");
		
	}
	
	
	
	
}

