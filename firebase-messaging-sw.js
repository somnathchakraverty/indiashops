importScripts('https://www.gstatic.com/firebasejs/4.13.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/4.13.0/firebase-messaging.js');
var payloadData;

var config = {
    apiKey: "AIzaSyABLs3jtN_EVt_tkXdXVuhDHtKWGaSwXzA",
    authDomain: "indiashopps-web.firebaseapp.com",
    databaseURL: "https://indiashopps-web.firebaseio.com",
    projectId: "indiashopps-web",
    storageBucket: "indiashopps-web.appspot.com",
    messagingSenderId: "792648505029"
};

firebase.initializeApp(config);

const messaging = firebase.messaging();
var current_token = '';
var apiUrl = '';
var swVersion = "v2";

if (self.origin.indexOf('stage') > -1)
    apiUrl = 'https://stage.indiashopps.com';
else
    apiUrl = 'https://www.indiashopps.com';

messaging.setBackgroundMessageHandler(function(payload){

    const title    = payload.data.title;
    const options  = payload.data;
    payloadData    = payload.data;

    if(typeof payload.data.interaction != 'undefined')
    {
        options.requireInteraction = payload.data.interaction;
    }

    if('actions' in Notification.prototype && typeof payload.data.actions != 'undefined')
    {
        options.actions = JSON.parse(payload.data.actions);
    }

    if('image' in Notification.prototype && payload.data.big_image){
        options.image = payload.data.big_image;
    }

    options.icon = payload.data.image;

    return self.registration.showNotification(title,options);
});

self.addEventListener('notificationclick', function(event) {

    if( event.action )
    {
        clients.openWindow(event.action);
    }
    else
    {
        clients.openWindow(payloadData.click_action);
    }

    event.notification.close();
    return false;
});

self.addEventListener('notificationclose', function() {
    console.log("notification closed");
});


self.addEventListener('install', function(e) {
    update_token();
    e.waitUntil(self.skipWaiting());
    setTimeout(function(){
        UpgradeSW();
    },2000);
});

self.addEventListener('activate', function(e) {
    e.waitUntil(self.skipWaiting());
});

self.addEventListener('push', function(e) {
    update_token();
    e.waitUntil(self.skipWaiting());
    setTimeout(function () {
        UpgradeSW();
    }, 2000);
});

function update_token(e)
{
    return messaging.getToken().then(function(token){
        current_token = token
    }).catch(function(error){
        return false;
    });
}

function UpgradeSW() {
    self.registration.pushManager.getSubscription().then(function(subscription) {
        if (subscription != null) {
            console.log("ServiceWorker Upgraded");
            console.log(current_token);
            if( current_token.length > 0 )
            {
                fetch(apiUrl + "/api/fcm/subscribe?browser="+getBrowser()+"&token="+current_token+"&swv="+swVersion, {
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    method: "GET"
                }).then(function(res) {}).catch(function(res) {
                    console.log(res);
                });
            }

        } else {
            console.log("New User registration.");
        }
    })
};

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