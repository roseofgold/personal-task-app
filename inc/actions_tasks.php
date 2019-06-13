<?php
require_once "bootstrap.php";

$action = request()->get('action');
$task_id = request()->get('task_id');
$task = request()->get('task');
$status = request()->get('status');
$user_id = request()->get('user_id');

$url="../task_list.php";
if (request()->get('filter')) {
    $url.="?filter=".request()->get('filter');
}

switch ($action) {
    // Add a task to a specific user
    case "add":
        // Check to see is task has been entered.
        if (empty($task)) {
            $session->getFlashBag()->add('error', 'Please enter a task');
            redirect('/task.php');
        } else {
            // Create task in database. If errors, state so.
            if (createTask(['task'=>$task, 'status'=>$status, 'user_id'=>$user_id])) {
                $session->getFlashBag()->add('success', 'New Task Added for '. $user_id);
            } else {
                $session->getFlashBag()->add('error', 'Task Not Added');
            }
        }
        break;

    // Update a task
    case "update":
        $data = ['task_id'=>$task_id, 'task'=>$task, 'status'=>$status];
        if (updateTask($data)) {
            $session->getFlashBag()->add('success', 'Task Updated');
        } else {
            $session->getFlashBag()->add('error', 'Could NOT Update Task');
        }
        break;
    
    // Change status of task
    case "status":
        if (updateStatus(['task_id'=>$task_id, 'status'=>$status])) {
            if ($status == 1) $session->getFlashBag()->add('success', 'Task Complete');
        }
        break;
    
    // Remove task from list
    case "delete":
        if (deleteTask($task_id)) {
            $session->getFlashBag()->add('success', 'Task Deleted');
        } else {
            $session->getFlashBag()->add('error', 'Could NOT Delete Task');
        }
        break;
}
header("Location: ".$url);