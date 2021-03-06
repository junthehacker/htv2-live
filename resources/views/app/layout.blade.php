<!DOCTYPE html>
<html>
    <head>
        <title>HTV2 Live - @yield('title')</title>
        <!--jQuery-->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <!--Bootstrap-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
        <!--Type Icons-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/typicons/2.0.9/typicons.min.css" />
        <!--Favicon-->
        <link rel="icon" href="images/favicon.png" />
        <!--Custom CSS-->      
        <link rel="stylesheet" href="css/app.css?v=07" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.13/vue.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.17.1/axios.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/1.0.5/push.min.js"></script>
    </head>
    <body>
    
    @include('partials.nav')
    @if(request()->is('/'))
        <div class="container-fluid" id="app">
    @else
        <div class="container" id="app">
    @endif
    @yield('content')
    </div>


    <div class="notify-top" id="notification-alert" style="display: none">
        <div class="notify-top-inner">Enable notification to receive timely update on upcoming events!<br><span class="text-muted">Go to your browser settings and enable notification for live.hackvalley2.com</span></div>
    </div>

    <script src="https://www.gstatic.com/firebasejs/4.9.1/firebase.js"></script>
    <script>
        // Initialize Firebase
        var config = {
            apiKey: "AIzaSyAhjuSeGpUjWXwHrm7TZnpQb03iTHxCzno",
            authDomain: "hack-the-valley-2-17d2d.firebaseapp.com",
            databaseURL: "https://hack-the-valley-2-17d2d.firebaseio.com",
            projectId: "hack-the-valley-2-17d2d",
            storageBucket: "hack-the-valley-2-17d2d.appspot.com",
            messagingSenderId: "242336252707"
        };
        firebase.initializeApp(config);
        const messaging = firebase.messaging();
        messaging.requestPermission()
            .then(function() {
                console.log('Notification permission granted.');
                loadMessagingToken();
            })
            .catch(function(err) {
                console.log('Unable to get permission to notify.', err);
            });

        /**
         * This will loop until a message token is registered with server
         */
        function loadMessagingToken(){
            messaging.getToken()
                .then(function(currentToken) {
                    if (currentToken) {
                        // Send current token to server
                        console.log(currentToken);
                        axios.post("api/fcm/subscribe", {
                            token: currentToken
                        }).then(function(){
                            console.log("Successfully subscribed");
                        }).catch(function(e){
                            console.log(e);
                            console.log("Failed to subscribe");
                            loadMessagingToken();
                        })
                    } else {
                        // Failed to get current token
                        console.log("failed");
                    }
                })
                .catch(function(err) {
                    console.log('An error occurred while retrieving token. ', err);
                });
        }


        /**
         * Handle token refresh
         */
        messaging.onTokenRefresh(function() {
            messaging.getToken()
                .then(function(refreshedToken) {
                    axios.post("api/fcm/subscribe", {
                        token: refreshedToken
                    }).then(function(){
                        console.log("Successfully subscribed");
                    }).catch(function(e){
                        console.log(e);
                        console.log("Failed to subscribe");
                        loadMessagingToken();
                    })
                })
                .catch(function(err) {
                    console.log('Unable to retrieve refreshed token ', err);
                });
        });

        /**
         * Handle message
         */
        messaging.onMessage(function(payload){
            console.log(payload.data.title);
            var notification = new Notification(payload.data.title, {
                body: payload.data.body,
                icon: 'https://live.hackvalley2.com/images/logo.png'
            });
        });

    </script>
    @yield('script')
    </body>
</html>