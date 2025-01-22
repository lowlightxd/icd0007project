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

    <main>
        <div id="task-data">
            <header>
                <b>Add Task</b>
            </header>

            <div id="formDiv">
                <form method="POST" action="task-parse.php">
                    <input type="hidden" name="id" id="id" value=<?php print($_GET["id"]);?>>
                    <div class="form-group">
                        <label for="description">Description:</label>
<?php
$description = $_POST["name"] ?? $_GET["name"] ?? null;
if ($description != null) {
    print("<input type='hidden' id='oldDesc' name='oldDesc' value=\"$description\">");
    print("<textarea id=\"description\" name=\"description\" maxlength=\"50\" rows=\"2\" cols=\"35\">$description</textarea>");
}else {
    print("<textarea id=\"description\" name=\"description\" maxlength=\"50\" rows=\"2\" cols=\"35\"></textarea>");
}
?>
</div>

                    <div class="form-group">
                        <label>Estimate:</label>
<?php
$difficulty = $_POST["difficulty"] ?? $_GET["difficulty"] ?? null;
if ($difficulty != null) {
    $difficulty = intval($difficulty);
    $diff1 = 1 == $difficulty ? "checked" : "";
    $diff2 = 2 == $difficulty ? "checked" : "";
    $diff3 = 3 == $difficulty ? "checked" : "";
    $diff4 = 4 == $difficulty ? "checked" : "";
    $diff5 = 5 == $difficulty ? "checked" : "";
    print("<input type='hidden' id='oldEstimate' name='oldEstimate' value=$difficulty>
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
                        <?php
                        require_once "../employee/employee-entry.php";
                        require_once "../db-functions.php";
                        if ($_GET["employee_id"] != "") {
                            try {
                                $emp_id = intval($_GET["employee_id"]);
                                print("<option disabled value=\"\">Select employee</option>");
                                print(getEmployeeAssignmentOptions($emp_id));
                            } catch (Exception $e) {
                                print("<option selected disabled value=\"\">Select employee</option>");
                                print(getEmployeeAssignmentOptions());
                            }
                        } else {
                            print("<option selected disabled value=\"\">Select employee</option>");
                            print(getEmployeeAssignmentOptions());
                        }
                        ?>
                    </select>
                    <div>
                        <label for="isCompleted">Completed:</label>
                        Yes<input type="checkbox" id="isCompleted" name="isCompleted">
                    </div>

                    <div class="submit">
                        <button id="submitDelete" type="submit" name="deleteButton" value="delete">Delete</button>
                        <button type="submit" name="submitButton" id="submitButton" value="edit">Save</button>
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