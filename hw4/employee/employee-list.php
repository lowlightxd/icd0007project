<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee list</title>
    <link rel="stylesheet" href="styles/employee-list.css">
</head>
<body id="employee-list-page">
<div id="all">
    <nav>
        <a href="../../index.php" id="dashboard-link">Dashboard</a> |
        <a href="employee-list.php" id="employee-list-link">Employees</a> |
        <a href="employee-form.php" id="employee-form-link">Add Employee</a> |
        <a href="../task/task-list.php" id="task-list-link">Tasks</a> |
        <a href="../task/task-form.php" id="task-form-link">Add Task</a>
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

    <div id="employee-data">
        <header>
            <b>Employees</b>
        </header>
        <?php
        require_once "employee-entry.php";
        print(getAllEmployees())
        ?>
    </div>

</main>

<footer>
    icd0007 Sample Application
</footer>
</div>
</body>
</html>