<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbName   = 'myDB';

$con = mysqli_connect($host, $username, $password, $dbName);
if ($con->connect_error){
    die("No" . $con->connect_error);
}

function registerUser($email, $password)
{
    global $con;
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $con -> prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $hashedPassword);
    $stmt->execute();
    $stmt->close();
}

function loginUser($email, $password)
{
    global $con;
    $stmt = $con->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($userId, $hashedPassword);
    $stmt->fetch();
    $stmt->close();

    if (password_verify($password, $hashedPassword)) {
        $_SESSION['user_id'] = $userId;
        return true;
    } else {
        return false;
    }
}

function saveMessage($userId, $message)
{
    global $con;
    $stmt = $con->prepare("INSERT INTO messages (user_id, message) VALUES (?, ?)");
    $stmt->bind_param("is", $userId, $message);
    $stmt->execute();
    $stmt->close();
}

function getMessage()
{
    global $con;
    $stmt = $con->prepare("SELECT messages.message, messages.created_at, users.email FROM messages JOIN users ON messages.user_id = users.id ORDER BY messages.created_at DESC");
    $stmt->execute();
    $result = $stmt->get_result();
    $messages = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $messages;
}




?>



