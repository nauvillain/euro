<script type='text/javaScript'>
<!--

var arr=new Array();
var complete=false;
arr[0]=16;
arr[1]=17;
arr[2]=20;
arr[3]=21;
arr[4]=18;
arr[5]=19;
arr[6]=22;
arr[7]=23;
arr[8]=24;
arr[9]=25;
arr[10]=26;
arr[11]=27;
arr[12]=30;
arr[13]=31;

function load_teams(){

complete=true;
check_all_scores();
}
function checkTies(theForm){

	 for(i=0;i<theForm.length-2;i+=2){
		 if((theForm.elements[i].value!='')&&(theForm.elements[i+1].value!='')){	
			 if(theForm.elements[i].value==theForm.elements[i+1].value){
				 alert('No draws accepted in the last round phase!');
				 return false;
			 }
		 }
	 }
	 return true;

}

function checkForm2(thisForm){

	 return(checkForm(thisForm)&&checkTies(thisForm));
	 
}
function check_all_scores(){

	var i=0
	for (i=0;i<14;i++) {
		check_score(i);	
	}
}	
function check_score(match){
	if(complete){
		var pos=match+1;
		var last_match=15;
		var third_place=14;
		if((match!=last_match)&&(match!=third_place)){
			var g1=document.getElementById('goals1'+pos).value;
			var g2=document.getElementById('goals2'+pos).value;

			if(!(allDigits(g1)&&allDigits(g2))) 	{
				alert("Please enter digits only!");
				reset_fields('goals1'+pos,'goals2'+pos);
			}
			else {
				var team1=document.getElementById('team'+(2*match));
				var team2=document.getElementById('team'+(2*match+1));

				var nm=arr[match];
				var nr=(nm-(nm%2))/2;
				//alert('match'+match+'nr'+nr);
				var next_round=document.getElementById('tr'+nr);
				var next_match=document.getElementById('team'+nm);


				if((g1!='')&&(g2!='')) {
					if(g1!=g2){
						var w='w';
						if(g1>g2) replace_team(team1,next_match,next_round);
						else replace_team(team2,next_match,next_round);

					}
				}
				if((match==12)||(match==13)) {
					nm_l=arr[match]-2;
					nr_l=(nm_l-(nm_l%2))/2;
					next_round=document.getElementById('tr'+nr_l);
					next_match=document.getElementById('team'+nm_l);
					if((g1!='')&&(g2!='')) {
						if(g1!=g2) {
							var l='l';
							if(g1>g2) replace_team(team2,next_match,next_round);
							else replace_team(team1,next_match,next_round);
						}
						else {

						}	
					} 
				}
				check_score(nr);
				
			}
		}
}

}
function reset_fields(id1,id2) {
				document.getElementById(id1).value='';
                		document.getElementById(id2).value='';
                                document.getElementById(id1).focus();
}
function replace_team(team,next_m,next_r) {

		var qualified= team.cloneNode(true);
		var buf=next_m.getAttribute("id");
		next_r.replaceChild(qualified,next_m);
		qualified.setAttribute("id",buf);

}

function loadTD(pos,index,team_id,team_name,n) {
 var newTD=document.createElement("td");
if((n=='true')&&(index>7)) team_name='---';
 var newText=document.createTextNode(team_name);
 newTD.appendChild(newText);
 
 var newTR=document.getElementById('tr'+index);
 newTR.appendChild(newTD);

 newTD.setAttribute("valign",'top');
 newTD.setAttribute("width",'35%');

 if (pos=='1'){
  newTD.setAttribute("id",'team'+(2*index));
  newTD.setAttribute("align",'center');
 }
 else {
   newTD.setAttribute("id",'team'+(2*index+1));
   newTD.setAttribute("align",'center');
 }

}

function loadInpTD(pos,index,goals_scored) {
 var newTD=document.createElement("td");
 var newInp=document.createElement("input");

 newTD.appendChild(newInp);

 var newTR=document.getElementById('tr'+index);
 newTR.appendChild(newTD);
 
 newTD.setAttribute("width","5%");

 var goals='goals';
if (pos=='1') goals += '1';
if (pos=='2') goals += '2';

var ind=parseInt(index)+1;
 newInp.setAttribute("name",goals+ind);
 newInp.setAttribute("id",goals+ind);
 newInp.setAttribute("size",'2');
 newInp.setAttribute("type",'text');
 newInp.setAttribute("onChange",'check_score('+index+')'); 
if(goals_scored!='') newInp.value=goals_scored;

}

function even_number(value){

 if (value % 2 == 0) return true;
 else return false;
}
//-->
</script>
