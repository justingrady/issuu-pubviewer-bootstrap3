function checkSyncWall() {
    if (g_DEBUG) {
        g_logDiv = createLog()
    }
    var f = readCookie(g_SESSION_ID_TAG);
    if (!f || f == "null") {
        f = ""
    }
    var d = window.location;
    var c;
    var b = document.getElementsByName("__sync_contentCategory");
    if (b && b[0]) {
        c = b[0].content
    } else {
        return
    }
    var a = readCookie("sess");
    if (!a) {
        a = ""
    }
    var e = referringDomain(document.referrer);
    log("referrer: " + e);
    log("encoded referrer:" + document.referrer);
    callServer(f, c, a, e, d, "serverCallback")
}

function referringDomain(b) {
    var c = b.split("/");
    var a = "";
    if (c.length > 2) {
        a = c[2]
    }
    return a
}

function callServer(o, e, g, k, h, b) {
    var p = encodeURI(o);
    var d = encodeURIComponent(e);
    var f = encodeURIComponent(g);
    var l = encodeURIComponent(k);
    var i = encodeURIComponent(h);
    var c = encodeURIComponent(b);
    var a = "https://www.syncaccess.net/wc/bb/api/svcs/meter";
    var n = a + "?sessionId=" + p + "&contentId=" + d + "&externalId=" + f + "&referrer=" + l + "&page=" + i + "&callback=" + c + "&nocache=" + new Date().getTime();
    var m = document.createElement("script");
    m.setAttribute("type", "text/javascript");
    m.setAttribute("src", n);
    var j = document.getElementsByTagName("head").item(0);
    if (!j) {
        j = document.getElementsByTagName("body").item(0)
    }
    j.appendChild(m)
}

function serverCallback(b) {
    var e = "serverCallback: ";
    var a = b.authorized.toLowerCase();
    e += " authorized: " + a;
    var d = b.sessionIdentifier;
    e += " sessionId: " + d;
    var c = b.overlayContent;
    e += " overlayContent: " + c;
    if (a != "true") {
        displayOverlay(c)
    }
    createCookie(g_SESSION_ID_TAG, b.sessionIdentifier, 36500)
}

function createCookie(d, e, b) {
    var c;
    if (b) {
        var a = new Date();
        a.setTime(a.getTime() + (b * 24 * 60 * 60 * 1000));
        c = "; expires=" + a.toGMTString()
    } else {
        c = ""
    }
    document.cookie = d + "=" + e + c + "; path=/"
}

function readCookie(e) {
    var f = e + "=";
    var b = document.cookie.split(";");
    for (var d = 0; d < b.length; d++) {
        var a = b[d];
        while (a.charAt(0) == " ") {
            a = a.substring(1, a.length)
        }
        if (a.indexOf(f) == 0) {
            return a.substring(f.length, a.length)
        }
    }
    return null
}

function eraseCookie(a) {
    createCookie(a, "", -1)
}

function forceCookie() {
    var a = document.getElementById("cookieVal");
    if (a) {
        var b = a.value;
        createCookie(g_SESSION_ID_TAG, b, 1)
    }
}

