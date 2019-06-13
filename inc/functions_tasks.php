<?php
//task functions

// retrieve all tasks for specified user with optional completion status
function getTasks($user_id, $where = null)
{
    global $db;

    $query = "SELECT * FROM tasks";
    $query .= " WHERE user_id = $user_id";
    if (!empty($where)) $query .= " AND $where";
    $query .= " ORDER BY task_id";
    try {
        $statement = $db->prepare($query);
        $statement->execute();
        $tasks = $statement->fetchAll();
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        return false;
    }
    return $tasks;
}

// retrieve all incomplete tasks for specified user
function getIncompleteTasks($user_id)
{
    return getTasks($user_id,'status=0');
}

// retrieve all complete tasks for specified user
function getCompleteTasks($user_id)
{
    return getTasks($user_id,'status=1');
}

// display specific task
function getTask($task_id)
{
    global $db;

    try {
        $statement = $db->prepare('SELECT * FROM tasks WHERE task_id=:id');
        $statement->bindParam('id', $task_id);
        $statement->execute();
        $task = $statement->fetch();
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        return false;
    }
    return $task;
}

// create new task associated with signed in user
function createTask($data)
{
    global $db;

    try {
        $statement = $db->prepare('INSERT INTO tasks (task, status, user_id) VALUES (:task, :status, :user_id)');
        $statement->bindParam('task', $data['task']);
        $statement->bindParam('status', $data['status']);
        $statement->bindParam('user_id', $data['user_id']);
        $statement->execute();
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        return false;
    }
    return getTask($db->lastInsertId());
}

// update task with new information
function updateTask($data)
{
    global $db;

    try {
        getTask($data['task_id']);
        $statement = $db->prepare('UPDATE tasks SET task=:task, status=:status WHERE task_id=:id');
        $statement->bindParam('task', $data['task']);
        $statement->bindParam('status', $data['status']);
        $statement->bindParam('id', $data['task_id']);
        $statement->execute();
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        return false;
    }
    return getTask($data['task_id']);
}

// update task status (complete or incomplete)
function updateStatus($data)
{
    global $db;

    try {
        getTask($data['task_id']);
        $statement = $db->prepare('UPDATE tasks SET status=:status WHERE task_id=:id');
        $statement->bindParam('status', $data['status']);
        $statement->bindParam('id', $data['task_id']);
        $statement->execute();
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        return false;
    }
    return getTask($data['task_id']);
}

// remove task from list
function deleteTask($task_id)
{
    global $db;

    try {
        getTask($task_id);
        $statement = $db->prepare('DELETE FROM tasks WHERE task_id=:id');
        $statement->bindParam('id', $task_id);
        $statement->execute();
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        return false;
    }
    return true;
}
