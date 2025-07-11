<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include "database.php"; 

if (isset($_POST['saveProfile'])) {
    $user_id = $_SESSION['user_id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'] ?? null;
    $program = $_POST['program'] ?? null;
    $bio = $_POST['bio'] ?? null;

    // Update auth table
    $auth_update = mysqli_prepare($connection, "UPDATE auth SET firstname = ?, lastname = ?, email = ? WHERE id = ?");
    if (!$auth_update) {
        die("Prepare failed: " . mysqli_error($connection));
    }
    mysqli_stmt_bind_param($auth_update, "sssi", $firstname, $lastname, $email, $user_id);
    $auth_result = mysqli_stmt_execute($auth_update);

    if (!$auth_result) {
        die("Update failed: " . mysqli_error($connection));
    }

    // Handle file upload
    $profile_img = $_POST['existing_profile_img'] ?? null;
    if (!empty($_FILES['profile_pic']['name']) && $_FILES['profile_pic']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "../uploads/profile_photos/";

        // Create directory if it doesn't exist
        if (!file_exists($target_dir)) {
            if (!mkdir($target_dir, 0755, true)) {
                die("Failed to create upload directory");
            }
        }

        $file_ext = strtolower(pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

        // Validate file type
        if (!in_array($file_ext, $allowed_extensions)) {
            header("Location: ../dashboard.php?section=profile&error=invalid_file_type");
            exit();
        }

        // Validate file size (max 2MB)
        if ($_FILES['profile_pic']['size'] > 10485760) {
            header("Location: ../dashboard.php?section=profile&error=file_too_large");
            exit();
        }

        $filename = "profile_" . $user_id . "." . $file_ext;
        $target_file = $target_dir . $filename;

        // 🔥 Delete all old images with same user_id (jpg, png, etc.)
        $existing_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        foreach ($existing_extensions as $ext) {
            $old_file = $target_dir . "profile_" . $user_id . "." . $ext;
            if (file_exists($old_file)) {
                unlink($old_file);
            }
        }


        // Check if image file is valid
        if (getimagesize($_FILES['profile_pic']['tmp_name'])) {
            if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target_file)) {
                $profile_img = "uploads/profile_photos/" . $filename;

                // Delete old profile image if it exists and is different
                if (
                    !empty($_POST['existing_profile_img']) &&
                    $_POST['existing_profile_img'] != $profile_img &&
                    file_exists("../" . $_POST['existing_profile_img'])
                ) {
                    unlink("../" . $_POST['existing_profile_img']);
                }
            } else {
                header("Location: ../dashboard.php?section=profile&error=upload_failed");
                exit();
            }
        } else {
            header("Location: ../dashboard.php?section=profile&error=invalid_image");
            exit();
        }
    }

    // Check if profile exists
    $check_profile = mysqli_prepare($connection, "SELECT id FROM profile WHERE user_id = ?");
    mysqli_stmt_bind_param($check_profile, "i", $user_id);
    mysqli_stmt_execute($check_profile);
    mysqli_stmt_store_result($check_profile);

    if (mysqli_stmt_num_rows($check_profile) > 0) {
        // Update existing profile
        $query = "UPDATE profile SET phone = ?, program = ?, bio = ?";
        $types = "sss";
        $params = [$phone, $program, $bio];

        if ($profile_img) {
            $query .= ", profile_img = ?";
            $types .= "s";
            $params[] = $profile_img;
        }

        $query .= " WHERE user_id = ?";
        $types .= "i";
        $params[] = $user_id;

        $profile_update = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($profile_update, $types, ...$params);
        $update_result = mysqli_stmt_execute($profile_update);
    } else {
        // Insert new profile
        $profile_insert = mysqli_prepare(
            $connection,
            "INSERT INTO profile (user_id, phone, program, profile_img, bio) VALUES (?, ?, ?, ?, ?)"
        );
        mysqli_stmt_bind_param($profile_insert, "issss", $user_id, $phone, $program, $profile_img, $bio);
        $update_result = mysqli_stmt_execute($profile_insert);
    }

    if ($update_result) {
        header("Location: ../dashboard.php?section=profile&success=1");
    } else {
        header("Location: ../dashboard.php?section=profile&error=db_error&msg=" . urlencode(mysqli_error($connection)));
    }
    exit();
}
?>