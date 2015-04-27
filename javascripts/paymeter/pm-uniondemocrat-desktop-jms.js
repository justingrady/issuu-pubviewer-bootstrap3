function wescomReplaceString(str) {
	var newstring = '';
	// newstring = str.replace('siteid=BULL', 'siteid=BCH').replace('tbb-cmdbtest1_', '').replace('http://bendbulletin.com/', 'http://ee.bakercityherald.com');
	newstring = str.replace('zipcampaign.html?siteid=BULL','zipcampaign.html?siteid=UD').replace('tbb-cmdbtest1_', '').replace('http://bendbulletin.com/', 'http://www.uniondemocrat.com');
	// newstring = str;
	return newstring;
}

function wescomOverlayCSS() {
	var base = 'http://ee.uniondemocrat.com';
	var css = '/css/paymeter/pm-desktop-jms.css';
	var output = base + css;
	return output;
}

// @codekit-append "2013-4-2-1-syncpaymeter/pm-main-desktop.js"
