<?php
require_once "bootstrap.php";

$action = request()->get('action');
$task_id = request()->get('task_id');
$task = request()->get('task');
$status = request()->get('status');
$owner_id = request()->get('owner_id');

$url="../task_list.php";
if (request()->get('filter')) {
    $url.="?filter=".request()->get('filter');
}

switch ($action) {
case "add":
    if (empty($task)) {
        $session->getFlashBag()->add('error', 'Please enter a task');
        redirect('/task.php');
    } else {
        if (createTask(['task'=>$task, 'status'=>$status, 'owner_id'=>$owner_id])) {
            $session->getFlashBag()->add('success', 'New Task Added for '. $owner_id);
        }
    }
    break;
case "update":
    $data = ['task_id'=>$task_id, 'task'=>$task, 'status'=>$status];
    if (updateTask($data)) {
        $session->getFlashBag()->add('success', 'Task Updated');
    } else {
        $session->getFlashBag()->add('error', 'Could NOT update task');
    }
    break;
case "status":
    if (updateStatus(['task_id'=>$task_id, 'status'=>$status])) {
        if ($status == 1) $session->getFlashBag()->add('success', 'Task Complete');
    }
    break;
case "delete":
    if (deleteTask($task_id)) {
        $session->getFlashBag()->add('success', 'Task Deleted');
    } else {
        $session->getFlashBag()->add('error', 'Could NOT Delete Task');
    }
    break;
}
header("Location: ".$url);