<?php
require_once "../db-functions.php";
$name = $_POST["firstName"] ?? null;
$surname = $_POST["lastName"] ?? null;
$oldName = $_POST["oldFirstName"] ?? null;
$oldSurname = $_POST["oldLastName"] ?? null;
$command = $_POST["submitButton"] ?? $_POST["deleteButton"] ?? null;
$id = $_POST["id"] ?? null;
$role = $_POST["role"] ?? null;
if ($role != null) {
    $conn = getConnection();
    $role = $conn->query("select role_id from roles where role_name='$role'")->fetch()[0];
}


if ($command == null) {
    print("Something went wrong!");
    include "employee-list.php";
}

if ($command == "delete") {
    $message = deleteEmployee($id);
    $_POST["message-block"] = $message;
    include "employee-list.php";
    return;
}

if ($command == "add") {
    $message = addEmployee($name, $surname, $role);
    if (str_starts_with($message, "Failed!")) {
        $_POST["message-block"] = $message;
        include "employee-form.php";
        return;
    }
    $_POST["message-block"] = $message;
    include "employee-list.php";
}

if ($command == "edit") {
    $message = editEmployee($id ,$name, $surname, $oldName, $oldSurname, $role);
    if (str_starts_with($message, "Failed!")) {
        $_POST["message-block"] = $message;
        include "employee-form.php";
        return;
    }
    $_POST["message-block"] = $message;
    include "employee-list.php";
}

function addEmployee($name, $surname, $roleId=null): string
{
    $addRole = false;
    if ($roleId != null) {
        $addRole = true;
        $roleId = intval($roleId);
    }

    if (strlen($name) > 21 || strlen($name) < 1) {
        $_POST["firstName"] = $name;
        return "Failed! First name should be 1-21 characters";
    }
    if (strlen($surname) > 22 || strlen($surname) < 2) {
        $_POST["lastName"] = $surname;
        return "Failed! Last name should be 2-22 characters";
    }
    if ($name != null && $surname != null && trim($name) != "" && trim($surname) != "") {
        $connection = getConnection();
        if ($addRole) {
            $statement = $connection->prepare("insert into employees (name, lastname, role_id, number_tasks) values (:first, :last, :role_id, 0)");
            $statement->bindParam(":first", $name);
            $statement->bindParam(":last", $surname);
            $statement->bindParam(":role_id", $roleId);
        }
        else {
            $statement = $connection->prepare("insert into employees (name, lastname, number_tasks) values (:first, :last, 0)");
            $statement->bindParam(":first", $name);
            $statement->bindParam(":last", $surname);
        }
        $statement->execute();
    }
    return "Success!";
}

function editEmployee($id, $name, $surname, $oldName, $oldSurname, $role): string
{
    if (!($id != null && $name != null && $surname != null && $oldName != null && $oldSurname != null && $role != null)) {
        throw new RuntimeException("
        Null arguments.\n
        id: \"$id\"\n
        name: \"$name\"\n
        surname: \"$surname\"\n
        role: \"$role\"
        ");
    }

    if (strlen($name) > 21 || strlen($name) < 1) {
        $_POST["firstName"] = $name;
        return "Failed! First name should be 1-21 characters";
    }
    if (strlen($surname) > 22 || strlen($surname) < 2) {
        $_POST["lastName"] = $surname;
        return "Failed! Last name should be 2-22 characters";
    }

    $conn = getConnection();
    try {
        $statement = $conn->prepare("update employees set name=:first, lastname=:last, role_id=:role_id where employee_id=$id");
        $statement->bindParam(":first", $name);
        $statement->bindParam(":last", $surname);
        $statement->bindParam(":role_id", $role);
        $statement->execute();
    }
    catch (PDOException $e) {
        return "Failed to edit employee.";
    }
    return "Success!";
}

function deleteEmployee($id): string
{
    $message = "Failed! No employee found";
    if ($id == null) {
        throw new RuntimeException("
        Null argument id:\n $id
        ");
    }

    $conn = getConnection();
    try {
        $conn->prepare("delete from employees where employee_id = $id")->execute();
    }
    catch (PDOException $e) {
        return $message;
    }

    return "Success!";
}