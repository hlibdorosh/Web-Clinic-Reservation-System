<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->boot();

$reservations = \App\Models\Reservation::all();
echo "Total reservations: " . count($reservations) . "\n";
foreach ($reservations as $res) {
    echo "ID: {$res->id}, State: {$res->state}, Term ID: {$res->term_id}\n";
}
?>

