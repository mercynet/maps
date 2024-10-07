<!DOCTYPE html>
<html lang="en">
<head>
    <title>Google Map</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo isset($apiKey) ? $apiKey : ''; ?>"></script>
    <script>
        function initMap() {
            var mapOptions = {
                center: { lat: <?php echo isset($center[0]) ? $center[0] : 0; ?>, lng: <?php echo isset($center[1]) ? $center[1] : 0; ?> },
                zoom: <?php echo isset($zoom) ? $zoom : 8; ?>,
                maxZoom: <?php echo isset($maxZoom) ? $maxZoom : 18; ?>
            };
            var map = new google.maps.Map(document.getElementById('<?php echo isset($id) ? $id : 'map'; ?>'), mapOptions);
            var tileLayer = new google.maps.ImageMapType({
                getTileUrl: function(coord, zoom) {
                    return "<?php echo isset($tileLayer) ? $tileLayer : ''; ?>".replace('{z}', zoom).replace('{x}', coord.x).replace('{y}', coord.y);
                },
                tileSize: new google.maps.Size(256, 256),
                name: 'Tile Layer'
            });
            map.overlayMapTypes.insertAt(0, tileLayer);
        }
    </script>
</head>
<body onload="initMap()">
<div id="<?php echo isset($id) ? $id : 'map'; ?>" style="width: 100%; height: 500px;"></div>
</body>
</html>