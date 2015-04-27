function wescomReplaceString(str) {
	var newstring = '';
	// newstring = str.replace('siteid=BULL', 'siteid=BCH').replace('tbb-cmdbtest1_', '').replace('http://bendbulletin.com/', 'http://ee.bakercityherald.com');
	newstring = str.replace('zipcampaign.html?siteid=BULL', 'addrfind.html?siteid=BCH').replace('tbb-cmdbtest1_', '').replace('http://bendbulletin.com/', 'http://ee.bakercityherald.com');
	return newstring;
}

function wescomOverlayCSS() {
	var base = '';
	var css = '/css/paymeter/pm-desktop.css';
	var output = base + css;
	return output;
}
// @codekit-append "2013-4-2-1-syncpaymeter/pm-main-desktop.js"
