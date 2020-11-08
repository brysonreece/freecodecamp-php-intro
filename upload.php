<?php

// Get user image
$image = $_FILES['photo'];

// Get image info
$imageExtension = pathinfo($image['name'], PATHINFO_EXTENSION); // get file extension
$imageExtension = strtolower($imageExtension); // convert to lowercase

// Set upload target
$targetDir = 'images/';
$targetFile = $targetDir . basename($image['name']);
$sizeLimitMb = 10;
$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

// Allocate variable for potential error
$error = null;

// Tell script where to redirect after upload attempt
$redirectTo = 'index.php';

// Check if file already exists
if (file_exists($targetFile)) {
  $error = "Sorry, file already exists.";
}

// Check file size
if ($image['size'] > ($sizeLimitMb * 1000000)) {
  $error = "Sorry, your file is too large.";
}

// Allow certain file formats
if(! in_array($imageExtension, $allowedExtensions)) {
  $error = "Sorry, only JPG, JPEG, PNG and GIF files are allowed.";
}

// Check if an error was recorded
if ($error != null) {
    header("Location: {$redirectTo}?error={$error}");
}
else {
    if (move_uploaded_file($image['tmp_name'], $targetFile)) {
        $success = "The file ". htmlspecialchars(basename( $image['name'])). " has been uploaded.";
        header("Location: {$redirectTo}?success={$success}");
    }
    else {
        $error = "Sorry, there was an unknown error uploading your file.";
        header("Location: {$redirectTo}?error={$error}");
    }
}
