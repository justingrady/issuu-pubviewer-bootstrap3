if (!Array.prototype.indexOf) {
    Array.prototype.indexOf = function(d) {
        if (this == null) {
            throw new TypeError()
        }
        var e = Object(this);
        var b = e.length >>> 0;
        if (b === 0) {
            return -1
        }
        var c = 0;
        if (arguments.length > 1) {
            c = Number(arguments[1]);
            if (c != c) {
                c = 0
            } else {
                if (c != 0 && c != Infinity && c != -Infinity) {
                    c = (c > 0 || -1) * Math.floor(Math.abs(c))
                }
            }
        }
        if (c >= b) {
            return -1
        }
        var a = c >= 0 ? c : Math.max(b - Math.abs(c), 0);
        for (; a < b; a++) {
            if (a in e && e[a] === d) {
                return a
            }
        }
        return -1
    }
}

function checkSyncWall() {
    var g = readCookie(g_SESSION_ID_TAG);
    if (!g || g == "null") {
        g = ""
    }
    g_PAGEURL = window.location.toString();
    log("g_PAGEURL: " + g_PAGEURL);
    var h = getAuthToken(g_PAGEURL);
    if (h != "") {
        createCookie(g_AUTHTOKEN, h, 36500, "/");
        var i = g_PAGEURL.toString().indexOf("sp-tk");
        g_PAGEURL = g_PAGEURL.toString().substr(0, i)
    }
    var e = g_PAGEURL;
    g_PAGEURL = g_PAGEURL.replace(/#.*$/, "");
    var h = readCookie(g_AUTHTOKEN);
    if (!h || h == "null") {
        h = ""
    }
    var b;
    var d = document.getElementsByName("__sync_contentCategory");
    if (d && d[0]) {
        b = d[0].content;
        log("contentId: " + b)
    } else {
        return
    }
    var f = referringDomain(document.referrer);
    log("referrer: " + f);
    log("encoded referrer:" + document.referrer);
    var c = "";
    log("recentlyVisited: " + recentlyVisited(g_PAGEURL.toString()));
    var a = getChannelSource(g_PAGEURL, "");
    log("Channel: " + a);
    if (!recentlyVisited(g_PAGEURL.toString())) {
        callServer(g, h, b, c, f, e, "serverCallback", a)
    } else {
        createCookie(g_HISTORY, updateHistory(g_PAGEURL.toString()), 36500, "/")
    }
}

function getChannelSource(d, b) {
    var a = "";
    if (d) {
        var c = "E-Edition";
        a = (d.match("/eedition/")) ? c : a
    }
    return a
}

function recentlyVisited(c) {
    var a = pageHistory();
    if (a == null) {
        return false
    }
    if (g_REFRESHLIMIT === 0) {
        return false
    }
    var d = a.indexOf(c);
    if (d == -1) {
        return false
    }
    if (g_REFRESHTIMELIMIT === 0) {
        return false
    }
    var b = a[d + 1];
    if (timeDiff(new Date().getTime(), b) > g_REFRESHTIMELIMIT) {
        return false
    }
    return true
}

function pageHistory() {
    var a = readCookie(g_HISTORY);
    if (!a || a == "null") {
        return null
    }
    return a.split(",")
}

function timeDiff(a, c) {
    var b = a - c;
    var d = Math.floor(b / 60000);
    return d
}

function updateHistory(b) {
    var a = pageHistory();
    var c = -1;
    if (a != null) {
        c = a.indexOf(b)
    }
    if (c == -1) {
        if (a == null) {
            a = new Array()
        }
        if ((a.length / 2) >= g_REFRESHLIMIT) {
            replaceOldest(a, b)
        } else {
            a.push(b);
            a.push(new Date().getTime())
        }
    } else {
        a.splice(c + 1, 1, new Date().getTime())
    }
    return a.join(",")
}

function replaceOldest(a, e) {
    var c = new Date("12/31/2199").getTime();
    var d = -1;
    for (var b = 1; b < a.length; b += 2) {
        if (a[b] < c) {
            c = a[b];
            d = b
        }
    }
    if (d > 0) {
        a.splice(d - 1, 2, e, new Date().getTime())
    } else {
        a.push(e);
        a.push(new Date().getTime())
    }
}

function getAuthToken(b) {
    var a = getParameterByName("sp-tk");
    log("auth-token: " + a);
    return a
}

function getParameterByName(a) {
    a = a.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var c = "[\\?&]" + a + "=([^&#]*)";
    var b = new RegExp(c);
    var d = b.exec(window.location.search);
    if (d == null) {
        return ""
    } else {
        return decodeURIComponent(d[1].replace(/\+/g, " "))
    }
}

function referringDomain(b) {
    var c = b.split("/");
    var a = "";
    if (c.length > 2) {
        a = "http://" + c[2] + "/foo.htm"
    }
    return a
}

function callServer(p, a, h, j, m, k, d, f) {
    var r = encodeURI(p);
    var g = encodeURIComponent(h);
    var i = encodeURIComponent(j);
    var n = encodeURIComponent(m);
    var l = encodeURIComponent(k);
    var e = encodeURIComponent(d);
    var b = encodeURIComponent(a);
    var c = "https://stage.syncaccess.net/wc/bb/api/svcs/meter";
    var q = encodeURI(f);
    var o = c + "?sessionId=" + r + "&contentId=" + g + "&externalId=" + i + "&referrer=" + n + "&page=" + l + "&authToken=" + b + "&source=" + q + "&callback=" + e + "&nocache=" + new Date().getTime();
    log("serverURL: " + o);
    InsertScriptElement(o)
}

function InsertScriptElement(c) {
    var b = document.createElement("script");
    b.setAttribute("type", "text/javascript");
    b.setAttribute("src", c);
    log("script: " + b.outerHTML);
    var a = document.getElementsByTagName("head").item(0);
    if (!a) {
        a = document.getElementsByTagName("body").item(0)
    }
    a.appendChild(b)
}

function serverCallback(c) {
    var a = c.authorized.toLowerCase();
    var e = c.sessionIdentifier;
    var d = c.overlayContent;
    var b = c.authToken;
    var f = c.showWarning;
    var g = readCookie("tncms-authtoken");
    log("serverCallback Data:");
    log("    authorized:  " + a);
    log("    sessionId:   " + e);
    log("    authToken:   " + b);
    log("    showWarning: " + f);
    log("    overlayContent:\n" + d);
    if (a != "true") {
        if (d.substring(0, 9) == "redirect:") {
            createCookie(g_SESSION_ID_TAG, e, 36500, "/");
            displayRedirect(d.substring(9))
        } else {
            if (g && f == "true") {
                log("User is logged into Town News. No warning.")
            } else {
                displayOverlay(d, f);
                if (f == "true") {
                    createCookie(g_HISTORY, updateHistory(g_PAGEURL.toString()), 36500, "/")
                }
            }
        }
    } else {
        createCookie(g_HISTORY, updateHistory(g_PAGEURL.toString()), 36500, "/")
    }
    if (e && e != "") {
        createCookie(g_SESSION_ID_TAG, e, 36500, "/")
    }
    if (b && b != "") {
        createCookie(g_AUTHTOKEN, b, 36500, "/")
    }
}

function createCookie(d, f, b, e) {
    var c;
    if (b) {
        var a = new Date();
        a.setTime(a.getTime() + (b * 24 * 60 * 60 * 1000));
        c = "; expires=" + a.toGMTString()
    } else {
        c = ""
    }
    document.cookie = d + "=" + f + c + "; path=" + e + ";"
}

function readCookie(e) {
    var f = e + "=";
    log(document.cookie);
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
    createCookie(a, "x", -1, "/")
}

function forceCookie() {
    var a = document.getElementById("cookieVal");
    if (a) {
        var b = a.value;
        createCookie(g_SESSION_ID_TAG, b, 1)
    }
}

function loadCustomStyleSheet(b) {
    var a = document.getElementsByTagName("head").item(0);
    var c = document.createElement("link");
    c.type = "text/css";
    c.rel = "stylesheet";
    c.href = b;
    c.setAttribute("id", "_customCss_");
    a.appendChild(c)
}

function displayRedirect(a) {
    top.location.href = a
}

function displayOverlay(d, e) {
    if (g_DEBUG) {
        d += '<input type="button" class="sync-overlay-debug" value="Reset Session" onclick="eraseCookie(\'' + g_SESSION_ID_TAG + "'); return false;\" />"
    }
    var a = document.getElementsByTagName("body").item(0);
    loadCustomStyleSheet("https://stage.syncaccess.net/wc/bb/api/scripts/syncwallstyle");
    var c = document.createElement("div");
    c.setAttribute("id", "syncronexOverlay");
    var b = document.createElement("div");
    b.setAttribute("id", "syncronexOverlayContent");
    if (e == "true") {
        c.setAttribute("class", "syncronex-warning-overlay");
        b.setAttribute("class", "syncronex-warning-overlay-content")
    } else {
        c.setAttribute("class", "syncronex-wall-overlay");
        b.setAttribute("class", "syncronex-wall-overlay-content")
    }
    a.appendChild(c);
    b.innerHTML = d;
    a.appendChild(b)
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

function log(a) {
    if (g_DEBUG) {
        if (window.console && window.console.log) {
            console.log(a)
        }
    }
}

function dismissOverlay() {
    var b = document.getElementById("syncronexOverlay");
    var c = document.getElementById("syncronexOverlayContent");
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
var g_AUTHTOKEN = "syncwall-authToken";
var g_HISTORY = "syncwall-history";
var g_REFRESHLIMIT = 10;
var g_REFRESHTIMELIMIT = 4;
var g_PAGEURL;
var g_DEBUG = false;
if (g_DEBUG) {
    g_REFRESHLIMIT = 0;
    g_REFRESHTIMELIMIT = 0
}
if (window.addEventListener) {
    window.addEventListener("load", checkSyncWall, false)
} else {
    if (window.attachEvent) {
        window.attachEvent("onload", checkSyncWall)
    }
};