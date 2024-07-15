<?php
session_start();
require_once 'les9.php';
require_once 'les11.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (isset($_POST['register'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
        registerUser($email, $password);
    }

    if (isset($_POST['login'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
        if (loginUser($email, $password)){
            $_SESSION['is_logged_in'] = true;
            echo "User logged in successfully";
        }else{
            echo "Invalid email or password";
        }
    }
    if (isset($_POST['message']) && isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']) {
        $message = $_POST['message'];
        $userId = $_SESSION['user_id'];
        saveMessage ($userId, $message);
        echo "Message saved successfully";
    }
    if (isset($_POST['clear'])){
        clearUserData();
        $_SESSION ['user'] = [];
        $_SESSION ['is_logged_in'] = false;
    }
}

$messages = getMessage();


if (!isset($_COOKIE['counter'])) {
    $counter = 0;
} else {
    $counter = $_COOKIE['counter'];
}
$counter++;
setcookie('counter', $counter);
setcookie('test', 1);

if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = [];
}

if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $_SESSION['is_logged_in'] = true;

    $_SESSION['user'][] = [
        'email'   => $_POST['email'],
        'password' => $_POST['password']
    ];

    $_SESSION['last_email'] = count($_SESSION['user']) - 1;
    $_SESSION['form_submited'] = true;

    $entered_email = '';
    $entered_password = '';
} else {
    $entered_email = '';
    $entered_password = '';
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
          crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous">
    </script>
    <title>Form</title>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <?php if (!empty($_POST['email'])) : ?>
                <div class="alert alert-success" role="alert">
                    <?php
                    $email = $_POST['email'];
                    if (strlen(trim($email)) <= 3)
                        echo "Email Invalid";
                    else {
                        echo "Вы вошли как " . htmlspecialchars($_POST['email']);
                    }
                    ?>
                </div>
            <?php endif; ?>
            <?php
            /*            var_dump($_COOKIE);
                        echo '<br>' . '<br>';
                        var_dump($_SESSION);
                        */?>
            <form method="post" action="">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email</label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           id="exampleInputEmail1"
                           aria-describedby="emailHelp"
                           value="<?php echo htmlspecialchars($entered_email); ?>">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password"
                           name="password"
                           class="form-control"
                           id="exampleInputPassword1"
                           value="<?php echo htmlspecialchars($entered_password); ?>">
                </div>
                <button type="submit" name="login" class="btn btn-primary">Log in</button>
            </form>

            <form method="post" action="">
                <h3>Register</h3>
                <div class="mb-3">
                    <label for="registerEmail" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="registerEmail">
                </div>
                <div class="mb-3">
                    <label for="registerPassword" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="registerPassword">
                </div>
                <button type="submit" name="register" class="btn btn-secondary">Register</button>
            </form>

            <form method="post" action="">
                <button type="submit" name="clear" class="btn btn-danger mt-3">Delete all</button>
            </form>

            <?php if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']) : ?>
                <form method="post" action="">
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <input type="text" name="message" class="form-control" id="message">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Message</button>
                </form>
            <?php endif; ?>
            <form method="post" action="">
                <button type="submit" name="clear" class="btn btn-danger mt-3">Delete all</button>
            </form>

            <h2>Messages</h2>
            <ul class="list-group">
                <?php foreach ($messages as $message) : ?>
                    <li class="list-group-item">
                        <strong><?php echo htmlspecialchars($message['email']); ?></strong><br>
                        <small><?php echo htmlspecialchars($message['created_at']); ?></small><br>
                        <?php echo htmlspecialchars($message['message']); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
</body>
</html>