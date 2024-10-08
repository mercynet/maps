<?php

$centerPoint = $centerPoint ?? [38.7167, -9.1333];
$zoomLevel = $zoomLevel ?? 5;
$maxZoomLevel = $maxZoomLevel ?? 18;
$markers = $markers ?? [];
$markerArray = $markerArray ?? [];
$tileHost = $tileHost ?? 'openstreetmap';
$mapId = $mapId ?? 'map';
$attribution = $attribution ?? 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap contributors, Imagery © Mapbox.com';
$leafletVersion = $leafletVersion ?? '1.9.4';
$class = $class ?? '';
$style = $style ?? 'width: 100%; height: 500px;';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Leaflet Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@<?= $leafletVersion; ?>/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@<?= $leafletVersion; ?>/dist/leaflet.js"></script>
    <style>
        .leaflet-overlay-pane {
            z-index: 5 !important;
        }

        .leaflet-shadow-pane {
            z-index: 4 !important;
        }

        .leaflet-div-icon {
            background-color: #f4f4f4;
            border: 1px solid #666;
            border-radius: 50%;
            display: inline-block;
        }

        .leaflet-editing-icon {
            background-color: #f4f4f4;
            border: 1px solid #666;
            border-radius: 50%;
            display: inline-block;
        }

        .my-own-icon {
            width: 300px;
            height: 300px;
            background-color: #f4f4f4;
        }

        #<?= $mapId ?> {
        <?=!isset($style) ? 'height: 100vh' : $style; ?>
        }
    </style>
    <script>
        function initMap() {
            const mymap = L.map('<?= $mapId ?>').setView([<?= $centerPoint['lat'] ?? 38.7440722 ?>, <?= $centerPoint['long'] ?? -9.2009352 ?>], <?= $zoomLevel ?>);
            let latLongs = [], marker = null, icon = null, points = L.layerGroup(), polyLines = L.layerGroup();
            <?php foreach ($markers as $marker): ?>
            <?php if (isset($marker['icon'])): ?>
            icon = L.icon({
                iconUrl: '<?= $marker['icon'] ?>',
                iconSize: [<?= $marker['iconSizeX'] ?? 32 ?>, <?= $marker['iconSizeY'] ?? 32 ?>],
            });
            <?php endif; ?>
            marker = L.marker([<?= $marker['lat'] ?? $marker[0] ?>, <?= $marker['long'] ?? $marker[1] ?>] <?php if (isset($marker['icon'])): ?>, {icon: icon}<?php endif; ?>);
            marker.addTo(points);
            <?php if (isset($marker['info'])): ?>
            marker.bindPopup('<?= json_encode($marker['info']) ?>');
            <?php endif; ?>
            latLongs.push([<?= $marker['lat'] ?? $marker[0] ?>, <?= $marker['long'] ?? $marker[1] ?>]);
            <?php endforeach; ?>
            const polyline = L.polyline(latLongs, {color: '#000', opacity: 0.4, weight: 10}).addTo(polyLines);
            points.addTo(mymap);
            polyLines.addTo(mymap);

            <?php if ($tileHost === 'mapbox'): ?>
            let url<?= $mapId ?> = 'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=ACCESS_TOKEN';
            <?php elseif ($tileHost === 'openstreetmap'): ?>
            let url<?= $mapId ?> = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
            <?php else: ?>
            let url<?= $mapId ?> = '<?= $tileHost ?>';
            <?php endif; ?>
            L.tileLayer(url<?= $mapId ?>, {
                maxZoom: <?= $maxZoomLevel ?>,
                attribution: '<?= $attribution ?>',
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1
            }).addTo(mymap);
            <?php if (!empty($markers)): ?>
            mymap.fitBounds(polyline.getBounds());
            <?php endif; ?>
        }
    </script>
</head>
<body onload="initMap()">
<div id="<?= $mapId ?>"<?= !empty($class) ? " class=\"$class\"" : '' ?> style="<?= $style ?>"></div>
</body>
</html>