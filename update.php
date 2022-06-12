<?php

include 'functions.php';
$pdo = pdo_connect();

if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $title = $_POST['title'];
        // Insert new record into the contacts table
        $pdo->beginTransaction();
        $stmt = $pdo->prepare('UPDATE contacts SET name = ?, email = ?, phone = ?, title = ? WHERE id = ?');
        $stmt->execute([$name, $email, $phone, $title, $_GET['id']]);
        $pdo->commit();
        header("location:index.php");
    }

    $stmt = $pdo->prepare('SELECT * FROM contacts WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        die('Contact doesn\'t exist!');
    }
} else {
    die('No ID specified!');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?= style_script() ?>
    <title>Change contact</title>
</head>

<body>
    <div class="container" style="margin-top:50px">
        <div class="row">
            <div class="col-md-5 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Update contact # <?= $contact['id'] ?></h5>
                        <form action="update.php?id=<?= $contact['id'] ?>" method="post">
                            <input class="form-control form-control-sm" placeholder="Type name" type="text" name="name" value="<?= $contact['name'] ?>" id="name" required><br>
                            <input class="form-control form-control-sm" placeholder="Email" type="text" name="email" value="<?= $contact['email'] ?>" id="email" required><br>
                            <input class="form-control form-control-sm" placeholder="Phone number" type="text" name="phone" value="<?= $contact['phone'] ?>" id="phone"><br>
                            <input class="form-control form-control-sm" placeholder="Title" type="text" name="title" value="<?= $contact['title'] ?>" id="title"><br>
                            <input class="btn btn-primary btn-sm" type="submit" value="Update">
                            <a href="index.php" type="button" class="btn btn-warning btn-sm">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-7 col-sm-12 col-xs-12"></div>
        </div>
    </div>

    <div class="text-center">
        <p class="mt-5 mb-3 text-muted">hk &copy; 2021</p>
    </div>
</body>

</html>
