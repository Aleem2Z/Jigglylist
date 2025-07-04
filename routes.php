<?php

$router->get('/register', 'registration/create.php')->only('guest');
$router->post('/register', 'registration/store.php')->only('guest');

$router->get('/login', 'auth/login.php')->only('guest');
$router->post('/login', 'auth/login.store.php')->only('guest');
$router->delete('/logout', 'auth/logout.php')->only('auth');

$router->get('/anime', 'anime/index.php')->only('auth');
$router->post('/watchlist/add', 'watchlist/store.php')->only('auth');
$router->get('/watchlist', 'watchlist/index.php')->only('auth');
$router->post('/watchlist/remove', 'watchlist/remove.php')->only('auth');

$router->get('/anime/search', 'anime/search.php');
$router->post('/watchlist/update', 'watchlist/update.php');

$router->get('/', 'anime/index.php');

