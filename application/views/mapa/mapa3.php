
<style>
  /* Always set the map height explicitly to define the size of the div
* element that contains the map. */
    #map {
        height: 100%;
        margin: 10px;
    }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
</style>
<script type="text/javascript">
    $(document).ready(function(valor){
        //tamaño
        window_size = $(window).height();
        $('#map').css('min-height', window_size * 0.8);
    });

    function marcadores(lat,lng){
        console.log(lat +"/"+lng);
    }

    function initMap() {

        //geolocalizacion
         if (navigator.geolocation) {
             position = navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            console.log ("La geolocalizacion no esta disponible en este dispositivo.");
        }

        var myLatLng = {lat: position.lat, lng: position.lng};

        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 4,
          center: myLatLng
        });

        var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          title: 'Hello World!'
        });



        function showPosition(position) {
            marcadores(position.coords.latitude,position.coords.longitude);
            array mark = {
                lat :position.coords.latitude,
                lng : position.coords.longitude
            };
            return
        }
    }

</script>
<body>
    <div class="container">
       <div class="row">
           <center>
            <div id="map" class="col s11 l10">

            </div>
            </center>
       </div>
    </div>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBmBDBqhuIcPwFmj6pWDCO4ylTCmWQab-M&callback=initMap">
</script>
</body>
