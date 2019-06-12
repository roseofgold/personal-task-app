<?php
ini_set('display_errors','on');
require_once __DIR__ . '/../inc/bootstrap.php';
requireAuth();

// retrieve input current password, new password and confirmation password
$currentPassword = request()->get('current_password');
$newPassword = request()->get('password');
$confirmPassword = request()->get('confirm_password');

// check new password and confirmation password match
if ($newPassword != $confirmPassword)
{
    $session->getFlashBag()->add('error','New passwords do not match. Please try again.');
    redirect('/account.php');
}

// retrieve authenticated user information
$user = getAuthenticatedUser();

// if user isn't found there's a problem. Just go back to the account page.
if (empty($user))
{
    $session->getFlashBag()->add('error','Some Error Happened. Try again. If it continues, please log out and back in.');
    redirect('/account.php');
}

// check input current password matches password from db
if (!password_verify($currentPassword,$user['password']))
{
    $session->getFlashBag()->add('error','Current password was incorrect. Please try again.');
    redirect('/account.php');
}

// hash password
$hashed = password_hash($newPassword,PASSWORD_DEFAULT);

// try to update password. If fails to update, display error message
if (!updatePassword($hashed,$user['username']))
{
    $session->getFlashBag()->add('error','Could not update the password. Please try again.');
    redirect('/account.php');
}

// display password update success
$session->getFlashBag()->add('success','Password Updated');
redirect('/account.php');