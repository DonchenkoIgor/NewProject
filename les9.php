<?php

$file_path = 'data.txt';

function saveUserData($data){
    global $file_path;
    file_put_contents($file_path, json_encode($data) . PHP_EOL, FILE_APPEND);
}

function getUserData(){
    global $file_path;
    $data = [];
    if (file_exists($file_path)){
        $file_contents = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($file_contents as $line){
            $data[] = json_decode($line, true);
        }
    }
    return $data;
}

function  clearUserData(){
    global $file_path;
    file_put_contents($file_path, '');
}

if (isset($_POST['clear'])){
    clearUserData();
    $_SESSION['user'] = [];
    $_SESSION['is_logged_in'] = false;
}

if (!empty($_POST['email']) && !empty($_POST['password'])){
    $_SESSION['is_logged_in'] = true;

    $userData = [
      'email' => $_POST['email'],
      'password' => $_POST['password']
    ];

    $_SESSION['user'] [] = $userData;
    $_SESSION['last_email'] = count($_SESSION['user']) - 1;
    $_SESSION['form_submited'] = true;

    saveUserData($userData);

    $entered_email = '';
    $entered_password = '';
}else{
    $entered_email = '';
    $entered_password = '';
}
?>