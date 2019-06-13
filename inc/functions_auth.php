<?php

// check to see if user is logged into website
function isAuthenticated()
{
    global $session;
    return $session->get('auth_logged_in',false);
}

// save auth info to a session
function saveUserData($user)
{
    global $session;
    $session->set('auth_logged_in',true);
    $session->set('auth_user_id',(int) $user['id']);
    $session->set('auth_roles',(int) $user['role_id']);
    $session->set('auth_username', $user['username']);

    $session->getFlashBag()->add('success', 'Successfully Logged In');
}

// restrict view to logged in users
function requireAuth() {
    if (!isAuthenticated()){
        global $session;
        $session->getFlashBag()->add('error','Not Authorized');
        redirect('/login.php');
    }
}

// retrieve logged in user name
function getAuthenticatedUser()
{
    global $session;
    return findUserByUsername($session->get('auth_username'));
}
