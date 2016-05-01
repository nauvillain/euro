// ==UserScript==
// @name        Highlight Backlog > 3 days
// @namespace   http://*.ibm.com
// @include     https://w3-01.sso.ibm.com/software/servdb/secure/l3AnalystProfile.do*
// @require     http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js
// @version     1
// ==/UserScript==
Number.prototype.mod = function(n) {
    return ((this%n)+n)%n;
}
Date.prototype.addBusDays = function(dd) {
    var wks = Math.floor(dd/5);
    var dys = dd.mod(5);
    var dy = this.getDay();
    if (dy === 6 && dys > -1) {
       if (dys === 0) {dys-=2; dy+=2;}
       dys++; dy -= 6;}
    if (dy === 0 && dys < 1) {
       if (dys === 0) {dys+=2; dy-=2;}
       dys--; dy += 6;}
    if (dy + dys > 5) dys += 2;
    if (dy + dys < 1) dys -= 2;
    this.setDate(this.getDate()+wks*7+dys);
    return this;
}


console.log("CRM Highlight Backlog v0.1");
$("th:contains('Backlog Engagements for')")
    .parent()
    .parent()
    .children('tr')
    .each(function(i,e)
{
    //console.log("In function");
    //console.log("There are %s children", $(e).children('td').length);
    if ($(e).children('td').length < 2)
        return;

    var cell = $(e).children('td')[1];
    console.log("Parsing date for %s", $(cell).text());
    var t = $(cell).text().match(/^\d+-\d+-\d+\s\d+:\d+/);
    console.log("T is %s", t);
    if (t != null)
        return;

    var dp = $(cell).text().match(/(\d+)/g);

    if (dp == null || dp.length < 5 || dp.length> 12)
        return;

    var d = new Date(dp[0], dp[1] - 1, dp[2], dp[3], dp[4]);
    var t = new Date();
    console.log("D winds up being: %s", d);
    //console.log("T - 3: %s", t.addBusDays(-3));
    //console.log("Diff3: %s", d >= t.addBusDays(-3) );

    if (d <= t.addBusDays(-3))
    {
        $(cell)
            .css("font-weight","bold")
            .css("color","red");
    }
    else if (d <= t.addBusDays(-2))
    {
        $(cell)
            .css("font-weight","bold")
            .css("color","#FF6347");
    }
    else     {
        $(cell)
            .css("color","green")
            .css("font-weight","bold");
    }
});