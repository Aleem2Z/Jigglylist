<?php

namespace Core\Middleware;

class Auth
{
    public function handle()
    {
        if (!($_SESSION['user'] ?? false)) {
            http_response_code(403);
            require base_path('views/403.php');
            exit();
        }
    }
}
