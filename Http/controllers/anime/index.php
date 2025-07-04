<?php

$animes = [
    [
        'id' => 1,
        'title' => 'Attack on Titan',
        'cover' => 'https://upload.wikimedia.org/wikipedia/en/7/7e/Shingeki_no_Kyojin_manga_volume_1.jpg',
        'description' => 'Humans fight against titans in a post-apocalyptic world.',
    ],
    [
        'id' => 2,
        'title' => 'Death Note',
        'cover' => 'https://upload.wikimedia.org/wikipedia/en/6/6f/Death_Note_Vol_1.jpg',
        'description' => 'A high school student gains a notebook with the power to kill.',
    ],
    [
        'id' => 3,
        'title' => 'One Punch Man',
        'cover' => 'https://upload.wikimedia.org/wikipedia/en/f/f1/OnePunchMan_manga_cover.png',
        'description' => 'A hero defeats any enemy with a single punch.',
    ],
];

view('anime/index.view.php', ['animes' => $animes]);