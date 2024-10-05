<?php
$id = $id ?? 'default-id';
$center = $center ?? [0.0, 0.0];
$zoom = $zoom ?? 1;
$maxZoom = $maxZoom ?? 18;
$tileLayer = $tileLayer ?? 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
?>

<div id="<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>" style="width: 100%; height: 400px;"></div>
<script>
    var map = L.map('<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>').setView([<?= implode(',', $center) ?>], <?= (int)$zoom ?>);
    L.tileLayer('<?= htmlspecialchars($tileLayer, ENT_QUOTES, 'UTF-8') ?>', { maxZoom: <?= (int)$maxZoom ?> }).addTo(map);
</script>