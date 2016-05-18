
$('.like').each(function(){



	id=parseInt($(this.find('.forum_post_id')).val());
	alert(id);
	$(this).hover(function(){
	
		$.ajax({
		url:"list_likes.php",
		data:'id='+id,
		type= "POST",
		success:function(data){
		
		}

	},
	function(){
	
	});
	}};
