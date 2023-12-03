<!--
// Before you reuse this script you may want to have your head examined
// 
// Copyright 1999 InsideDHTML.com, LLC. 
var Blink= null;
function doBlink() {
// Blink, Blink, Blink...
var blink = document.all.tags("BLINK")
for (var i=0; i < blink.length; i++)
blink[i].style.visibility = blink[i].style.visibility == "" ? "hidden" : "" 
}
function startBlink() {
// Make sure it is IE4
if (document.all)
Blink = setInterval("doBlink()",1000);
}
function stopBlink() {
    clearInterval(Blink);
}

window.onload = startBlink;
//-->