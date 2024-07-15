<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


$host = 'localhost';
$username = 'root';
$password = '';
$dbName   = 'myDB';

try {
    $con = new PDO("mysql:host=$host; dbname=$dbName", $username, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

function registerUser($email, $password)
{
    global $con;
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $con -> prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->execute();
}

function loginUser($email, $password)
{
    global $con;
    $stmt = $con->prepare("SELECT id, password FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user=$stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])){
        $_SESSION['user_id'] = $user['id'];
        return true;
    }else{
        return false;
    }
}

function saveMessage($userId, $message)
{
    global $con;
    $stmt = $con->prepare("INSERT INTO messages (user_id, message) VALUES (:user_id, :message)");
    $stmt->bindParam(':user_id', $userId);
    $stmt->bindParam(':message', $message);
    $stmt->execute();
}

function getMessage()
{
    global $con;
    $stmt = $con->prepare("SELECT messages.message, messages.created_at, users.email FROM messages JOIN users ON messages.user_id = users.id ORDER BY messages.created_at DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>



