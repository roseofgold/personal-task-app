<?php
require_once __DIR__.'/../inc/bootstrap.php';

// remove authorization session variables
$session->remove('auth_logged_in',true);
$session->remove('auth_user_id');
$session->remove('auth_roles');

$session->getFlashBag()->add('success', 'Successfully Logged Out');
redirect('/login.php');