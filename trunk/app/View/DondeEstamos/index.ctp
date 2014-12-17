<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<style>
    #mapa{
        height: 500px;
        width: 100%;
        margin: 0px;
        padding: 0px;
    }
</style>
<script>
var map;
function CargaMapa() {
  var dir=new google.maps.LatLng(-33.4407444,-70.6504026);
  var mapOptions = {
    zoom: 17,
    center: dir,
    };
  map = new google.maps.Map(document.getElementById('mapa'),
      mapOptions);
    var marker = new google.maps.Marker({
        position: dir,
        map: map,
        title: 'Geek4y - Agustina 972 Oficina 1008'
    });
}
google.maps.event.addDomListener(window, 'load', CargaMapa);
</script>
<h3>¿Dónde Estamos?</h3>
<p>Estamos ubicados en Agustina 972 – Oficina 1008 – Santiago.</p>
<div id="mapa">
</div>