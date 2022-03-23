<?php

session_start();

require_once("vendor/autoload.php");

$employees = new Employees;

if (isset($_SESSION['employee_index'])) {
    $employee_index = $_SESSION['employee_index'];
} else {
    $employee_index = 0;
}

$emps_number = $employees->get_employees_number();

if (isset($_POST['next'])) {
    if ($employee_index >= $emps_number - 1) {
        $employee_index = $emps_number - 1;
    } else {
        $employee_index =  $employee_index + 1;
    }
}

if (isset($_POST['previous'])) {
    if ($employee_index <= 0) {
        $employee_index = 0;
    } else {
        $employee_index =  $employee_index - 1;
    }
}



if (isset($_POST['name'])) {
    $name = $_POST['name'];
} else {
    $name = "";
}
if (isset($_POST['phone'])) {
    $phone = $_POST['phone'];
} else {
    $phone = "";
}
if (isset($_POST['address'])) {
    $address = $_POST['address'];
} else {
    $address = "";
}
if (isset($_POST['email'])) {
    $email = $_POST['email'];
} else {
    $email = "";
}

if (isset($_POST['search_name'])) {
    $search_name = $_POST['search_name'];
} else {
    $search_name = "";
}

$app_message = "";


if (isset($_POST['insert'])) {
    $employees->insert_employee($name, $phone, $address, $email);
    $emps_number++;
    $employee_index = $emps_number - 1;
    $app_message = "successfully added.";
}

if (isset($_POST['update'])) {
    $employees->update_employee($employee_index, $name, $phone, $address, $email);
    $app_message = "successfully updated.";
}

if (isset($_POST['delete'])) {
    $employees->delete_employee($employee_index);
    $emps_number--;
    $employee_index = $employee_index <= 0 ? 0 : $employee_index - 1;
    $app_message = "successfully deleted.";
}

if (isset($_POST['search'])) {
    $search_result = $employees->searchByName($search_name);
    if ($search_result == -1) {
        $app_message = "name doesn't match any Employee.";
    } else {
        $employee_index = $search_result;
        $app_message = "found!";
    }
}


$_SESSION['employee_index'] = $employee_index;

$employee = $employees->get_employee($employee_index);

require_once("views/index.html");
