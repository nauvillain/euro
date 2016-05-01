
<script type='text/javascript'>

var rem=new Array();

function insert_new_post(id,thread,player_name,title,content,last_mod){

	var newLI=document.createElement('li');
	var newList=document.createElement('ul');	
	
	newLI.appendChild(newList);
	create_post(id,thread,player_name,title,content,last_mod,newList)	
	
	newList.setAttribute('id','par_'+id);
	newLI.setAttribute('id',id);
//	newList.setAttribute('onclick','switch_thread('+id+','+thread+')');
	if(parseInt(thread)==0){
		var parent=document.getElementById('par_'+parseInt(thread));
		parent.appendChild(newLI);
	}
	if(!rem[thread]) rem[thread]=new Array();
	rem[thread][id]=newLI;
	
	/*if(parseInt(thread)!=0) {
				if (!rem[thread]) rem[thread]=new Array();	
				rem[thread][id]=parent.removeChild(newLI);
				//alert('rem:'+thread+','+id);		
		}*/
}
function create_post(id,thread,player_name,title,content,last_mod,newSpan){

	append_text(thread,id,newSpan,title,'title');
	append_text(thread,id,newSpan,'from '+player_name+' on '+last_mod,'info');
//	assemble_info(id,newSpan);
	append_text(thread,id,newSpan,'    reply to this post','link');        
        append_text(thread,id,newSpan,content,'content');


}
function assemble_info(id,node){

	var newp=document.createElement('p');
	var t1=document.getElementById('title_'+id);
//	var t3=document.getElementsByTagName('b');
//	alert(t3[0]);	
	var t2=document.getElementById('info_'+id);
	newp.appendChild(t1);
	newp.appendChild(t2);
	newp.setAttribute('class','thread_info');
	node.appendChild(newp);
}
function append_text(thread,id,node,text,type){

//	newp.setAttribute('id',id);
 switch(type){
	case 'title':		
				var newBT=document.createTextNode(text);
				var newT=document.createElement('b');
				newT.appendChild(newBT);
				newT.setAttribute('id','title_'+id);
				//newT.style.backgroundColor="#0000ff";
				newT.setAttribute('onclick','switch_thread('+id+','+thread+')');
				
				node.appendChild(newT);
				break;
	case 'info' :		var newp=document.createElement('span');
				var newT=document.createTextNode('      '+text);
				newp.appendChild(newT);
				newp.setAttribute('id','info_'+id);
				newp.setAttribute('onclick','switch_thread('+id+','+thread+')');
//				newp.setAttribute('onMouseOver','this.style.backgroundColor=\"red\"');
//				newp.setAttribute('onMouseOut','this.style.backgroundColor=\"white\"');
				node.appendChild(newp);
				newp.setAttribute('class','thread_info');
	//			newp.style.backgroundColor="#0000ff";
				break;
	
	case 'content'	:
				var newp=document.createElement('p');
				//text=text.replace("\\","\n");
				var newT=document.createTextNode(text);
				var newBR=document.createElement('p');
				newp.setAttribute('class','thread_post');
				newp.appendChild(newT);
				node.appendChild(newp);
                               // node.appendChild(newBR);
				break;
	case 'link' 	:	var newp=document.createElement('a');
				newp.setAttribute('href','#');
				newp.setAttribute('onClick','javascript:openwin(\"post1.php?thread='+id+'\",600,400)');
				
				var newT=document.createTextNode(text);
				newp.appendChild(newT);
				newp.setAttribute('id','link_'+id);
				node.appendChild(newp);
				break;
 }

	//node.appendChild(newT);
}

function switch_thread(id,parent){
	
	var thread=document.getElementById('par_'+id);
	var chpp=5;
	var chpp_ind=chpp-1;
//	chpp_ind is the amount of children per node needed for each post; ie the number of children before a new LI is created.
	if(rem[id]){
//		alert(thread.childNodes.length);
		if(thread.childNodes.length<chpp) {
			for (elm in rem[id]){
//				alert(elm);	
				thread.appendChild(rem[id][elm]);
			}
		}
		else {  var n_nodes=thread.childNodes.length;
			while (thread.childNodes[chpp_ind]) {
				//alert(n_nodes);	
				var num=thread.childNodes[chpp_ind].getAttribute('id');
//				alert('prem:'+id+','+num);
				rem[id][num]=thread.removeChild(thread.childNodes[chpp_ind]);
			}
		}
	}

}

function remove_all(){

	
	for(x in rem) {
		//alert(x);
		elm=document.getElementById('par_'+x);
		while(elm.childNodes[0]){
		elm.removeChild(elm.childNodes[0]);
		}
	}
}

function display_thread(thread,depth){

	parent=document.getElementById('par_'+thread);
	for(x in rem[thread]){
		parent.appendChild(rem[thread][x]);
	}

}

</script>
