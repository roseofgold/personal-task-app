<?php
/*
 * Functions to interface with `user` table
 */

 // retrieve all users
function getAllUsers()
{
    global $db;

    try {
        $query = "SELECT * FROM users";
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (\Exception $e) {
        throw $e;
    }
}

// retrieve user information based on username
function findUserByUsername($username)
{
    global $db;

    try {
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch();

    } catch (\Exception $e) {
        throw $e;
    }
}

// retrieve user infomation based on user ID
function findUserById($userId)
{
    global $db;

    try {
        $query = "SELECT * FROM users WHERE user_id = :userId";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        return $stmt->fetch();

    } catch (\Exception $e) {
        throw $e;
    }
}

// create a new user. Role auto set to '2' General User
function createUser($username, $password)
{
    global $db;

    try {
        $query = "INSERT INTO users (username, password, role_id, created_at) VALUES (:username, :password, 2, datetime())";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        return findUserByUsername($username);
    } catch (\Exception $e) {
        throw $e;
    }
}

// Update user password
function updatePassword($password, $userId)
{
    global $db;

    try {
        $query = 'UPDATE users SET password = :password WHERE username = :userId';
        $stmt = $db->prepare($query);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
          return true;
        } else {
          return false;
        }
    } catch (\Exception $e) {
        throw $e;
    }

    return true;
}

// Change role of user
function changeRole($userId, $roleId)
{
    global $db;

    try {
        $query = "UPDATE users SET role_id = :roleId WHERE user_id = :userId";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':roleId', $roleId);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        return findUserById($userId);
    } catch (\Exception $e) {
        throw $e;
    }
}