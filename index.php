<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="hw4/index_style.css">
</head>
<body id="dashboard-page">
<div id="all">
    <nav>
        <a href="index.php" id="dashboard-link">Dashboard</a> |
        <a href="hw4/employee/employee-list.php" id="employee-list-link">Employees</a> |
        <a href="hw4/employee/employee-form.php" id="employee-form-link">Add Employee</a> |
        <a href="hw4/task/task-list.php" id="task-list-link">Tasks</a> |
        <a href="hw4/task/task-form.php" id="task-form-link">Add Task</a>
    </nav>

    <main>
        <div id="employee-data">
            <header>
                <b>Employees</b>
            </header>
            <?php
            require_once "hw4/employee/employee-entry.php";
            print(getAllEmployees(true))
            ?>
        </div>

        <div id="task-data">
            <header>
                <b>Tasks</b>
            </header>
            <?php
            require_once "hw4/task/task-entry.php";
            print(getAllTasks(true))
            ?>
        </div>
    </main>

<footer>
    icd0007 Sample Application
</footer>
</div>
</body>
</html>