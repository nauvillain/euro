function addLikes(id,action) {
	$('.likes #post_'+id).each(function(index) {
		$(this).addClass('selected');
		$('#post_'+id+' #rating').val((index+1));
		if(index == $('.likes #post_'+id).index(obj)) {
			return false;	
		}
	});
	$.ajax({
	url: "add_likes.php",
	data:'id='+id+'&action='+action,
	type: "POST",
	beforeSend: function(){
		$('#post_'+id+' .btn-likes').html("<img src='img/loaderIcon.gif' />");
	},
	success: function(data){
	var likes = parseInt($('#likes-'+id).val());
	switch(action) {
		case "like":
		$('#post_'+id+' .btn-likes').html('<input type="button" title="Unlike" class="unlike" onClick="addLikes('+id+',\'unlike\')" />');
		likes = likes+1;
		
		break;
		case "unlike":
		$('#post_'+id+' .btn-likes').html('<input type="button" title="Like" class="like"  onClick="addLikes('+id+',\'like\')" />')
		likes = likes-1;
		break;
	}
		$('#likes-'+id).val(likes);
	str=(likes == 1? "Like" : "Likes");
	if(likes>0) {
		$('#post_'+id+' .label-likes').html(likes+" "+str);
	} else {
		$('#post_'+id+' .label-likes').html('');
	}
	}
	});
};

function addDislikes(id,action) {
	$('.dislikes #post_'+id).each(function(index) {
		$(this).addClass('selected');
		$('#post_'+id+' #rating').val((index+1));
		if(index == $('.dislikes #post_'+id).index(obj)) {
			return false;	
		}
	});
	$.ajax({
	url: "add_dislikes.php",
	data:'id='+id+'&action='+action,
	type: "POST",
	beforeSend: function(){
		$('#post_'+id+' .btn-dislikes').html("<img src='img/loaderIcon.gif' />");
	},
	success: function(data){
	var dislikes = parseInt($('#dislikes-'+id).val());
	switch(action) {
		case "dislike":
		$('#post_'+id+' .btn-dislikes').html('<input type="button" title="Undislike" class="undislike" onClick="addDislikes('+id+',\'undislike\')" />');
		dislikes = dislikes+1;
		break;
		case "undislike":
		$('#post_'+id+' .btn-dislikes').html('<input type="button" title="Dislike" class="dislike"  onClick="addDislikes('+id+',\'dislike\')" />')
		dislikes = dislikes-1;
		break;
	}
		$('#dislikes-'+id).val(dislikes);
	str=(dislikes == 1? "Dislike" : "Dislikes");
	if(dislikes>0) {
		$('#post_'+id+' .label-dislikes').html(dislikes+" "+str);
	} else {
		$('#post_'+id+' .label-dislikes').html('');
	}
	}
	});
};
/*$(document).ready(function(){
	$('.like_unlike').each(

		function(){
			post_id=$(this).find('input.forum_post_id').val();
			type=$(this).find('input.like_type').val();
			if(type=='like') {
				like_type='list_likes.php';
							 }
			else {
				like_type='list_dislikes.php';
				 }
			$.ajax({
			url: like_type,
			data:'post_id='+post_id,
			type: "POST",
			success: function(data){
				$('#post_'+post_id).find('.click').append(data);
				if(type=='dislike') {
										$('#post_'+post_id).find("span").css({"margin-left":"180px","width":"300px"});
										$('#post_'+post_id).find("span").css({"color":"red"});
									}
				else  $('#post_'+post_id).find("span").css({"color":"blue"});
								   }	
			});
			$('.like_unlike').find('span.list_likes').toggle();
		
		}	
		
											);

				});*/
