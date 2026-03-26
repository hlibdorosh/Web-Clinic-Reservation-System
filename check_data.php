<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->boot();

$terms = \App\Models\Term::all();
echo "Total terms: " . count($terms) . "\n";

$reservations = \App\Models\Reservation::all();
echo "Total reservations: " . count($reservations) . "\n";

$users = \App\Models\User::all();
echo "Total users: " . count($users) . "\n";

// Get all users with their role
foreach ($users as $user) {
    echo "User: {$user->name} ({$user->email}) - Role: {$user->role}\n";
}

// Get all terms with their reservations
echo "\n\nTerms with reservations:\n";
foreach ($terms as $term) {
    echo "Term ID: {$term->id}, Date: {$term->date}, Start: {$term->start_time}, Reservations: " . count($term->reservations) . "\n";
    foreach ($term->reservations as $res) {
        echo "  - Reservation ID: {$res->id}, State: {$res->state}, Patient: {$res->patient_id}\n";
    }
}
?>

