//<div>Icon made by <a href="http://www.freepik.com" title="Freepik">Freepik</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed under <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></div>

var email="";
document.getElementById('iframe').src="https://csel.cs.colorado.edu/~jaki2391/index.php?email="+email;
document.getElementById('name').innerHTML+=email


chrome.tabs.query({
    active: true,               // Select active tabs
    lastFocusedWindow: true     // In the current window
}, function(array_of_Tabs) {
    // Since there can only be one active tab in one active window, 
    //  the array has only one element
    chrome.tabs.executeScript(array_of_Tabs[0].id,{code:'document.getElementsByName("to")[0].defaultValue;'},function(returnArray){email=returnArray[0]; setIframe(email); }
);
    // Example:
});
function setIframe(email){
	email = email.substr(email.search("<")+1);
    if(email.substr(length-2)==">"){
	   email=email.substr(0, email.length-1);
    }
    console.log(email);
	document.getElementById('iframe').src="https://csel.cs.colorado.edu/~jaki2391/index.php?email="+email;
	document.getElementById('name').innerHTML="Eq-Mail For: "+email;
    }
