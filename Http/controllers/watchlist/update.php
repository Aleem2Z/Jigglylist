<?php

use Core\App;
use Core\Database;
use Core\Session;

$db = App::resolve(Database::class);

// Only allow logged-in users
if (!isset($_SESSION['user'])) {
    header('Location: /login');
    exit();
}

$userId = $_SESSION['user']['id'];
$animeId = $_POST['anime_id'] ?? null;
$status = $_POST['status'] ?? 'Planned';
$score = $_POST['score'] ?? null;

if (!$animeId) {
    Session::flash('message', 'Invalid anime ID.');
    header('Location: /watchlist');
    exit();
}

// Ensure valid values
if (!in_array($status, ['Planned', 'Completed'])) {
    $status = 'Planned';
}

if ($status === 'Completed') {
    // Normalize score (optional)
    $score = ($score >= 1 && $score <= 10) ? (int) $score : null;
} else {
    $score = null; // Clear score if still planning
}

// Update DB
$db->query('
    UPDATE list
    SET status = :status, score = :score
    WHERE user_id = :user_id AND anime_id = :anime_id
', [
    'status' => $status,
    'score' => $score,
    'user_id' => $userId,
    'anime_id' => $animeId,
]);

Session::flash('message', 'Watchlist updated.');
header('Location: /watchlist');
exit();
