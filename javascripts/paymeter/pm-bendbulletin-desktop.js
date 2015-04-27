function wescomReplaceString(str) {
	var newstring = '';
	newstring = str.replace('addrfind.html', 'zipcampaign?siteid=bull').replace('tbb-cmdbtest1_', '').replace('http://bendbulletin.com/', 'http://ee.bendbulletin.com');
	return newstring;
}

function wescomOverlayCSS() {
	var base = '';
	var css = '/css/paymeter/pm-desktop.css';
	var output = base + css;
	return output;
}

// @codekit-append "2013-4-2-1-syncpaymeter/pm-main-desktop.js"
