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
            $_SESSION['message'] = '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <span class="text-secondary">Sorry, failed added organizations</span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';
            header("Location: organization");
            exit();
        }
    }
}

if (isset($_POST['btn-edit-organizations'])) {
    $id = decodeURL($_GET['target']);
    $name = htmlentities($_POST['organization-name']);
    $email = htmlentities($_POST['organization-email']);
    $username = htmlentities($_POST['organization-username']);
    $password = htmlentities($_POST['organization-password']);

    $query = "UPDATE organizations SET name= :name, email= :email, username= :username, password= :password WHERE id=:id";
    $sql = $pdo->prepare($query);
    $sql->bindParam(':id', $id);
    $sql->bindParam(':name', $name);
    $sql->bindParam(':email', $email);
    $sql->bindParam(':username', $username);
    $sql->bindParam(':password', $password);
    if ($sql->execute()) {
        $_SESSION['message'] = '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="text-secondary">Successfully update organization</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
        header("Location: organization");
        exit();
    } else {
        $_SESSION['message'] = '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <span class="text-secondary">Sorry, failed edit organizations</span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';
        header("Location: organization");
        exit();
    }
}

if (isset($_GET['delete'])) {
    $id = htmlentities(decodeURL($_GET['target']));
    $query = "UPDATE organizations SET status = 0 WHERE id=:id";
    $sql = $pdo->prepare($query);
    $sql->bindParam(':id', $id);
    if ($sql->execute()) {
        $_SESSION['message'] = '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="text-secondary">Successfully delete organization</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
        header("Location: organization");
        exit();
    } else {
        $_SESSION['message'] = '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <span class="text-secondary">Sorry, failed delete organization</span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';
        header("Location: organization");
        exit();
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
                                    $result = $pdo->query("SELECT * FROM organizations WHERE status = 1 ORDER BY id DESC");
                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $row['name'] ?></td>
                                        <td><?= $row['email'] ?></td>
                                        <td class="text-center">
                                            <?php
                                                if ($row['status'] == 1) {
                                                    echo "<span class='badge badge-info'>Active</span>";
                                                } else {
                                                    echo "<span class='badge badge-secondary'>Non-active</span>";
                                                }
                                                ?>
                                        </td>
                                        <td>
                                            <a href="?edit&target=<?= encodeURL($row['id']) ?>"
                                                class="btn btn-outline-primary btn-sm">Edit</a>
                                            <a href="?delete&target=<?= encodeURL($row['id']) ?>"
                                                class="btn btn-outline-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            if (isset($_GET['edit'])) {
                include("components/organization/organization_edit.php");
            } else {
                include("components/organization/organization_add.php");
            }
            ?>
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