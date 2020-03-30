<?php
header("Access-Control-Expose-Headers: Access-Control-Allow-Origin");
header("Access-Control-Allow-Origin: https://minangtech.com/home/getCoronaLast");
header('Access-Control-Allow-Methods: GET, POST');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard Polda Sumatera Barat by DWP Software</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">    <style>
        /*  <span class="metadata-marker" style="display: none;" data-region_tag="css"></span>       Set the size of the div element that contains the map */
        
        #map {
            height: 600px;
            /* The height is 400 pixels */
            width: 100%;
            /* The width is the width of the web page */
        }
    </style>
    <script>
        var map;
        var InforObj = [];
        var centerCords = {
            lat: -1.1734915,
            lng: 99.2321504
        };
        var markersOnMap = [{
                placeName: "Kabupaten Solok Selatan",
                LatLng: [{
                    lat: -1.5116526,
                    lng: 101.0594559,
                }], 
                Positif : 1
            }, {
                placeName: "Kabupaten Dharmasraya",
                LatLng: [{
                    lat: -0.9899518,
                    lng: 101.2549362
                }],
                Positif : 1
            }, {
                placeName: "Kabupaten Sijunjung",
                LatLng: [{
                    lat: -0.785573,
                    lng: 101.155994
                }],
                Positif : 1
            }, {
                placeName: "Kota Sawahlunto",
                LatLng: [{
                    lat: -0.610835,
                    lng: 100.799203
                }],
                Positif : 1
            }, {
                placeName: "Kota Solok",
                LatLng: [{
                    lat: -0.805956,
                    lng: 100.667098
                }],
                Positif : 1
            }, {
                placeName: "Kabupaten Solok",
                LatLng: [{
                    lat: -0.956871,
                    lng: 100.631550
                }],
                Positif : 1
            }, {
                placeName: "Kota Padang Panjang",
                LatLng: [{
                    lat: -0.482202,
                    lng: 100.401885
                }],
                Positif : 1
            }, {
                placeName: "Kota Padang",
                LatLng: [{
                    lat: -0.987530,
                    lng: 100.379898
                }],
                Positif : 1
            }, {
                placeName: "Kota Padang",
                LatLng: [{
                    lat: -0.987530,
                    lng: 100.379898
                }],
                Positif : 1
            }, {
                placeName: "Kota Pariaman",
                LatLng: [{
                    lat: -0.652482,
                    lng: 100.140786
                }],
                Positif : 1
            }, {
                placeName: "Kabupaten Pariaman",
                LatLng: [{
                    lat: -0.519505,
                    lng: 100.125401
                }],
                Positif : 1
            }, {
                placeName: "Kota Bukittinggi",
                LatLng: [{
                    lat: -0.313516,
                    lng: 100.386501
                }],
                Positif : 1
            }, {
                placeName: "Kota Payakumbuh",
                LatLng: [{
                    lat: -0.249938,
                    lng: 100.646394
                }],
                Positif : 1
            }, {
                placeName: "Kabupaten Agam",
                LatLng: [{
                    lat: -0.346067,
                    lng: 100.063730
                }],
                Positif : 1
            }, {
                placeName: "Kabupaten 50 Kota",
                LatLng: [{
                    lat: -0.148315,
                    lng: 100.605168
                }],
                Positif : 1
            }, {
                placeName: "Kabupaten Pasaman Barat",
                LatLng: [{
                    lat: 0.088352,
                    lng: 99.814934
                }],
                Positif : 1
            }, {
                placeName: "Kabupaten Pasaman",
                LatLng: [{
                    lat: 0.140537,
                    lng: 100.161234
                }],
                Positif : 1
            }, {
                placeName: "Kabupaten Kepulauan Mentawai",
                LatLng: [{
                    lat: -2.117026,
                    lng: 99.616897
                }],
                Positif : 1
            }



        ];

        window.onload = function() {
            initMap();
        };

        function addMarkerInfo() {
            for (var i = 0; i < markersOnMap.length; i++) {
                var contentString = '<div id="content"><h4>' + markersOnMap[i].placeName +
                    '</h4><table border=0><tr><td>Positive</td><td>:</td><td>'+markersOnMap[i].Positif+'</td></tr><tr><td>Meninggal</td><td>:</td><td>0</td></tr><td>Sembuh</td><td>:</td><td>0</td></tr></table></div>';

                const marker = new google.maps.Marker({
                    position: markersOnMap[i].LatLng[0],
                    map: map
                });

                const infowindow = new google.maps.InfoWindow({
                    content: contentString,
                    maxWidth: 200
                });

                marker.addListener('click', function() {
                    closeOtherInfo();
                    infowindow.open(marker.get('map'), marker);
                    InforObj[0] = infowindow;
                });
                // marker.addListener('mouseover', function () {
                //     closeOtherInfo();
                //     infowindow.open(marker.get('map'), marker);
                //     InforObj[0] = infowindow;
                // });
                // marker.addListener('mouseout', function () {
                //     closeOtherInfo();
                //     infowindow.close();
                //     InforObj[0] = infowindow;
                // });
            }
        }

        function closeOtherInfo() {
            if (InforObj.length > 0) {
                /* detach the info-window from the marker ... undocumented in the API docs */
                InforObj[0].set("marker", null);
                /* and close it */
                InforObj[0].close();
                /* blank the array */
                InforObj.length = 0;
            }
        }

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 8,
                center: centerCords
            });
            addMarkerInfo();
        }
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-white bg-white">
        <div style="margin: auto;"><img src="https://www.harianhaluan.com/assets/berita/original/66393318632-lambang_polda_sumbar.jpg" width="200"></div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-sm-2">
                <div class="row no-gutters">
                    <div class="col-lg-12">
                        <div class="price-table price-table-primary prominent wow zoomInDown animation-delay-2" style="visibility: visible; animation-name: zoomInDown;">
                            <header class="price-table-header">
                                <span class="price-table-category">TOTAL ODP</span>
                                <h3>
                                    <span id="odp"></span>
                                    <font size="4px"> Orang</font>
                                </h3>
                            </header>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="price-table price-table-royal prominent wow zoomInUp animation-delay-2" style="visibility: visible; animation-name: zoomInUp;">
                            <header class="price-table-header">
                                <span class="price-table-category">JUMLAH PDP</span>
                                <h3>
                                   <span id="odp2"></span>
                                    <font size="4px"> Orang</font>
                                </h3>
                            </header>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <br/>

                    </div>
                    <h3>Total Periksa</h3>
                    <div class="col-lg-12">
                        <div class="price-table price-table-royal prominent wow zoomInUp animation-delay-2" style="visibility: visible; animation-name: zoomInUp;">
                            <header class="price-table-header">
                                <span class="price-table-category">Hasil Negatif</span>
                                <h3>
                                   <span id="negatif"></span>
                                    <font size="4px"> Orang</font>
                                </h3>
                            </header>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="price-table price-table-royal prominent wow zoomInUp animation-delay-2" style="visibility: visible; animation-name: zoomInUp;">
                            <header class="price-table-header">
                                <span class="price-table-category">Hasil Positif</span>
                                <h3>
                                    <span id="positif"></span>
                                    <font size="4px"> Orang</font>
                                </h3>
                            </header>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="price-table price-table-royal prominent wow zoomInUp animation-delay-2" style="visibility: visible; animation-name: zoomInUp;">
                            <header class="price-table-header">
                                <span class="price-table-category">Menunggu Hasil</span>
                                <h3>
                                    <span id="menunggu"></span>
                                    <font size="4px"> Orang</font>
                                </h3>
                            </header>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="price-table price-table-royal prominent wow zoomInUp animation-delay-2" style="visibility: visible; animation-name: zoomInUp;">
                            <header class="price-table-header">
                                <span class="price-table-category">Meninggal</span>
                                <h3>
                                    <span id="meninggal"></span>
                                    <font size="4px"> Orang</font>
                                </h3>
                            </header>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <br/> Waktu Update
                        <br/> <span id="waktu"></span>

                    </div>

                </div>

            </div>
            <div class="col-sm-10">
                <div id="map"></div>
            </div>
        </div>
    </div>
    <br>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBp3Y3o69v6Dd6_fLdNvcMZh8KSrOBsqZY"></script>
