<!doctype html>
<html lang="en">

<?php include('template/head.php') ?>
<?php

if (isset($_POST['btn-login'])) {
    $username = $_POST['username'];
    $password = hashSHA384($_POST['password']);

    $sql = $pdo->prepare("SELECT * FROM admin WHERE BINARY username=:username AND BINARY password=:password");
    $sql->bindParam(':username', $username);
    $sql->bindParam(':password', $password);
    if ($sql->execute()) {
        $data = $sql->fetch();
        if ($data > 0) {
            //jika ada usernya
            $_SESSION['admin-login'] = true;
            $_SESSION['username'] = encodeURL($data['username']);
            header("Location: organization");
            exit();
        } else {
            //jika tidak ada usernya
            $_SESSION['message'] = '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <span class="text-secondary">Sorry, your username or password not found</span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';
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
                            if (isset($_SESSION['message'])) {
                                echo $_SESSION['message'];
                                unset($_SESSION['message']);
                            }
                            ?>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" name="username"
                                    placeholder="Please enter administrator username" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" placeholder="Password for administrator"
                                    name="password" required>
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