<?php

function getAllTasks($dashBoard=False): string {
    if ($dashBoard) {
        require_once "hw4/db-functions.php";
    } else {
        require_once "../db-functions.php";
    }
    $result = "";

    $conn = getConnection();
    $taskList = $conn->query("select * from tasks")->fetchAll();
    foreach ($taskList as $task) {
        $id = $task["task_id"];
        $name = $task["description"];
        $estimate = $task["estimate"] ?? null;
        $employee_id = $task["employee_id"] ?? null;
        $completed = boolval($task["completed"] ?? null);
        $result .= generateTaskEntry($id, $name, $estimate, $completed, intval($employee_id), $dashBoard);
    }
    return $result;
}

function generateTaskEntry(int $id, string $name, ?string $estimate, bool $compStatus, ?int $employee_id, $dashBoard=False): string
{
    if ($employee_id == null) $employee_id = "";
    if ($estimate == null) $estimate = 0;
    $id = htmlspecialchars($id);
    $name = htmlspecialchars($name);
    $additionalContent = "";
    if ($dashBoard && strlen($name) > 20) {
        $name = substr($name, 0, 20) . "...";
    }
    if (!$dashBoard) {
        $additionalContent = "<div id='editButton'>
                                <a id='task-edit-link-$id' href=\"task-edit.php?id=$id&name=$name&difficulty=$estimate&compStatus=$compStatus&employee_id=$employee_id\">Edit</a>
                            </div>";
    }
    $status = $compStatus ? "Closed" : ($employee_id != null ? "Pending" : "Open");
    $additionalContent .= "<div id=\"task-state-$id\">$status</div>";
    $difficulty = "";
    $difficulty = str_repeat("&#9635;", intval($estimate));
    $difficulty .= str_repeat("&#9634;", 5 - intval($estimate));

    return "<div id=\"task-entry\">
                <div data-task-id='$id'>$name</div>
                <div>$additionalContent</div>
                <div id='difficulty'>$difficulty</div>
            </div>";
}