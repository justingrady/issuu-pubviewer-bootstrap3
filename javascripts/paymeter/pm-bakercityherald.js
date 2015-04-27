function wescomReplaceString(str) {
	var newstring = '';
	// newstring = str.replace('siteid=BULL', 'siteid=BCH').replace('tbb-cmdbtest1_', '').replace('http://bendbulletin.com/', 'http://ee.bakercityherald.com');
	newstring = str.replace('zipcampaign.html?siteid=BULL', 'addrfind.html?siteid=BCH').replace('tbb-cmdbtest1_', '').replace('http://bendbulletin.com/', 'http://ee.bakercityherald.com');
	return newstring;
}

// @codekit-append "pm-main-desktop.js"
