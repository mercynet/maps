<!DOCTYPE html>
<html lang="en">
<head>
    <title>Google Map</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $apiKey ?? ''; ?>"></script>
    <script>
        function initMap() {
            const mapOptions = {
                center: { lat: <?php echo $center[0] ?? 0; ?>, lng: <?php echo $center[1] ?? 0; ?> },
                zoom: <?php echo $zoom ?? 8; ?>,
                maxZoom: <?php echo $maxZoom ?? 18; ?>
            };
            const map = new google.maps.Map(document.getElementById('<?php echo $id ?? 'map'; ?>'), mapOptions);
            const tileLayer = new google.maps.ImageMapType({
                getTileUrl: function(coord, zoom) {
                    return "<?php echo $tileLayer ?? ''; ?>".replace('{z}', zoom).replace('{x}', coord.x).replace('{y}', coord.y);
                },
                tileSize: new google.maps.Size(256, 256),
                name: 'Tile Layer'
            });
            map.overlayMapTypes.insertAt(0, tileLayer);
        }
    </script>
</head>
<body onload="initMap()">
<div id="<?php echo $id ?? 'map'; ?>" style="width: 100%; height: 500px;"></div>
</body>
</html>