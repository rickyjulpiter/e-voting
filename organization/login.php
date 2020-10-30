<!doctype html>
<html lang="en">

<?php include('template/head.php');

// echo hashSHA384("kmb@kmb.kmb");

if (isset($_POST['btn-login'])) {
    $email = htmlentities($_POST['email']);
    $password = hashSHA384(htmlentities($_POST['password']));

    $sql = $pdo->prepare("SELECT * FROM organizations WHERE BINARY email=:email AND BINARY password=:password");
    $sql->bindParam(':email', $email);
    $sql->bindParam(':password', $password);
    if ($sql->execute()) {
        $data = $sql->fetch();
        if ($data > 0) {
            //jika ada usernya
            $_SESSION['organization-login'] = true;
            $_SESSION['username'] = encodeURL($data['username']);
            $_SESSION['organization_id'] = encodeURL($data['id']);
            header("Location: election");
            exit();
        } else {
            //jika tidak ada usernya
            message_failed("Sorry, your email or password not found");
            header("Location: login ");
            exit();
        }
    }
}

?>

<body>
    <?php include('template/nav.php') ?>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-4 mx-auto">
                <div class="card">
                    <div class="card-header text-black">
                        <h4 class="text-center">Login</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <?php
                            message_check();
                            ?>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" placeholder="Password" name="password"
                                    required>
                            </div>
                            <button type="submit" class="btn btn-primary float-right" name="btn-login">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <?php include('template/script.php') ?>

</body>

</html>