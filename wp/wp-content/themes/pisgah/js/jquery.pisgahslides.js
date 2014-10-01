$(document).ready(function(){
// Sliders are always fun. This one uses absolutely placed divs to hold the full slide content. The 0th div is normal and visible. The 1 div is loaded but hidden. The rest are loaded as they are cycled. This lowers the initial load and leaves enough time for the next slides to pre-load.

var transition_delay=5000;
var transition_time=1000;
var banner_time=0;
var banner_swap=false;

if($(".slide_frame").length>1){
setInterval ( function(){nextSlide();}, transition_delay);
}
function nextSlide(){
current=slide(0);


next=slide(1);
preload=slide(2);

show(next);
remove(current);
hide(preload);

}

function hide(slide_index){
	$("#slide_"+slide_index).css("z-index",1);
	$("#slide_"+slide_index).removeClass('shown');
	$("#slide_"+slide_index).removeClass('gone');
	$("#slide_"+slide_index).addClass('hidden');
}

function remove(slide_index){
hide_banner(slide_index);
	$("#slide_"+slide_index).css("z-index",3);
$("#slide_"+slide_index).fadeOut(transition_time,function(){

	$("#slide_"+slide_index).removeClass('shown');
	$("#slide_"+slide_index).addClass('gone');
	$("#slide_"+slide_index).removeClass('hidden');
	});	
}

function show(slide_index){
hide_banner(slide_index);
$("#slide_"+slide_index).show(1,function(){
	$(this).css("z-index",2);
	$("#slide_"+slide_index).addClass('shown');
	$("#slide_"+slide_index).removeClass('gone');
	$("#slide_"+slide_index).removeClass('hidden');
	setTimeout(function(){show_banner(slide_index);},transition_time);
	});

}

function hide_banner(slide_index){
	if(banner_swap){
	$("#slide_"+slide_index+" > .slide_banner").animate({bottom:"-40px"},banner_time);
	$("#slide_"+slide_index+" > .slide_title").animate({bottom:"-40px"},banner_time);
	}
}

function show_banner(slide_index){
	if(banner_swap){
	$("#slide_"+slide_index+" > .slide_banner").animate({bottom:"0px"},banner_time);
	$("#slide_"+slide_index+" > .slide_title").animate({bottom:"0px"},banner_time);
	}
}


// Gets the slide div that is (delta) from the current visible slide
function slide(delta){
	slide_count=$(".slide_frame").length;
	// The current slide (delta=0) is the one that is visible
	visible_slide_id=$(".slide_frame.shown").attr('id');
	id_array=visible_slide_id.split("_");
	visible_slide_index=parseInt(id_array[1]);	
	// If the delta is higher than the end of the slide count, loop it
	if(visible_slide_index-delta>slide_count){
		return slide(delta+slide_count);
	}
	if(visible_slide_index-delta<1){
		return slide(delta-slide_count);
	}
	return visible_slide_index-delta;
}
	
});


