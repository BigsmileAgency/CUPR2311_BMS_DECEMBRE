/**
 * title: Weborama Billboard, 
 * author: Weborama-NL,
 * version: 2.0.1,
 * date: Thu Nov 02 2017,
 */
! function(e) {
    function t(a) {
        if (n[a]) return n[a].exports;
        var o = n[a] = {
            i: a,
            l: !1,
            exports: {}
        };
        return e[a].call(o.exports, o, o.exports, t), o.l = !0, o.exports
    }
    var n = {};
    t.m = e, t.c = n, t.i = function(e) {
        return e
    }, t.d = function(e, n, a) {
        t.o(e, n) || Object.defineProperty(e, n, {
            configurable: !1,
            enumerable: !0,
            get: a
        })
    }, t.n = function(e) {
        var n = e && e.__esModule ? function() {
            return e.default
        } : function() {
            return e
        };
        return t.d(n, "a", n), n
    }, t.o = function(e, t) {
        return Object.prototype.hasOwnProperty.call(e, t)
    }, t.p = "", t(t.s = 1)
}([function(e, t) {
    function n(e) {
        switch (e.type) {
            case "playing":
                onVideoPlaying();
                break;
            case "pause":
                onVideoPause();
                break;
            case "timeupdate":
                break;
            case "ended":
                onVideoEnded();
                break;
            case "volumechange":
                break;
            default:
                console.warn("Weborama: Received no valid event")
        }
    }

    function a() {
        V && D.pause()
    }

    function o() {
        D.addEventListener("playing", n), D.addEventListener("pause", n), D.addEventListener("timeupdate", n), D.addEventListener("ended", n), D.addEventListener("volumechange", n)
    }

    function r() {
        var e = {
            width: videoWidth,
            height: videoHeight,
            reference: "video",
            prependTo: document.getElementById("video-container"),
            controls: "auto",
            click: "default",
            poster: videoPoster,
            loop: !1,
            autoplay: !1,
            muted: !1,
            videoFiles: [{
                src: videoSource,
                type: "video/mp4"
            }]
        };
        k = new screenad.video.VideoPlayer(e), D = k.getVideoElement(), setTimeout(o, 200)
    }

    function c() {
        1 === N && S === M && (_ = M, E = L), "banner" !== T ? screenad.executeScript("document.getElementById('weborama_pushdown_div').style.height = '" + _ + "px'") : screenad.resize(screenad.bannerwidth, _, "banner"), screenad.position()
    }

    function d() {
        S > _ ? _ += Math.ceil((S - _) / 3) : _ -= Math.ceil((_ - S) / 2), C > E ? E += Math.ceil((C - E) / 3) : E -= Math.ceil((E - C) / 2), _ === S && E === C ? (clearInterval(B), screenad.isShowing || screenad.show(), _ === M ? (screenad.setClip(P - L, "auto", "auto", M), c(), "function" == typeof onCollapseComplete && onCollapseComplete()) : (screenad.setClip("auto", "auto", "auto", "auto"), c(), "function" == typeof onExpandComplete && onExpandComplete())) : (screenad.setClip(P - E, "auto", "auto", _), c())
    }

    function i() {
        clearInterval(B), B = setInterval(d, 60)
    }

    function s() {
        "function" == typeof onCollapseStart && onCollapseStart(), V && a(), S = M, C = L, i(), "" !== j && screenad.executeScript("if (typeof WeboSetCookie == 'function') { WeboSetCookie(1,24); }")
    }

    function p() {
        "function" == typeof onExpandStart && onExpandStart(), S = A, C = P, i(), "" !== j && screenad.executeScript("if (typeof WeboSetCookie == 'function') { WeboSetCookie(0,24); }")
    }

    function u(e) {
        N = e, 1 === N ? s() : p()
    }

    function l() {
        screenad.executeScript("WeboGetCookie();", u)
    }

    function m() {
        var e;
        G || (G = !0, e = "var ele = document.createElement('script');var oHead = document.getElementsByTagName('head')[0];ele.type = 'text/javascript';var scr = 'function WeboSetCookie (value, cookieDuration) {adrCap = parseInt(value);adrID = " + j + ';var today = new Date();var year = today.getYear();if (year < 2000) year = year + 1900;document.cookie = adrID +"="+ adrCap;expires = new Date(year,today.getMonth(),today.getDate() + cookieDuration).toGMTString()+";path=/;";}function WeboGetCookie() {adrID = ' + j + ';adrCap = document.cookie.match("(^|;) ?' + j + "=([^;]*)(;|$)\");adrCap = (adrCap)?parseInt(unescape(adrCap[2])):0;return adrCap;}';ele.text = scr;oHead.appendChild(ele);", screenad.executeScript(e, l))
    }

    function f() {
        var e = window.location !== window.parent.location ? document.referrer : document.location;
        screenad.isPreviewer || void 0 === screenad.vars.scrcampaignid || "true" !== screenad.vars.scrcookie ? screenad.isPreviewer && e.indexOf("adrime_watcher") > -1 || e.indexOf("webo_watcher") > -1 ? (j = "12345", m()) : (c(), screenad.isShowing || screenad.show()) : (j = screenad.vars.scrcampaignid, m())
    }

    function v() {
        screenad.removeEventListener(screenad.SHOW, v), "function" == typeof onAdStart && onAdStart()
    }

    function y() {
        screenad.addEventListener(screenad.SHOW, v), document.getElementById("collapseButton") && document.getElementById("collapseButton").addEventListener("click", function() {
            _ === A ? (s(), document.getElementById("collapseButton").setAttribute("src", z)) : _ === M && (p(), document.getElementById("collapseButton").setAttribute("src", H))
        })
    }

    function g() {
        screenad.setSticky(!1), void 0 !== R.zindex && R.zindex.length > 0 && screenad.setZIndex(R.zindex), screenad.setAlignment(W, T), screenad.setOffset(isNaN(R.offsetx) ? 0 : R.offsetx, isNaN(R.offsety) ? 0 : R.offsety), screenad.position(), y(), V && r(), f()
    }

    function x() {
        var e, t, n;
        if ("" !== R.halign && void 0 !== R.halign && (W = R.halign), "" !== R.valign && void 0 !== R.valign && (T = R.valign), "banner" !== T) {
            switch (T) {
                case "top":
                    t = "document.getElementsByTagName('body')[0].insertBefore(scr_tmpID, document.getElementsByTagName('body')[0].childNodes[0]);";
                    break;
                case "content":
                    t = "var _wrap = document.getElementById('" + R.contentId + "').parentNode; _wrap.insertBefore(scr_tmpID, document.getElementById('" + R.contentId + "'));";
                    break;
                case "header":
                    t = "var _wrap = document.getElementById('" + R.headerId + "').parentNode; _wrap.insertBefore(scr_tmpID, document.getElementById('" + R.headerId + "'));";
                    break;
                case "wrapper":
                    t = "var _wrap = document.getElementById('" + R.wrapperId + "').parentNode; _wrap.insertBefore(scr_tmpID, document.getElementById('" + R.wrapperId + "'));";
                    break;
                default:
                    -1 !== T.indexOf("#") ? (n = T.replace("#", ""), t = "var _wrap = document.getElementById('" + n + "').parentNode; _wrap.insertBefore(scr_tmpID, document.getElementById('" + n + "'));") : t = "document.getElementsByTagName('body')[0].insertBefore(scr_tmpID, document.getElementsByTagName('body')[0].childNodes[0]);"
            }
            "" !== R.extrajs && void 0 !== R.extrajs && (-1 !== R.extrajs.indexOf("&lt;") && (R.extrajs = R.extrajs.replace(/&lt;/g, "<"), R.extrajs = R.extrajs.replace(/&gt;/g, ">")), t += "try{ " + R.extrajs + " }catch(e){}"), e = "var divID = 'weborama_pushdown_div';scr_tmpID = document.createElement('div');scr_tmpID.style.margin       = '4px';scr_tmpID.style.padding      = '0px';scr_tmpID.style.clear        = 'both';scr_tmpID.id                 = divID ;" + t, screenad.executeScript(e), T = "#weborama_pushdown_div"
        } else try {
            "" !== R.extrajs && void 0 !== R.extrajs && (-1 !== R.extrajs.indexOf("&lt;") && (R.extrajs = R.extrajs.replace(/&lt;/g, "<"), R.extrajs = R.extrajs.replace(/&gt;/g, ">")), screenad.executeScript(R.extrajs))
        } catch (e) {
            console.error("Weborama: siteObject is empty or undefined")
        }
        setTimeout(g, 200)
    }

    function h(e) {
        var t, n, a = new XMLHttpRequest;
        a.overrideMimeType && a.overrideMimeType("application/json"), a.open("GET", J + e, !0), a.onreadystatechange = function() {
            if (4 === a.readyState && 200 === a.status) {
                t = JSON.parse(a.responseText);
                for (n in t.site) t.site[n] && (R[n] = t.site[n]);
                x()
            }
        }, a.onerror = function(e) {
            console.error("Weborama: JSON Load Error: ", e.status), screenad.show(), y(), V && r()
        }, a.send(null)
    }

    function b() {
        void 0 !== screenad.vars.scrhasvideo && (V = screenad.vars.scrhasvideo)
    }

    function w() {
        screenad.setAlignment("center", "banner"), screenad.setSize(P, A), screenad.hide(), screenad.position()
    }

    function I() {
        E = P, _ = A, w(), b(), O ? screenad.executeScript("document.location", h) : x()
    }
    var E, _, S, C, B, k, D, j, N, O = !0,
        T = "banner",
        W = "center",
        L = 100,
        M = 40,
        P = 970,
        A = 250,
        H = "//media.adrcdn.com/ad-resources/weborama_close_88x88.png",
        z = "//media.adrcdn.com/ad-resources/weborama_open_88x88.png",
        V = !1,
        G = !1,
        R = {},
        J = "//cntr.adrcntr.com/sitespecs/?site=";
    screenad.onPreloadComplete = function() {
        "function" == typeof onDocumentReady && onDocumentReady(), window !== window.top ? I() : "function" == typeof onAdStart && onAdStart()
    }
}, function(e, t, n) {
    e.exports = n(0)
}]);