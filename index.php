<?php

session_start();

require_once("vendor/autoload.php");

$employees = new Employees;

if (isset($_SESSION['emp_index'])) {
    $emp_index =    $_SESSION['emp_index'];
} else {
    return 0;
}
$emps_number = $employees->get_employees_number();

if (isset($_POST['next'])) {
    if (isset($_POST['next'])) {
        if ($emp_index >= $emps_number - 1) {
            $emp_index = $emps_number - 1;
        } else {
            $emp_index =  $emp_index + 1;
        }
    }}

if (isset($_POST['previous'])) {
  
    if ($emp_index <= 0) {
        return 0;
    } else {
        $emp_index =  $emp_index - 1;
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
    $emp_index = $emps_number - 1;
    $app_message = "Employee was successfully added.";
}
if (isset($_POST['update'])) {
    $employees->update_employee($emp_index, $name, $phone, $address, $email);
    $app_message = "Employee Info. was successfully updated.";
}
if (isset($_POST['delete'])) {
    $employees->delete_employee($emp_index);
    $emps_number--;
    $emp_index = $emp_index <= 0 ? 0 : $emp_index - 1;
    $app_message = "Employee was successfully deleted.";
}
if (isset($_POST['search'])) {
    $search_result = $employees->search_by_name($search_name);
    if ($search_result == -1) {
        $app_message = "This name doesn't match any Employee.";
    } else {
        $emp_index = $search_result;
        $app_message = "Employee was found!";
    }
}


$_SESSION['emp_index'] = $emp_index;


$employee = $employees->get_employee($emp_index);

require_once("views/index.html");
