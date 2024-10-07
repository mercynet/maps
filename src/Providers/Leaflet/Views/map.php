<!DOCTYPE html>
<html lang="en">
<head>
    <title>Leaflet Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        function initMap() {
            const mapOptions = {
                center: ['<?php echo $center[0] ?? 0; ?>', '<?php echo $center[1] ?? 0; ?>'],
                zoom: <?php echo $zoom ?? 8; ?>
            };
            const map = L.map('<?php echo $id ?? 'map'; ?>').setView(mapOptions.center, mapOptions.zoom);

            L.tileLayer('<?php echo $tileLayer ?? ''; ?>', {
                maxZoom: <?php echo $maxZoom ?? 18; ?>
            }).addTo(map);

            // Adding custom markers
            const markers = <?php echo json_encode($markers ?? []); ?>;
            markers.forEach(marker => {
                L.marker(marker.coordinates, { icon: L.icon(marker.icon) }).addTo(map).bindPopup(marker.popupText);
            });

            // Adding overlays
            const overlays = <?php echo json_encode($overlays ?? []); ?>;
            overlays.forEach(overlay => {
                L.imageOverlay(overlay.url, overlay.bounds).addTo(map);
            });
        }
    </script>
</head>
<body onload="initMap()">
<div id="<?php echo $id ?? 'map'; ?>" style="width: 100%; height: 500px;"></div>
</body>
</html>