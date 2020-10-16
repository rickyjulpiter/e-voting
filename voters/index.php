<!doctype html>
<html lang="en">

<?php
include('template/head.php');

if (isset($_POST['btn-login'])) {
    $username = htmlentities($_POST['username']);
    $password = hashSHA384(htmlentities($_POST['password']));

    $sql = $pdo->prepare("SELECT * FROM voters WHERE BINARY username=:username AND BINARY password=:password");
    $sql->bindParam(':username', $username);
    $sql->bindParam(':password', $password);
    if ($sql->execute()) {
        $data = $sql->fetch();
        if ($data > 0) {
            //jika ada usernya
            $_SESSION['voters-login'] = true;
            $_SESSION['username'] = encodeURL($data['username']);
            $_SESSION['voters_id'] = encodeURL($data['id']);
            $_SESSION['organization_id'] = encodeURL($data['organization_id']);
            $_SESSION['faculty_id'] = encodeURL($data['faculty_id']);
            header("Location: election");
            exit();
        } else {
            //jika tidak ada usernya
            message_failed("Sorry, your username or password not found");
            header("Location: ./ ");
            exit();
        }
    }
}
?>

<body>
    <?php include('template/nav.php') ?>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6 mb-2">
                <img src="assets/sistempintar.png" class="card-img img-fluid" alt="...">
            </div>
            <div class="col-md-4 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h4 class="p-2 text-center">Login</h4>
                        <form method="POST">
                            <?php
                            message_check();
                            ?>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" name="username" placeholder="Username" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" placeholder="Password" name="password"
                                    required>
                            </div>
                            <button type="submit" class="btn btn-info btn-block" name="btn-login">Login</button>
                            <small class="float-right mt-2">or <a href="register">Register Here</a> </small>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('template/script.php') ?>

</body>

</html>