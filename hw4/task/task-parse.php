<?php
require_once "../db-functions.php";

$desc = $_POST["description"] ?? null;
$estimate = $_POST["estimate"] ?? null;
$oldDesc = $_POST["oldDesc"] ?? null;
$oldEstimate = $_POST["oldEstimate"] ?? null;
$command = $_POST["submitButton"] ?? $_POST["deleteButton"] ?? null;
$id = $_POST["id"] ?? null;
$employee_id = $_POST["employeeId"] ?? null;
$employee = null;
$isCompleted = $_POST["isCompleted"] ?? null;


if ($command == null) {
    print("Something went wrong!");
    return -1;
}

if ($command == "add") {
    $message = addTask($desc, $estimate, $employee_id, $employee);
    if (str_starts_with($message, "Failed!")) {
        $_POST["message-block"] = $message;
        include "task-form.php";
        return;
    }

    $_POST["message-block"] = $message;
    include "task-list.php";
} else if ($command == "edit") {
    $message = editTask($id, $desc, $estimate, $oldDesc, $oldEstimate, $employee_id, $isCompleted);
    if (str_starts_with($message, "Failed!")) {
        $_POST["message-block"] = $message;
        include "task-form.php";
        return;
    }

    $_POST["message-block"] = $message;
    include "task-list.php";
} else if ($command == "delete") {
    $message = deleteTask(intval($id));
    $_POST["message-block"] = $message;
    include "task-list.php";
}

function editTask($id, $desc, $estimate, $oldDesc, $oldEstimate, $employee_id, $isCompleted): string
{
    if (!($desc != null && $oldDesc != null)) {
        throw new RuntimeException("
        Null arguments.\n
        description: \"$desc\"\n
        oldDescription: \"$oldDesc\"\n
        ");
    }

    $desc = trim($desc);
    if ($estimate != null) $estimate = trim($estimate);
    if (strlen($desc) < 5 || strlen($desc) > 40) {
        $_POST["name"] = $desc;
        $_POST["difficulty"] = $estimate;
        return "Failed! Task description should be 5-40 characters";
    }

    $conn = getConnection();
    if ($isCompleted) {
        if ($employee_id != null) {
            $stmt = $conn->prepare("update employees set number_tasks=number_tasks + 1 where employee_id=:emp_id");
            $stmt->bindParam(":emp_id", $employee_id);
            $stmt->execute();
        }
        $conn->prepare("update tasks set completed=true where task_id=$id")->execute();
    }
    try {
        if ($estimate != null) {
            $stmt = $conn->prepare("update tasks set description=:desc, estimate=:est, employee_id=:emp_id where task_id=:task_id");
            $stmt->bindParam(":desc", $desc);
            $stmt->bindParam(":est", $estimate);
            $stmt->bindParam(":emp_id", $employee_id);
            $stmt->bindParam(":task_id", $id);
        }
        else {
            $stmt = $conn->prepare("update tasks set description=:desc, employee_id=:emp_id where task_id=:task_id");
            $stmt->bindParam(":desc", $desc);
            $stmt->bindParam(":emp_id", $employee_id);
            $stmt->bindParam(":task_id", $id);
        }
        $stmt->execute();
    }
    catch (PDOException $e) {
        return "Failed to edit employee.";
    }
    return "Success!";
}

function addTask($desc, $estimate, $employee_id, $employee): string
{
    if ($desc != null) {
        if (strlen($desc) < 5 || strlen($desc) > 40) {
            $_POST["name"] = $desc;
            $_POST["difficulty"] = $estimate;
            return "Failed! Task description should be 5-40 characters";
        }

        if (!is_numeric($estimate)) $estimate = null;
        if (!is_numeric($employee_id)) $employee_id = null;

        $connection = getConnection();
        if ($employee_id != null && $estimate != null) {
            $statement = $connection->prepare("insert into tasks (description, estimate, employee_id) values (:description, :estimate, :employee_id)");
            $statement->bindParam(':description', $desc);
            $statement->bindParam(':estimate', $estimate);
            $statement->bindParam(':employee_id', $employee_id);
        } else if ($employee_id == null && $estimate != null){
            $statement = $connection->prepare("insert into tasks (description, estimate) values (:description, :estimate)");
            $statement->bindParam(':description', $desc);
            $statement->bindParam(':estimate', $estimate);
        } else if ($employee_id == null && $estimate == null){
            $statement = $connection->prepare("insert into tasks (description) values (:description)");
            $statement->bindParam(':description', $desc);
        } else {
            $statement = $connection->prepare("insert into tasks (description, employee_id) values (:description, :employee_id)");
            $statement->bindParam(':description', $desc);
            $statement->bindParam(':employee_id', $employee_id);
        }
        $statement->execute();

        if ($employee_id != null) {
            $stmt = $connection->prepare("update employees set number_tasks=number_tasks + 1 where employee_id=:emp_id");
            $stmt->bindParam(":emp_id", $employee_id);
            $stmt->execute();
        }
        return "Success!";
    }
    $_POST["name"] = $desc;
    $_POST["difficulty"] = $estimate;
    $_POST["employeeId"] = $employee_id;
    return "Failed! Description and estimate have to be set";
}

function deleteTask($id): string
{
    $message = "Failed! No task found";

    $conn = getConnection();
    $conn->prepare("delete from tasks where task_id = $id")->execute();
    try {
        $conn->prepare("delete from tasks where task_id = $id")->execute();
    }
    catch (PDOException $e) {
        return $message;
    }

    return "Success!";
}
