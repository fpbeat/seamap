<!doctype html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="{abspath path="js/app.js"}?{microtime(true)}"></script>
    <link href="{abspath path="css/app.css"}" rel="stylesheet">

    <title>Sea Map</title>
</head>
<body>
<div class="map-container"></div>
<script>
    new leafTracker('.map-container', {
        dataUrl: '{abspath path="data"}',
        initial: {
            data: {$data|json_encode},
            hashes: {$hashes|json_encode}
        },

        map: {
            center: [60.23729700, 31.60128600],
            zoom: 10,
        },

        point: {
            dateFormat: 'DD.MM.YYYY HH:mm',
            icon: null
        },

        polyline: {
            color: 'red',
            weight: 3
        },

        updateInterval: 5,
        centering: 'bounds' // lastpoint
    });
</script>
</body>
