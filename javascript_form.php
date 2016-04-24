<script language="JavaScript">
<!--

function checkForm(theForm){
			   for(i=0;i<theForm.length-3;i+=2){
					
					if((theForm[i].value!="")&&(theForm[i+1].value=="")) {
							 alert('Please enter a value for the "' + theForm[i+1].id +'" field.');
							 return false;
							 }
					if((theForm[i].value=="")&&(theForm[i+1].value!="")){
							alert('Please enter a value for the "' + theForm[i].id +'" field.');
							return false;
							}
					if(!validNum(theForm[i],theForm[i].id)) return false;
					if(!validNum(theForm[i+1],theForm[i+1].id)) return false;
					}
		return true;
			    
	 }
function allDigits(str)
{
	return inValidCharSet(str,"0123456789");
}

function inValidCharSet(str,charset)
{
	var result = true;
	if(str){
	// Note: doesn't use regular expressions to avoid early Mac browser bugs	
	for (var i=0;i<str.length;i++)
		if (charset.indexOf(str.substr(i,1))<0)
		{
			result = false;
			break;
		}
	}
	return result;
}

function validNum(formField,fieldLabel)
{
	var result = true;

	 
 	if (formField!="")
 	{
 		if (!allDigits(formField.value))
 		{
 			alert('Please enter a number for the "' + fieldLabel +'" field.');
			formField.focus();		
			result = false;
		}
	} 
	
	return result;
}

function validRequired(formField,fieldLabel)
{
	var result = true;
	
	if (formField.value == "")
	{
		alert('Please enter a value for the "' + fieldLabel +'" field.');
		formField.focus();
		result = false;
	}
	
	return result;
}

function validateForm(theForm)
{
	// Start ------->
	if (!validRequired(theForm.username,"username"))
		return false;
	if (!validRequired(theForm.password,"password"))
		return false;
	if (!validRequired(theForm.first_name,"first name"))
		return false;
	
	// <--------- End
	
	return true;
}

function validateFormUser(theForm)
{
	// Start ------->
	if ((theForm.nickname.value=="")&&(theForm.first_name.value==""))
	{	
		alert('Please enter either a nickname or a first name');
		return false;
	}	
	// <--------- End
	
	return true;
}

function newPost(theForm)
{

	 if (theForm.title.value=="") {
	    alert('Please enter a title for your message');
	    return false;}
	 if (theForm.content.value=="") {
	    alert('Your message is empty!');
	    return false;}
	 return true
}

function sum(theForm){


}
//-->
</script>
