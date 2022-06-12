<?php 
    include "functions.php";

    session_start();
    $token = $_POST['token'];
    if ((!$token) || ($token != $_SESSION['token'])) {
        echo '<p class="error">Error: invalid form submission</p>';
        header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
        exit;
    } else{
        if (isset($_POST['username']) && isset($_POST['password'])) {

            $user = htmlentities($_POST['username']);
            $pass = htmlentities($_POST['password']);
            $pdo = pdo_connect();
            $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ? LIMIT 1');
            $stmt->execute([$user]);
            $notif = $stmt->rowCount();
            $IP = getenv ( "REMOTE_ADDR" );
            if ($stmt->rowCount() > 0) {
                $userss = $stmt->fetch();
                $hash_salt = $userss['salted_pass'];
                if(password_verify($pass, $hash_salt )){
                    $_SESSION['user'] = $user;
                    header("location: index.php");
                } else {
                    $_SESSION['notif'] = "Wrong usename or password";
                    header("location: login.php");
                }
            } else {
                $notif = "Wrong usename or password";
            }

            
        }
    }

    ?>
