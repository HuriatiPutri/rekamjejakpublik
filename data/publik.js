
// Your web app's Firebase configuration
// import moment from './moment.js';
var firebaseConfig = {
    apiKey: "AIzaSyAPTveRXaamGZRhTpyUq9_JDh6M41Z-rxA",
    authDomain: "coronaapps-b9e75.firebaseapp.com",
    databaseURL: "https://coronaapps-b9e75.firebaseio.com",
    projectId: "coronaapps-b9e75",
    storageBucket: "coronaapps-b9e75.appspot.com",
    messagingSenderId: "258467893706",
    appId: "1:258467893706:web:2e1050258655ba7148ff33"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  var pengguna = document.getElementById("pengguna");
  var laporan = document.getElementById("laporan");
  var laporanvalid = document.getElementById("laporanvalid");
  var laporanbelumvalid = document.getElementById("laporanbelumvalid");
  var laporantidakvalid = document.getElementById("laporantidakvalid");
  
  var txtJumlahAyam = document.getElementById("jumlah_ayam");
  
  var idUser;
  // Firebase Variables
  var auth = firebase.auth();
  
  var db = firebase.database();
  
  arrbulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
  date = new Date();
  millisecond = date.getMilliseconds();
  detik = date.getSeconds();
  menit = date.getMinutes();
  jam = date.getHours();
  hari = date.getDay();
  tanggal = date.getDate();
  bulan = date.getMonth();
  tahun = date.getFullYear();
  document.getElementById("hariini").innerHTML = (tanggal + " " + arrbulan[bulan] + " " + tahun );


     
  
  
  
            firebase.database().ref('User/').once('value', (data) => {
              //console.log(data.toJSON());
              var jumlah_user = 0;
              data.forEach(function (snapshot) {
                var newPost = snapshot.val();
                if (newPost.role == "user") {
                  jumlah_user = jumlah_user + 1;
                }
              })
              pengguna.innerText = jumlah_user + " Orang";
              console.log('Jumlah User', jumlah_user);
            })
  
          firebase.database().ref('Lapor/').once('value', (data) => {
            //console.log(data.toJSON());
            var jumlah_lporan = 0, jumlahLaporanValid = 0, jumlahBelumValid = 0, jumlahTidakValid = 0;
            data.forEach(function (snapshot) {
              var newPost = snapshot.val().status;
              if (newPost == ("valid")) {
                jumlahLaporanValid = jumlahLaporanValid + 1;
              } else if (newPost == ("belum verifikasi")) {
                jumlahBelumValid = jumlahBelumValid + 1;
              } else if (newPost == ("tidak valid")) {
                jumlahTidakValid = jumlahTidakValid + 1;
              }
              jumlah_lporan = jumlah_lporan + 1;
            })
  
  
            laporan.innerText = jumlah_lporan;
            laporanvalid.innerText = jumlahLaporanValid;
            laporanbelumvalid.innerText = jumlahBelumValid;
            laporantidakvalid.innerText = jumlahTidakValid;
            console.log('Jumlah Laporan', jumlah_lporan);
          });
          var pdpUser=0, opdUser =0, positiveUser=0;
          firebase.database().ref('User/').once('value', (data) => {
            data.forEach(function (snapshot) {
              var newPost = snapshot.val();
              if(newPost.status == "PDP"){
                pdpUser++;
              }
              if(newPost.status == "ODP"){
                opdUser++;
              }
              if(newPost.status == "Positive"){
                positiveUser++;
              }
  
            })
          })
          firebase.database().ref('Provinsi/').once('value', (data) => {
            var odp = [], pdp = [], positive = [];
            var i = 0;
            data.forEach(function (snapshot) {
              var newPost = snapshot.val();
              odp[i] = newPost.odp;
              pdp[i] = newPost.pdp;
              positive[i] = newPost.positive;
              i++;
            })
  
  
            document.getElementById("odp").innerText = opdUser + " / " + odp[0] ;
            document.getElementById("pdp").innerText = pdpUser + " / " + pdp[0] ;
            document.getElementById("positive").innerText = positiveUser + " / " + positive[0];
            console.log('ODP', odp);
          });
  
          lastPosition()
          // map()
 

  
  
  
  // •••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••
  // signup form
  // •••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••
  var singoutButton = document.querySelector("#signout");
  var currentEmail = document.querySelector("#current-email");
  
  // singoutButton.addEventListener("click", clickSignoutButton);
  
  
  function clickSignupButton() {
  
    //signup firebase method
    auth.createUserWithEmailAndPassword(email.value, password.value).
      then(function (user) {
        console.log(auth.currentUser.email)
  
  
      }, function (error) {
        console.log(error.message);
        // error message show that you need to enable that authentication in firebase
      });
  
  }
  
  function clickSignoutButton() {
    auth.signOut()
  }
  
  
  function lastPosition() {
  
    const dbRef = firebase.database().ref();
    const ayamRef = dbRef.child('User/');
    ayamRef.on("value", snap => {
        snap.forEach(childSnap => {
            var idUser = childSnap.val().id
            var lat, lng;
            var i = 0;
            firebase.database().ref('Tracking/').once('value', (data) => {
                data.forEach(function (snapshot) {
                    if(snapshot.val().idUser == idUser){
                        lat = snapshot.val().Latitute
                        lng = snapshot.val().Longitute
                        i++
                    }
                });
                // console.log("idUser", idUser )
                // console.log("lastPosition", lat +  " " +lng)
                writeData(idUser, lat, lng)
            });
  
        });
    });
    
  }
  
  function writeData(userId, lat, lng) {
    firebase.database().ref('LastPosition/' + userId).set({
      userId: userId,
      Latitute: lat,
      Longitute : lng
    });
  }
  
  
  