function wescomReplaceString(str) {
	var newstring = '';
	newstring = str.replace('zipcampaign.html?siteid=BULL', 'addrfind.html?siteid=OBSERVER').replace('tbb-cmdbtest1_', '').replace('http://bendbulletin.com/', 'http://ee.lagrandeobserver.com');
	return newstring;
}

function wescomOverlayCSS() {
	var base = '';
	var css = '/css/paymeter/pm-mobile.css';
	var output = base + css;
	return output;
}

// @codekit-append "2013-4-2-1-syncpaymeter/pm-main-mobile.js"
