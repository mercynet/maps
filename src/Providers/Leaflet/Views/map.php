<?php
$centerPoint = $centerPoint ?? [38.7167, -9.1333];
$zoomLevel = $zoomLevel ?? 5;
$maxZoomLevel = $maxZoomLevel ?? 18;
$markers = $markers ?? [];
$markerArray = $markerArray ?? [];
$tileHost = $tileHost ?? 'openstreetmap';
$mapId = $mapId ?? 'map';
$attribution = $attribution ?? 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap contributors, Imagery © Mapbox.com';
$leafletVersion = $leafletVersion ?? '1.7.1';
$class = $class ?? '';
$style = $style ?? 'width: 100%; height: 500px;';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Leaflet Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@<?php echo $leafletVersion; ?>/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@<?php echo $leafletVersion; ?>/dist/leaflet.js"></script>
    <script>
        function initMap() {
            const mapOptions = {
                center: [<?php echo $centerPoint[0]; ?>, <?php echo $centerPoint[1]; ?>],
                zoom: <?php echo $zoomLevel; ?>
            };
            const map = L.map('<?php echo $mapId; ?>').setView(mapOptions.center, mapOptions.zoom);

            L.tileLayer('<?php echo $tileHost; ?>', {
                maxZoom: <?php echo $maxZoomLevel; ?>,
                attribution: '<?php echo $attribution; ?>'
            }).addTo(map);

            const markers = <?php echo json_encode($markers); ?>;
            markers.forEach(marker => {
                const icon = L.icon({
                    iconUrl: marker.icon,
                    iconSize: [marker.iconSizeX, marker.iconSizeY]
                });
                L.marker([marker.lat, marker.long], { icon: icon })
                    .addTo(map)
                    .bindPopup(marker.info);
            });

            const overlays = <?php echo json_encode($markerArray); ?>;
            overlays.forEach(overlay => {
                L.imageOverlay(overlay.url, overlay.bounds).addTo(map);
            });
        }
    </script>
</head>
<body onload="initMap()">
<div id="<?php echo $mapId; ?>"<?php echo !empty($class) ? " class=\"$class;\"" : ''?> style="<?php echo $style; ?>"></div>
</body>
</html>