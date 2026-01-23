/*
Give the service worker access to Firebase Messaging.
Note that you can only use Firebase Messaging here, other Firebase libraries are not available in the service worker.
*/

/*importScripts('https://www.gstatic.com/firebasejs/8.7.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.7.1/firebase-messaging.js');*/
   
importScripts('https://www.gstatic.com/firebasejs/10.5.2/firebase-app-compat.js'); /**9.22.2 */
importScripts('https://www.gstatic.com/firebasejs/10.5.2/firebase-messaging-compat.js');
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
* New configuration for app@pulseservice.com
*/
firebase.initializeApp({
    apiKey: "AIzaSyDmcQjXQbO41MdaD5pR501eT2Q_Jdjl3BE",
    authDomain: "hr-connect-pro.firebaseapp.com",
    databaseURL: "https://hr-connect-pro-default-rtdb.firebaseio.com",
    projectId: "hr-connect-pro",
    storageBucket: "hr-connect-pro.appspot.com",
    messagingSenderId: "594201777602",
    appId: "1:594201777602:web:4e08559fb9599ad111b25b",
    measurementId: "G-YXTSS3TKXT"
});

const messaging = firebase.messaging(); 