<?php
function getAllEmployees($dashBoard=False): string {
    if ($dashBoard) {
        require_once "hw4/db-functions.php";
    } else {
        require_once "../db-functions.php";
    }
    $result = "";

    $conn = getConnection();
    $entryList = $conn->query("select * from employees")->fetchAll();
    foreach ($entryList as $entry) {
        $id = $entry["employee_id"];
        $name = $entry["name"];
        $surname = $entry["lastname"];
        $role = $entry["role_id"] ?? null;
        if ($role != null) {
            $role = $conn->query("select * from roles where role_id=$role")->fetch()["role_name"];
        }
        $tasks = $entry["number_tasks"];
        $result .= generateEmployeeEntry($id, $tasks, $name, $surname, $role, $dashBoard);
    }
    return $result;
}

function generateEmployeeEntry(int $id, int $tasks, string $name, string $surname, ?string $role, $dashBoard=False): string {

    if ($role == null) $role = "";
    $id = htmlspecialchars($id);
    $name = htmlspecialchars($name);
    $surname = htmlspecialchars($surname);
    $role = htmlspecialchars($role);
    $tasks = htmlspecialchars($tasks);
    if ($dashBoard) {
        if (strlen($name) > 9) $name = substr($name, 0, 7) . "...";
        if (strlen($surname) > 9) $surname = substr($surname, 0, 7) . "...";
        return "<div id=\"employee-entry\">
                <div><img src=\"hw4/img/img.png\" alt=\"pfp\"></div>
                <div>$name $surname</div>
                <div id='taskNumber'>$tasks</div>
                <div id=\"employee-task-count-$id\" hidden>$tasks</div>
                <div id='role'>$role</div>
            </div>\n";
    }
    return "<div id=\"employee-entry\" >
                <div><img src=\"../img/img.png\" alt=\"pfp\"></div>
                <div data-employee-id='$id'>$name $surname</div>
                <div id='taskNumber'>$tasks</div>
                <div id=\"employee-task-count-$id\" hidden>$tasks</div>
                <div id='role'>$role</div>
                <div id='editButton'>
                    <a id='employee-edit-link-$id' href=\"employee-edit.php?id=$id&oldFirstName=$name&oldLastName=$surname&role=$role&tasks=$tasks\">Edit</a>
                </div>
            </div>\n";
}

function getEmployeeAssignmentOptions(int $selectedId=0): string
{
    $result = "";
    $conn = getConnection();
    $entryList = $conn->query("select * from employees")->fetchAll();
    foreach ($entryList as $entry) {
        $id = htmlspecialchars($entry["employee_id"]);
        $name = htmlspecialchars($entry["name"]);
        $surname = htmlspecialchars($entry["lastname"]);
        if (intval($id) == $selectedId) {
            $result .= "<option selected value='$id'>$name $surname</option>\n";
        }
        else {
            $result .= "<option value='$id'>$name $surname</option>\n";
        }
    }
    return $result;
}