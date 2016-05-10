
function addPost(id) {
		//check if it is a new thread 
		var thread=id.split('_',2);
		
		//create the input div
		var replyDiv=document.createElement('div');
		replyDiv.id='reply'+id;
		replyDiv.className='middle';
		if(thread[1]=='0') {
			var newTitle=document.createElement('input');
			newTitle.size='50';
			newTitle.id='thread_title';
			var titleTag=document.createTextNode('Title');
			replyDiv.appendChild(titleTag);
			replyDiv.appendChild(newTitle);

		}
		var newPost = document.createElement('textarea');
		newPost.name = id+'_new';
		newPost.cols=65;
		newPost.rows=4;
		newPost.maxLength=2000;
		newPost.id = id+ '_new';
		newPost.className='reply';
		replyDiv.appendChild(newPost);
		thisDiv=document.getElementById(id);
		current_div=thisDiv.parentNode;
		//make Submit link
		var newLink=document.createElement('a');
		//newLink.href='#';
		newLink.onClick='loadNew('+id+')';
		textLink=document.createTextNode('Submit');
		newLink.appendChild(textLink);
		newLink.setAttribute('onClick','javascript:loadNew(\"'+ id +'\")');
		newLink.className='ajax_link_submit';
		textLink2=document.createTextNode('Cancel');
		//make Cancel link
		var newLink2=document.createElement('a');
		//newLink.href='#';
		newLink2.appendChild(textLink2);
		newLink2.className='ajax_link_cancel';
		newLink2.setAttribute('onClick','javascript:cancelPost(\"'+ id +'\")');
		textLink3=document.createTextNode('        ');
		//make spacing link
		var newLink3=document.createElement('em');
		newLink3.className='inline_spacing';
		newLink3.appendChild(textLink3);
		//add to the main div
		newLink.id = id+ '_l1';
		newLink.name = id+ '_l1';
			newLink.id = id+ '_l2';
			newLink2.name = id+ '_l2';
			newLink3.id = id+ '_l3';
			newLink3.name = id+ '_l3';
			replyDiv.appendChild(newLink);
			replyDiv.appendChild(newLink3);
			replyDiv.appendChild(newLink2);
			current_div.replaceChild(replyDiv,thisDiv);
			current_div.innerHTML=current_div.innerHTML;
	}

		function loadNew(id){
			var thread=id.split('_',2);
			var xmlhttp = new XMLHttpRequest();
			var text_id=id+'_new';
			var text=document.getElementById(text_id).value;
			text.replace("\n","<br/>",'g');
			if(thread[1]=='0') {
				var title=document.getElementById('thread_title').value;
				var url='forum_post.php?id='+id+'&text='+encodeURIComponent(text)+'&title='+encodeURIComponent(title);
			}
			else {
				var url='forum_post.php?id='+id+'&text='+encodeURIComponent(text);
			}	
			//if no text entered do nothing
			if((text==null)||(text=="")) return;
			//build the URL and pass the text in it (sic)
			xmlhttp.open('GET',url,true);
			replaceDiv(id);	
			xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 1) {
					document.getElementById(id).innerHTML='loading...';
					}
			if (xmlhttp.readyState == 4) {
	//				cancelPost(id);
					document.getElementById(id).innerHTML=xmlhttp.responseText;
					window.location.reload(true);	
			}
		}
	xmlhttp.send(null);
	return false;
		}

	function cancelPost(id){
//		alert();
		thisDiv=document.getElementById('reply'+id);
		currentDiv=thisDiv.parentNode;
		currentDiv.removeChild(thisDiv);
		//check if it is a new thread, if so, change the link text
		var thread=id.split('_',2);
		var str=replystr;
		//alert(id);
		//recreate the reply link
		if(thread[1]=='0') {
			str=newthreadstr;
		}

		var	textLink2=document.createTextNode(str);
		//make Cancel link
		var newLink2=document.createElement('a');
		//newLink.href='#';
		newLink2.appendChild(textLink2);
		newLink2.className='ajax_link';
		newLink2.id=id;
		newLink2.setAttribute('onClick','javascript:addPost(\"'+ id +'\")');
		var first=currentDiv.firstChild;
		currentDiv.appendChild(newLink2);	
		if(thread[1]=='0') currentDiv.appendChild(document.createElement('br'));
		currentDiv.innerHTML=currentDiv.innerHTML;
	}

	function replaceDiv(id){
		thisDiv=document.getElementById(id+'_new');
		currentDiv=thisDiv.parentNode;
		while (currentDiv.firstChild) {
 			 currentDiv.removeChild(currentDiv.firstChild);
		}		
		//create the title div with trigger class
		var newDiv=document.createElement('div');
		newDiv.className='expanded';	
		newDiv.name='titles';
//		create the Div containing the new text
		var newDiv=document.createElement('div');
		newDiv.className='forum_content dont-break-out';	
		newDiv.name='contents';
		newDiv.id=id;
		currentDiv.appendChild(newDiv);	
		current_div.innerHTML=current_div.innerHTML;
	}
