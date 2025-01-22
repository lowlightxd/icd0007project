<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Task</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body id="task-form-page">

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
                <b>Add Task</b>
            </header>

            <div id="formDiv">
                <form method="POST" action="task-parse.php">
                    <div class="form-group">
                        <label for="description">Description:</label>
<?php
$desc = $_POST["oldDesc"] ?? $_POST["name"] ?? null;
if ($desc != null) {
    echo "<textarea id=\"description\" name=\"description\" maxlength=\"50\" rows=\"2\" cols=\"35\">$desc</textarea>";
} else {
    echo "<textarea id=\"description\" name=\"description\" maxlength=\"50\" rows=\"2\" cols=\"35\"></textarea>";
}
?>
                    </div>

                    <div class="form-group">
<?php
$difficulty = $_POST["oldEstimate"] ?? $_POST["difficulty"] ?? null;
if ($difficulty != null) {
    $difficulty = intval($difficulty);
    $diff1 = 1 == $difficulty ? "checked" : "";
    $diff2 = 2 == $difficulty ? "checked" : "";
    $diff3 = 3 == $difficulty ? "checked" : "";
    $diff4 = 4 == $difficulty ? "checked" : "";
    $diff5 = 5 == $difficulty ? "checked" : "";
    print("
<div class=\"estimate-options\">
<label><input type=\"radio\" name=\"estimate\" value=\"1\" $diff1> 1</label>
<label><input type=\"radio\" name=\"estimate\" value=\"2\" $diff2> 2</label>
<label><input type=\"radio\" name=\"estimate\" value=\"3\" $diff3> 3</label>
<label><input type=\"radio\" name=\"estimate\" value=\"4\" $diff4> 4</label>
<label><input type=\"radio\" name=\"estimate\" value=\"5\" $diff5> 5</label>
</div>");
}else {
    print("<div class=\"estimate-options\">
<label><input type=\"radio\" name=\"estimate\" value=\"1\"> 1</label>
<label><input type=\"radio\" name=\"estimate\" value=\"2\"> 2</label>
<label><input type=\"radio\" name=\"estimate\" value=\"3\"> 3</label>
<label><input type=\"radio\" name=\"estimate\" value=\"4\"> 4</label>
<label><input type=\"radio\" name=\"estimate\" value=\"5\"> 5</label>
</div>");
}
?>
</div>

<div> Assigned to:</div>
<select id="employeeId" name="employeeId" size="1">
<option selected disabled value="">Select employee</option>
<?php
require_once "../employee/employee-entry.php";
require_once "../db-functions.php";
print(getEmployeeAssignmentOptions());
?>
</select>

                    <div class="submit">
                        <button type="submit" name="submitButton" id="submitButton" value="add">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <footer>
        icd0007 Sample Application
    </footer>
</div>

</body>
</html>