</body>

</html>

<script src="https://www.gstatic.com/firebasejs/4.8.1/firebase.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
    function initialize() {
        var infowindow = new google.maps.InfoWindow();
        var map = new google.maps.Map(
            document.getElementById("map"), {
            center: new google.maps.LatLng(-0.9240576, 100.3464723),
            zoom: 13,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        //Initialize Firebase
        var config = {
            apiKey: "AIzaSyAPTveRXaamGZRhTpyUq9_JDh6M41Z-rxA",
            authDomain: "coronaapps-b9e75.firebaseapp.com",
            databaseURL: "https://coronaapps-b9e75.firebaseio.com",
            projectId: "coronaapps-b9e75",
            storageBucket: "coronaapps-b9e75.appspot.com",
            messagingSenderId: "258467893706",
            appId: "1:258467893706:web:2e1050258655ba7148ff33"
        };
        firebase.initializeApp(config);
        //Create a node at firebase location to add locations as child keys
        var locationsRef = firebase.database().ref("KotaData");
        var bounds = new google.maps.LatLngBounds();
        locationsRef.on('child_added', function (snapshot) {
            var key = snapshot.key;
            var data = snapshot.val();
            console.log(data);
            var marker = new google.maps.Marker({
                position: {
                    lat: parseFloat(data.lat),
                    lng: parseFloat(data.lng)
                },
                map: map,
                
            });
            bounds.extend(marker.getPosition());
            marker.addListener('click', (function (data) {
                return function (e) {
                    infowindow.setContent('<div id="content"><h4>' + key +
                    '</h4><table border=0><tr><td>Positive</td><td>:</td><td>'+data.Positif+'</td></tr><tr><td>Meninggal</td><td>:</td><td>'+data.Meninggal+'</td></tr><td>Sembuh</td><td>:</td><td>'+data.Sembuh+'</td></tr></table></div>');
                    infowindow.open(map, this);
                }
            }(data)));
            map.fitBounds(bounds);
        });
    }

    google.maps.event.addDomListener(window, "load", initialize);
</script>
<script>

    $(document).ready(function () {

        var request = new XMLHttpRequest()

        // Open a new connection, using the GET request on the URL endpoint
        request.open('GET', 'https://minangtech.com/home/getCoronaLast', true)

        request.onload = function () {
            var data = JSON.parse(this.response)

             // data.forEach(movie => {
                // Log each movie's title
                document.getElementById("odp").innerHTML = data.total_odp
                document.getElementById("odp2").innerHTML = data.pdp
                document.getElementById("negatif").innerHTML = data.negatif
                document.getElementById("positif").innerHTML = data.positif
                document.getElementById("menunggu").innerHTML = data.menunggu_hasil
                document.getElementById("meninggal").innerHTML = data.meninggal
                document.getElementById("waktu").innerHTML = data.waktu
                console.log(data.id)
             // })
        }

        // Send request
        request.send()

    });
</script>