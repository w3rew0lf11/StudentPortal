<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'database.php';

if (isset($_POST["register"])) {
    echo "you are here";

    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if ($password != $confirm_password) {
        header("Location: ../login.php?message=Both passwords must be same");

    } else {

        $check_query = mysqli_prepare($connection, "SELECT id FROM auth WHERE email = ?");
        mysqli_stmt_bind_param($check_query, "s", $email);
        mysqli_stmt_execute($check_query);
        mysqli_stmt_store_result($check_query);

        if (mysqli_stmt_num_rows($check_query) > 0) {
            header("Location: ../login.php?message=email already taken");
            exit();
        } else {

            $hashed_password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

            $query = mysqli_prepare($connection, "INSERT INTO auth (firstname, lastname, email, password) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($query, "ssss", $firstname, $lastname, $email, $hashed_password);


            if (!mysqli_stmt_execute($query)) {
                die("Querry failed" . mysqli_error($connection));
            } else {
                header("Location: ../login.php?success=Registration successful");
                exit();
            }
        }


    }

}
?>