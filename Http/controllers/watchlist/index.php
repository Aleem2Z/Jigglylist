<?php

use Core\App;
use Core\Database;
use Core\Api\Anilist;

$db = App::resolve(Database::class);
$userId = $_SESSION['user']['id'];

// Step 1: Get DB entries (anime_id, status, score)
$watchlist = $db->query('SELECT anime_id, status, score FROM list WHERE user_id = :user_id', [
    'user_id' => $userId
])->get();

// Step 2: Extract anime IDs from DB results
$animeIds = array_column($watchlist, 'anime_id');

// Step 3: Fetch AniList data
$animeData = Anilist::fetchAnimeByIds($animeIds);

// Step 4: Map AniList data by ID
$animeDataById = [];
foreach ($animeData as $anime) {
    $animeDataById[$anime['id']] = $anime;
}

// Step 5: Merge AniList and DB (user) data
$animeList = array_filter(array_map(function ($row) use ($animeDataById) {
    $anime = $animeDataById[$row['anime_id']] ?? null;
    if (!$anime) return null;

    // Add user-specific fields
    $anime['user_status'] = $row['status'];
    $anime['user_score'] = $row['score'];

    return $anime;
}, $watchlist));

// Step 6: Pass to view
view('watchlist/index.view.php', [
    'animes' => $animeList
]);
