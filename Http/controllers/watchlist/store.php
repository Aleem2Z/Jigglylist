<?php

use Core\App;
use Core\Database;
use Core\Session;

$db = App::resolve(Database::class);

// Ensure user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: /login');
    exit();
}

$userId = $_SESSION['user']['id'];
$animeId = $_POST['anime_id'] ?? null;

if (!$animeId) {
    Session::flash('message', 'Anime ID is required.');
    $redirect = isset($_POST['search_term']) && $_POST['search_term'] !== '' ? '/anime/search?search=' . urlencode($_POST['search_term']) : '/watchlist';
    header('Location: ' . $redirect);
    exit();
}

// Check if already exists
$exists = $db->query(
    'SELECT * FROM list WHERE user_id = :user_id AND anime_id = :anime_id',
    ['user_id' => $userId, 'anime_id' => $animeId]
)->find();

if ($exists) {
    Session::flash('message', 'Anime already in your watchlist.');
    $redirect = isset($_POST['search_term']) && $_POST['search_term'] !== '' ? '/anime/search?search=' . urlencode($_POST['search_term']) : '/watchlist';
    header('Location: ' . $redirect);
    exit();
}

// Insert into list with status = 'planning' and score = NULL
$db->query(
    'INSERT INTO list (user_id, anime_id, status, score) VALUES (:user_id, :anime_id, :status, :score)',
    [
        'user_id' => $userId,
        'anime_id' => $animeId,
        'status' => 'Planned',
        'score' => null
    ]
);

Session::flash('message', 'Anime added to your watchlist.');
$redirect = isset($_POST['search_term']) && $_POST['search_term'] !== '' ? '/anime/search?search=' . urlencode($_POST['search_term']) : '/watchlist';
header('Location: ' . $redirect);
exit();
