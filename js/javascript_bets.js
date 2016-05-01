
function clearCheckbox(boxType1,matchId){
	var j=0;
	for (i=0;i<document.form1.elements.length;i++)
	{
		if (document.form1.elements[i].name == boxType1+matchId)
		{
			document.form1.elements[i].checked = false;
			j++;
			unset_row_css(matchId)
		}
	}
	if(j) comp_total('weight'+matchId);
	else alert('checkbox'+id+' not found');
}

function clearWeights(){
	for (i=0;i<document.form1.weight.length;i++)
	{
		document.form1.weight[i].checked = false;
	}
	document.form1.weight[0].checked=true;
}

function comp_tot(number,b_text){

	var newText=document.createTextNode(number);
	var newT=document.createElement("strong");
	newT.appendChild(newText);
	newT.setAttribute('id',b_text);
	newT.style.font='bold 12px lucida,sans-serif';
	var totalP=document.getElementById("total_points");
	var oldText=document.getElementById(b_text);
	var replaced=totalP.replaceChild(newT,oldText);	
		
}

function check_row(id){
	var pick=document.getElementsByName('pick'+id);
	
	var res=getCheckedValue(pick);
	if(res=='1') cell='first';
	if(res=='2') cell='pick';
	if(res=='3') cell='second';
	if(getChecked(pick)) set_row_css(cell,id)
	else unset_row_css(id);
	
		
}

function set_row_css(cell,id){

	unset_row_css(id);
	if(cell=='pick') {
		var row1=document.getElementById('first'+id);
		var row2=document.getElementById('second'+id);
		row1.style.color='#8B2500'
		row1.style.fontWeight='bold';
		row2.style.color='#8B2500'
		row2.style.fontWeight='bold';
	}
	else {
		var row=document.getElementById(cell+id)
//		row.style.background='#C4C4C4';
		row.style.fontWeight='bold';
	}
	add_check_sign(id);
}
function unset_row_css(id){


	var row=document.getElementById('first'+id);
	row.style.fontWeight='normal';
	row.style.color='black';	
	var row=document.getElementById('second'+id);
	row.style.fontWeight='normal';
	row.style.color='black';	
	remove_check_sign(id);
	}
function add_check_sign(id){
	
	var elm=document.getElementById('full_row'+id);
	var image=elm.firstChild;
	image.src='checkmark3.gif';
}
function remove_check_sign(id){
	
	var elm=document.getElementById('full_row'+id);
	var image=elm.firstChild;
	image.src='b_drop.png';
}
function warn_player(id){
	alert('Stop right there! You do not have enough points left for the remaining matches\n OR you have exceeded the maximum allowed.	\nPlease adjust the coefficients before submitting.','error1');
	clearCheckbox('weight',id);
}
function clear_warning(){
	load_error('','error1');
}
function load_error(text,id){
	var newText=document.createTextNode(text);
	var newT=document.createElement("strong");
	newT.appendChild(newText);
	newT.setAttribute('id',id);
	newT.style.font='bold 12px lucida,sans-serif';
	var totalP=document.getElementById("errors");
	var oldText=document.getElementById(id);
	var replaced=totalP.replaceChild(newT,oldText);	
	
}
function notify_player(){
	load_error('You will not be able to use all your points!...','error1');
}
function getCheckedValue(radioObj) {
	if(!radioObj) return "";
	var radioLength = radioObj.length;
	if(radioLength == undefined)
	if(radioObj.checked)
		return radioObj.value;
	else
		return "";
	for(var i = 0; i < radioLength; i++) {
		if(radioObj[i].checked) {
		return radioObj[i].value;
		}
	}
	return "";
}
function getChecked(radioObj) {
	if(!radioObj) return "";
	var radioLength = radioObj.length;
	var j=0;
	for(var i = 0; i < radioLength; i++) {
		if(radioObj[i].checked) j++;
	}
	if(j==0) return 0;
	else return 1;

	return "";
}
function showAttr(elm)  {
	       var firstPara = document.getElementById(elm);

	       // First, let's verify that the paragraph has some attributes    
	       if (firstPara.hasAttributes()) 
			       {
	       var attrs = firstPara.attributes;
	       var text = ""; 
	       for(var i=attrs.length-1; i>=0; i--) {
		        text += attrs[i].name + "->" + attrs[i].value;
	       		alert(attrs[i].name+"->"+attrs[i].value);
		}
	} else {
	      alert("No attributes to show");
	  };
}
function redirect(x){

		var temp=document.form1.stage2
		for (m=temp.options.length-1;m>0;m--)	temp.options[m]=null;
		for (i=0;i<group[x].length;i++)	temp.options[i]=new Option(group[x][i].text,group[x][i].value)
		if(temp.options[0]) temp.options[0].selected=true
}

