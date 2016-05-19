
$(document).ready(function(){
$('.like_unlike').hover(function(){
	post_id=$(this).find('input.forum_post_id').val();
	if($(this).find('input.like_type').val()=='like') like_type='list_likes.php';
	else like_type='list_dislikes.php';

	$.ajax({
	url: like_type,
	data:'post_id='+post_id,
	type: "POST",
	success: function(data){
		$('#post_'+post_id).append(data);
	}
	});
	
}, function(){
	$('#post_'+post_id).find("span").remove();
	
})});
