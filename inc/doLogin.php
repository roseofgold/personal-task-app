<?php
require_once __DIR__.'/../inc/bootstrap.php';

// check to see is input username exists in db
$user = findUserByUsername(request()->get('username'));

// if user was not found prompt for login
if (empty($user))
{
    $session->getFlashBag()->add('error','Username was not found');
    redirect('/login.php');
}

// if input password doesn't match password from db prompt for login
if (!password_verify(request()->get('password'),$user['password']))
{
    $session->getFlashBag()->add('error','Invalid password');
    redirect('/login.php');
}

// save user auth to session
saveUserSession($user);
redirect('/');