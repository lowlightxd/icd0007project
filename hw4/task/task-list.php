<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task list</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body id="task-list-page">
<div id="all">
<nav>
    <a href="../../index.php" id="dashboard-link">Dashboard</a> |
    <a href="../employee/employee-list.php" id="employee-list-link">Employees</a> |
    <a href="../employee/employee-form.php" id="employee-form-link">Add Employee</a> |
    <a href="task-list.php" id="task-list-link">Tasks</a> |
    <a href="task-form.php" id="task-form-link">Add Task</a>
</nav>

<?php
if (!empty($_POST["message-block"])) {
    $message = $_POST["message-block"];
    $id = 'error-block';
    if (str_starts_with($message, "Success!")) {
        $id = 'message-block';
    }
    print("
<div id=$id>
$message
</div>
");
}
?>

<main>
    <div id="task-data">
        <header>
            <b>Tasks</b>
        </header>
        <?php
        require_once "task-entry.php";
        print(getAllTasks())
        ?>
    </div>
</main>
</div>
</body>
</html>