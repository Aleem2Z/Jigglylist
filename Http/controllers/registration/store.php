<?php

use Core\App;
use Core\Database;
use Core\Validator;
use Core\Authenticator;
use Core\Session;

$db = App::resolve(Database::class);

$email = $_POST['email'];
$password = $_POST['password'];

$errors = [];
if (!Validator::email($email)) {
    $errors['email'] = 'Please provide a valid email address.';
}

if (!Validator::strval($password, 7, 255)) {
    $errors['password'] = 'Please provide a password of at least seven characters.';
}

$user = $db->query('select * from users where email = :email', [
    'email' => $email
])->find();

if ($user) {
    $errors['email'] = 'This email is already taken.';
}

if (! empty($errors)) {
    Session::flash('errors', $errors);
    Session::flash('old', ['email' => $email]);
    header('Location: /register');
    exit();
}

$db->query('INSERT INTO users(email, password) VALUES(:email, :password)', [
    'email' => $email,
    'password' => password_hash($password, PASSWORD_BCRYPT)
]);
$user_id = $db->lastInsertId();
(new Authenticator)->login([
    'email' => $email,
    'id' => $user_id
]);

header('location: /');
exit();
