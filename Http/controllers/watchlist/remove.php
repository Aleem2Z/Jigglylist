<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

// Get anime_id and user_id
$animeId = $_POST['anime_id'] ?? null;
$userId = $_SESSION['user']['id'];

// Validate
if (!$animeId) {
    \Core\Session::flash('message', 'Anime has not been removed from watchlist.');
    redirect('/watchlist');
}

// Delete from the list
$db->query('DELETE FROM list WHERE user_id = :user_id AND anime_id = :anime_id', [
    'user_id' => $userId,
    'anime_id' => $animeId
]);

\Core\Session::flash('message', 'Anime has been removed from watchlist.');

redirect('/watchlist');
