// Initialize Firebase
const firebaseurl = 'https://www.gstatic.com/firebasejs/4.13.0/firebase.js';
const ajaxUrl = (typeof save_token_url != 'undefined' ) ? save_token_url : self.origin + '/fcm/save_token';
//need to change this to USER source according to the source.
const user_source = 'indiashopps';
var config = {
    apiKey: "AIzaSyABLs3jtN_EVt_tkXdXVuhDHtKWGaSwXzA",
    authDomain: "indiashopps-web.firebaseapp.com",
    databaseURL: "https://indiashopps-web.firebaseio.com",
    projectId: "indiashopps-web",
    storageBucket: "indiashopps-web.appspot.com",
    messagingSenderId: "792648505029"
};

var check = setInterval(function () {

    if (typeof firebase != 'undefined') {
        clearInterval(check);

        firebase.initializeApp(config);

        const messaging = firebase.messaging();

        messaging.requestPermission().then(function () {
            if( typeof token_fetched !== 'undefined' )
            {
                token_fetched = true;
            }

            return messaging.getToken();
        }).then(function (token) {
            processCallback(true);
            sendRequest(token);
        }).catch(function (e) {
            processCallback(false);
        });

        messaging.onMessage(function (payload) {
            console.log('onMessage: ', payload);
        });
    }
    else {
        var jsElm = document.createElement("script");
        // set the type attribute
        jsElm.type = "application/javascript";
        // make the script element load file
        jsElm.src = firebaseurl;
        // finally insert the element to the body element in order to load the script
        document.body.appendChild(jsElm);
    }
}, 500);

function sendRequest($token) {
    var http = new XMLHttpRequest();
    var url = ajaxUrl
    var params = "fcm_token=" + $token + "&user_source=" + user_source + "&browser=" + getBrowser();

    http.open("GET", url + "?" + params, true);

    //Send the proper header information along with the request
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    http.onreadystatechange = function () {//Call a function when the state changes.
        if (http.readyState == 4 && http.status == 200) {
            console.log(http.responseText);
        }
    }

    http.send(null);
}

function processCallback(status) {
    if (typeof callback == 'function') {
        callback(status);
    }
}

function getBrowser() {
    var browser = '';
    //Check if browser is IE
    if (navigator.userAgent.search("MSIE") >= 0) {
        browser = 'internet_explorer';
    }
    //Check if browser is Chrome
    else if (navigator.userAgent.search("Chrome") >= 0) {
        browser = 'chrome';
    }
    //Check if browser is Firefox
    else if (navigator.userAgent.search("Firefox") >= 0) {
        browser = 'firfox';
    }
    //Check if browser is Safari
    else if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") > 0) {
        browser = 'safari';
    }
    //Check if browser is Opera
    else if (navigator.userAgent.search("Opera") >= 0) {
        browser = 'opera';
    }

    return browser;
}