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

    <main>
        <div id="formDiv">
            <header>
                <b>Add employee</b>
            </header>
            <form method="POST" action="employee-parse.php">
                <input type="hidden" name="id" id="id" value=<?php print($_GET["id"]);?>>
                <div>First name:</div>
                <div>
<?php
$oldFirstName = $_POST["firstName"] ?? $_GET["oldFirstName"] ?? null;
if ($oldFirstName != null){
    print("<input type=\"hidden\" name=\"oldFirstName\" id=\"oldFirstName\" value=\"$oldFirstName\">");
print("<textarea maxlength=\"35\" rows=\"1\" cols=\"35\" name=\"firstName\" id=\"firstName\">$oldFirstName</textarea>");
} else {
print("<textarea maxlength=\"35\" rows=\"1\" cols=\"35\" name=\"firstName\" id=\"firstName\"></textarea>");
}
?>
                </div>

                <div>Last name:</div>
                <div>
<?php
$oldLastName = $_POST["lastName"] ?? $_GET["oldLastName"] ?? null;
if ($oldFirstName != null){
    print("<input type=\"hidden\" name=\"oldLastName\" id=\"oldLastName\" value=\"$oldLastName\">");
print("<textarea maxlength=\"35\" rows=\"1\" cols=\"35\" name=\"lastName\" id=\"lastName\">$oldLastName</textarea>");
} else {
print("<textarea maxlength=\"35\" rows=\"1\" cols=\"35\" name=\"lastName\" id=\"lastName\"></textarea>");
}
?>
                </div>

                <div>Role:</div>
                <div>
<?php
$previousRole = $_GET["role"] ?? null;
$default = "selected";
$manager = "";
$developer = "";
$designer = "";
if ($previousRole != null) {
    $default = "";
    $manager = $previousRole == "Manager" ? "selected" : "";
    $developer = $previousRole == "Developer" ? "selected" : "";
    $designer = $previousRole == "Designer" ? "selected" : "";
}
print("<select name=\"role\" id=\"role\" size=\"1\">
            <option disabled $default value=\"\">Select Role</option>
            <option $manager value=\"Manager\">Manager</option>
            <option $designer value=\"Designer\">Designer</option>
            <option $developer value=\"Developer\">Developer</option>
        </select>");
?>
                </div>

                <div id="submit">
                    <button id="submitDelete" type="submit" name="deleteButton"
                            value="delete">Kustuta</button>
                    <button type="submit" name="submitButton"
                            value="edit">Salvesta</button>
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