<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add employee</title>
    <link rel="stylesheet" href="styles/employee-list.css">
</head>
<body id="employee-form-page">
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
        <div id="formDiv">
            <header>
                <b>Add employee</b>
            </header>
            <form method="POST" action="employee-parse.php">
                <div>First name:</div>
                <div>
<?php
if (!empty($_POST["firstName"])) {
    $firstName = $_POST["firstName"];
    echo "<textarea maxlength=\"35\" rows=\"1\" cols=\"35\" name=\"firstName\" id=\"firstName\">$firstName</textarea>";
} else echo "<textarea maxlength=\"35\" rows=\"1\" cols=\"35\" name=\"firstName\" id=\"firstName\"></textarea>"
?>
                </div>

                <div>Last name:</div>
                <div>
<?php
if (!empty($_POST["lastName"])) {
    $lastName = $_POST["lastName"];
    echo "<textarea maxlength=\"35\" rows=\"1\" cols=\"35\" name=\"lastName\" id=\"lastName\">$lastName</textarea>";
} else echo "<textarea maxlength=\"35\" rows=\"1\" cols=\"35\" name=\"lastName\" id=\"lastName\"></textarea>"
?>

                </div>

                <div>Role:</div>
                <div>
                    <select name="role" id="role" size="1">
                        <option disabled selected value="">Select Role</option>
                        <option value="manager">Manager</option>
                        <option value="designer">Designer</option>
                        <option value="developer">Developer</option>
                    </select>
                </div>

                <div id="submit">
                    <button type="submit" name="submitButton"
                            value="add">Salvesta</button>
                </div>
            </form>
        </div>
    </main>

    <footer>
        icd0007 Sample Application
    </footer>
</div>

</body>
</html>