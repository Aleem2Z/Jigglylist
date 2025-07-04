<?php
namespace Core;
use Core\Database;
use Core\App;
use Core\Session;

class Authenticator{

    public function attempt($email, $password){
        $db = App::resolve(Database::class);
        $user = $db->query('select * from users where email = :email', [
            'email' => $email
        ])->find();
        $user_id = (int)$user['id'];
        
        if ($user) {
            if (password_verify($password, $user['password'])) {
                $this->login([
                    'email' => $email,
                    'id' => $user_id
                ]);
                return true;
            }
        }
        return false;
    }
    function login($user)
    {
        $_SESSION['user'] = [
            'email' => $user['email'],
            'id' => $user['id']
        ];
        session_regenerate_id(true);
    }


    function logout()
    {
        Session::destroy();
    }

}
