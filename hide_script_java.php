<script language=javascript type='text/javascript'>
function hideDiv() {
if (document.getElementById) { // DOM3 = IE5, NS6
document.getElementById('hideShow').style.visibility = 'hidden';
}
else {
if (document.layers) { // Netscape 4
document.hideShow.visibility = 'hidden';
}
else { // IE 4
document.all.hideShow.style.visibility = 'hidden';
}
}
}
function showDiv() {
if (document.getElementById) { // DOM3 = IE5, NS6
document.getElementById('hideShow').style.visibility = 'visible';
}
else {
if (document.layers) { // Netscape 4
document.hideShow.visibility = 'visible';
}
else { // IE 4
document.all.hideShow.style.visibility = 'visible';
}
}
}

function switchMenu(obj) {
var el = document.getElementById(obj);
if ( el.style.display != 'none' ) {
el.style.display = 'none';
}
else {
el.style.display = '';
}
}
</script>

