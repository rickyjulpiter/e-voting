<!doctype html>
<html lang="en">

<?php
include('template/head.php');
adminSession($_SESSION);


if (isset($_POST['btn-add-organizations'])) {
    $name = htmlentities($_POST['organization-name']);
    $email = htmlentities($_POST['organization-email']);
    $username = htmlentities($_POST['organization-username']);
    $password = htmlentities($_POST['organization-password']);

    $sql = $pdo->prepare("SELECT * FROM organizations WHERE email = :email OR username = :username");
    $sql->bindParam(':email', $email);
    $sql->bindParam(':username', $username);
    $sql->execute();
    $data = $sql->fetch(PDO::FETCH_ASSOC);
    if ($data > 0) {
        //username atau email sudah digunakan
        $_SESSION['message'] = '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <span class="text-secondary">Sorry, your email or username already used</span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';
        header("Location: organization");
        exit();
    } else {
        $query = "INSERT INTO organizations (name, email, username, password) VALUES (:name, :email, :username, :password)";
        $sql = $pdo->prepare($query);
        $sql->bindParam(':name', $name);
        $sql->bindParam(':email', $email);
        $sql->bindParam(':username', $username);
        $sql->bindParam(':password', $password);
        if ($sql->execute()) {
            $_SESSION['message'] = '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="text-secondary">Successfully added organization</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
            header("Location: organization");
            exit();
        } else {
            echo $query;
        }
    }
}

?>

<body>
    <?php include('template/nav.php') ?>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header">
                        <span class="badge badge-primary p-2">Organization List</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $result = $pdo->query("SELECT * FROM organizations ORDER BY id DESC");
                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $row['name'] ?></td>
                                        <td><?= $row['email'] ?></td>
                                        <td>
                                            <?php
                                                if ($row['status'] == 1) {
                                                    echo "<span class='badge badge-info'>Active</span>";
                                                } else {
                                                    echo "<span class='badge badge-secondary'>Non-active</span>";
                                                }
                                                ?>
                                        </td>
                                        <td>
                                            <a href="" class="btn btn-outline-primary btn-sm">Edit</a>
                                            <a href="" class="btn btn-outline-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <span class="badge badge-success p-2">Add Organization</span>
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
                                <label>Organization Name</label>
                                <input type="text" name="organization-name" class="form-control"
                                    placeholder="Please enter organization name" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="organization-email"
                                    placeholder="Please enter organization email" required>
                            </div>
                            <div class="form-group">
                                <label>Admininistrator</label>
                                <input type="text" class="form-control" name="organization-username"
                                    placeholder="Please enter admin organization username" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="organization-password" class="form-control"
                                    placeholder="Password for administrator" required>
                            </div>
                            <button type="submit" name="btn-add-organizations" class="btn btn-info float-right">Add
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include('template/script.php') ?>
    <script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
    </script>

</body>

</html>