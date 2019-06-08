<?php
function isAuthenticated()
{
    global $session;
    return $session->get('auth_logged_in',false);
}

function saveUserSession($user)
{
    global $session;
    $session->set('auth_logged_in',true);
    $session->set('auth_user_id',(int) $user['id']);
    $session->set('auth_roles',(int) $user['role_id']);
    $session->set('auth_username', $user['username']);

    $session->getFlashBag()->add('success', 'Successfully Logged In');
}

function requireAuth() {
    if (!isAuthenticated()){
        global $session;
        $session->getFlashBag()->add('error','Not Authorized');
        redirect('/login.php');
    }
}

function getAuthenticatedUser()
{
    global $session;
    return findUserByUsername($session->get('auth_username'));
}
