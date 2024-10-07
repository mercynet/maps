<!DOCTYPE html>
<html lang="en">
<head>
    <title>Google Map</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY"></script>
    <script>
        function initMap() {
            const mapOptions = {
                center: { lat: <?php echo $center[0] ?? 0; ?>, lng: <?php echo $center[1] ?? 0; ?> },
                zoom: <?php echo $zoom ?? 8; ?>,
                mapTypeId: '<?php echo $mapType ?? 'roadmap'; ?>'
            };
            const map = new google.maps.Map(document.getElementById('<?php echo $id ?? 'map'; ?>'), mapOptions);

            // Adding custom markers
            const markers = <?php echo json_encode($markers ?? []); ?>;
            markers.forEach(marker => {
                const markerOptions = {
                    position: { lat: marker.coordinates[0], lng: marker.coordinates[1] },
                    map: map,
                    icon: marker.icon
                };
                const mapMarker = new google.maps.Marker(markerOptions);
                if (marker.popupText) {
                    const infoWindow = new google.maps.InfoWindow({
                        content: marker.popupText
                    });
                    mapMarker.addListener('click', () => {
                        infoWindow.open(map, mapMarker);
                    });
                }
            });

            // Adding overlays
            const overlays = <?php echo json_encode($overlays ?? []); ?>;
            overlays.forEach(overlay => {
                const overlayBounds = new google.maps.LatLngBounds(
                    new google.maps.LatLng(overlay.bounds[0][0], overlay.bounds[0][1]),
                    new google.maps.LatLng(overlay.bounds[1][0], overlay.bounds[1][1])
                );
                new google.maps.GroundOverlay(overlay.url, overlayBounds).setMap(map);
            });
        }
    </script>
</head>
<body onload="initMap()">
<div id="<?php echo $id ?? 'map'; ?>" style="width: 100%; height: 500px;"></div>
</body>
</html>