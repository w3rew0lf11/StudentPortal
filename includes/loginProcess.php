<?php
session_start();
include "database.php";

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $check_query = mysqli_prepare($connection, "SELECT id, firstname, lastname, email, password FROM auth WHERE email = ?");
    mysqli_stmt_bind_param($check_query, "s", $email);
    mysqli_stmt_execute($check_query);
    mysqli_stmt_store_result($check_query);

    if (mysqli_stmt_num_rows($check_query) === 1) {
        mysqli_stmt_bind_result($check_query, $id, $firstname, $lastname, $email, $hashed_password);
        mysqli_stmt_fetch($check_query);

        if (password_verify($password, $hashed_password)) {
            // Set session
            $_SESSION["user_id"] = $id;
            $_SESSION["firstname"] = $firstname;
            $_SESSION["lastname"] = $lastname;
            $_SESSION["email"] = $email;

            header("Location: ../dashboard.php");
            exit();
        } else {
            header("Location: ../login.php?message=Incorrect password");
            exit();
        }
    } else {
        header("Location: ../login.php?message=User doesn't exist");
        exit();
    }
}
?>
