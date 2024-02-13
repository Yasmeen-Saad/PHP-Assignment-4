<?php
session_start();

if(isset($_POST['submit']))
{
    $file = $_FILES['file'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileError = $file['error'];
    $ext = pathinfo($fileName, PATHINFO_EXTENSION);

    // Validation
    $errors = [];
    if(! $fileError == 0){
        $errors[] = "There is an error";
    } elseif($ext !== 'json'){
        $errors[] = "The extension must be .json";
    }

    if(empty($errors)){
        echo "Uploaded successfully!!";
        $randomStr = uniqid();
        $fileNewName = "$randomStr.$ext";
        move_uploaded_file($fileTmpName, $fileNewName);
    } else{
        print_r($errors);
    }

    $fileOpen = fopen($fileNewName, "r");
    $fileRead = fread($fileOpen, filesize($fileNewName));
    // print_r($fileRead);
    $_SESSION['data'] = $fileRead;
}