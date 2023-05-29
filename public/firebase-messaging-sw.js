importScripts('https://www.gstatic.com/firebasejs/4.9.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/4.9.1/firebase-messaging.js');
/*Update this config*/
var config = {
    apiKey: "AIzaSyDKT-284MNHjcq-zpPXRmVqsu95sta-XNc",
  authDomain: "brandnew-88a31.firebaseapp.com",
  projectId: "brandnew-88a31",
  storageBucket: "brandnew-88a31.appspot.com",
  messagingSenderId: "465220099540",
  appId: "1:465220099540:web:d4c4ba77a2d193e98f8a41",
  measurementId: "G-GLQ19B0CK7"
  };
  firebase.initializeApp(config);

const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);
  // Customize notification here
  const notificationTitle = 'HEY NOW New';
  const notificationOptions = {
    body: payload.data.body,
  icon: 'https://image.flaticon.com/icons/png/512/270/270014.png',
  image: 'https://image.flaticon.com/icons/png/512/270/270014.png'
  };

  return self.registration.showNotification(notificationTitle,
      notificationOptions);
});
// [END background_handler]