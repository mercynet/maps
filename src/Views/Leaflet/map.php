<?php

use Maps\Leaflet\LeafletMap;
use Maps\Leaflet\LeafletConfig;

$map = new LeafletMap('map', LeafletConfig::getDefaultOptions());
?>

<div id="map" style="width: 100%; height: 400px;"></div>
<script>
    var map = L.map('map').setView(<?php echo json_encode($map->getCenter()); ?>, <?php echo $map->getZoom(); ?>);
    L.tileLayer('<?php echo $map->getTileLayer(); ?>', {
        maxZoom: <?php echo $map->getMaxZoom(); ?>,
    }).addTo(map);
</script>