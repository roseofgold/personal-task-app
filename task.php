<?php
require_once 'inc/bootstrap.php';
requireAuth();

$pageTitle = "Task | Time Tracker";
$page = "task";
$user = getAuthenticatedUser();
$task_id = '';

if (request()->get('id')) {
    $task = getTask(request()->get('id'));
    $task_id = $task['task_id'];
}

include 'inc/header.php';
?>

<div class="section page">
    <div class="col-container page-container">
        <div class="col col-70-md col-60-lg col-center">
            <h1 class="actions-header"><?php
            if (!empty($task_id)) {
                echo "Update";
            } else {
                echo "Add";
            }
            ?> Task</h1>
            <?php
            if (isset($error_message)) {
                echo "<p class='message'>$error_message</p>";
            }
            ?>
            <form class="form-container form-add" method="post" action="inc/actions_tasks.php">
                <table>
                    <tr>
                        <th><label for="task">Task<span class="required">*</span></label></th>
                        <td><input type="text" id="task" name="task" value="<?php echo htmlspecialchars($task['task']); ?>" /></td>
                    </tr>
                   </table>
                <?php
                if (!empty($task_id)) {
                    echo "<input type='hidden' name='action' value='update' />";
                    echo "<input type='hidden' name='task_id' value='$task_id' />";
                    echo "<input type='hidden' name='status' value='" . $task['status'] . "' />";
                } else {
                    echo "<input type='hidden' name='status' value='0' />";
                    echo "<input type='hidden' name='action' value='add' />";
                    echo "<input type='hidden' name='user_id' value='" . $user['user_id'] . "' />";
                }
                ?>
                <input class="button button--primary button--topic-php" type="submit" value="Submit" />
            </form>
        </div>
    </div>
</div>

<?php include "inc/footer.php"; ?>
