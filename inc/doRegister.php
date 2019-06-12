<?php
require_once __DIR__.'/../inc/bootstrap.php';

// retrieve username, password and confirmation password from entered data
$username = request()->get('username');
$password = request()->get('password');
$confirmPassword = request()->get('confirm_password');

// check to see if password and confirmation password match
if ($password != $confirmPassword){
    $session->getFlashBag()->add('error','Passwords do NOT match');
    redirect('/register.php');
}

// check to see if username is already in use
$user = findUserByUsername($username);
if(!empty($user)){
    $session->getFlashBag()->add('error','User Already Exists');
    redirect('/register.php');
}

// hash password and save new user to db
$hashed = password_hash($password, PASSWORD_DEFAULT);
$user = createUser($username,$hashed);
saveUserSession($user);
$session->getFlashBag()->add('success','User Added');
redirect('/');