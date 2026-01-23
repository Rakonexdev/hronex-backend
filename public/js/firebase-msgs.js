    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('./firebase-messaging-sw.js')
        .then(function(registration) {
            console.log('Registration successful, scope is:', registration.scope);
        }).catch(function(err) {
            console.log('Service worker registration failed, error:', err);
        });
    }
  
    const firebaseConfig = {
        apiKey: "AIzaSyDsvXcCPp4QqmtkDqO_DZ81SeVRtNaAq1M", 
        authDomain: "hr-connect-pro.firebaseapp.com",
        projectId: "hr-connect-pro",
        storageBucket: "hr-connect-pro.appspot.com",
        messagingSenderId: "594201777602",
        appId: "1:594201777602:web:4e08559fb9599ad111b25b",
        measurementId: "G-YXTSS3TKXT"
    };

    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();    

    function initFirebaseMessagingRegistration() {
            messaging
            .requestPermission()
            .then(() => {
                return messaging.getToken();
            })
            .then(function(token) {               

                /*if(document.querySelector('#login-form')){
                    document.querySelector('#device_token').value = token;
                    document.querySelector('#device_type').value = 'Web';
                    document.querySelector('#login-form').submit();
                }*/
                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
  
                $.ajax({
                    url: APP_URL+'/save-token',
                    type: 'POST',
                    data: {
                        device_token: token,
                        device_type: 'Web'
                    },
                    dataType: 'JSON',
                    success: function (response) {
                        console.log(response);
                    },
                    error: function (err) {
                        console.log(Messages.getText('FCM.TOKEN_SAVE_SUCC') + err);
                    },
                });
  
            }).catch(function (err) {
                console.log(Messages.getText('FCM.TOKEN_SAVE_SUCC') + err);
            });
     }  
      
    /*messaging.onMessage(function(payload) {
        const noteTitle = payload.notification.title;
        const noteOptions = {
            body: payload.notification.body,
            icon: payload.notification.icon,
        };
        new Notification(noteTitle, noteOptions);
    });*/

    /*window.Notification.requestPermission().then(function(permission) { });*/