function displayOverlay(overlayContent) {
    
    overlayContent = wescomReplaceString(overlayContent);
    var overlaycss = wescomOverlayCSS();
    
    if (g_DEBUG) {
        overlayContent += '<br><input type="button" value="Reset Cookie" onclick="eraseCookie(\'' + g_SESSION_ID_TAG + "'); return false;\" />";
        overlayContent += '<br /><input type="text" id="cookieVal" value="" /><input id="setCookieBut" type="button" value="Set Cookie" onclick="forceCookie();return false;" />'
    }

    var body = document.getElementsByTagName("body").item(0);
    var head = document.getElementsByTagName("head").item(0);
    var ss = document.createElement("link");
    ss.type = "text/css";
    ss.rel = "stylesheet";
    // ss.href = "https://www.syncaccess.net/wc/bb/api/scripts/syncwallstyle";
    ss.href = overlaycss;
    ss.setAttribute("id", "_customCss_");
    head.appendChild(ss);
    var oDiv = document.createElement("div");
    oDiv.setAttribute("id", "overlay");
    body.appendChild(oDiv);
    var ocDiv = document.createElement("div");
    ocDiv.setAttribute("id", "overlay-content");
    ocDiv.innerHTML = overlayContent;
    body.appendChild(ocDiv);
    var bStyle = body.style;
    bStyle.height = "100%";
    bStyle.margin = 0;
    bStyle.padding = 0;
    var oStyle = document.getElementById("overlay").style;
    oStyle.visibility = "visible";
    oStyle.position = "fixed";
    oStyle.left = "0px";
    oStyle.top = "0px";
    oStyle.width = "100%";
    oStyle.height = "100%";
    oStyle.zIndex = 2147483647;
    oStyle.backgroundColor = "#313131";
    oStyle.opacity = ".95";
    oStyle.filter = "alpha(opacity=95)";
    oStyle.MozOpacity = ".95";
    var ocStyle = document.getElementById("overlay-content").style;
    ocStyle.visibility = "visible";
    ocStyle.position = "fixed";
    var viewPort = GetWindowSize();
    var absoluteWidth = 750;
    var absoluteHeight = 500;
    ocStyle.left = eval((viewPort.Width - absoluteWidth) / 2) + "px";
    ocStyle.top = eval((viewPort.Height - absoluteHeight) / 2) + "px";
    ocStyle.width = absoluteWidth + "px";
    ocStyle.height = absoluteHeight + "px";
    ocStyle.margin = "auto";
    ocStyle.backgroundColor = "#FFFFFF";
    ocStyle.border = "5px solid #ddd";
    ocStyle.padding = "2px";
    ocStyle.zIndex = 2147483647;
    ocStyle.opacity = "1";
    ocStyle.filter = "alpha(opacity=100)";
    ocStyle.MozOpacity = "1";
    ocStyle.color = "#000000";
    ocStyle.fontFamily = "Arial, Helvetica, sans-serif";
    ocStyle.fontWeight = "normal"
}

function GetWindowSize() {
    var a = {
        Width: 0,
        Height: 0
    };
    if (typeof(window.innerWidth) == "number") {
        a.Width = window.innerWidth;
        a.Height = window.innerHeight
    } else {
        if (document.documentElement && (document.documentElement.clientWidth || document.documentElement.clientHeight)) {
            a.Width = document.documentElement.clientWidth;
            a.Height = document.documentElement.clientHeight
        } else {
            if (document.body && (document.body.clientWidth || document.body.clientHeight)) {
                a.Width = document.body.clientWidth;
                a.Height = document.body.clientHeight
            }
        }
    }
    return a
}

function createLog() {
    var a = document.createElement("div");
    a.setAttribute("id", "log");
    var b = document.getElementsByTagName("body").item(0);
    b.appendChild(a);
    a.innerHTML = "**DEBUG**<br>";
    return a
}

function log(a) {
    if (g_logDiv) {
        g_logDiv.innerHTML += a + "<br>"
    }
}

function dismissOverlay() {
    var b = document.getElementById("overlay");
    var c = document.getElementById("overlay-content");
    var a = document.getElementById("_customCss_");
    if (typeof c != "undefined") {
        removeElement(c)
    }
    if (typeof b != "undefined") {
        removeElement(b)
    }
    if (typeof a != "undefined") {
        removeElement(a)
    }
}

function removeElement(a) {
    a.parentNode.removeChild(a)
}
var g_SESSION_ID_TAG = "syncwall-sessionid";
var g_DEBUG = false;
var g_logDiv;
if (window.addEventListener) {
    window.addEventListener("load", checkSyncWall, false)
} else {
    if (window.attachEvent) {
        window.attachEvent("onload", checkSyncWall)
    }
};
