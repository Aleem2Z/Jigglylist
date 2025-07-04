<?php

use Core\Api\Anilist;

// Get the search term from the query parameter
$searchTerm = $_GET['search'] ?? '';

// If no search term, set an empty list
$animes = [];

if ($searchTerm) {
    $animes = Anilist::search($searchTerm);
}

// Pass to view
view('anime/search.view.php', [
    'animes' => $animes,
    'searchTerm' => htmlspecialchars($searchTerm)
]);
