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

