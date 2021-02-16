<!doctype html>
<html lang="en">

<?php
include('template/head.php');
adminAdministrator($_SESSION);

if (isset($_POST['btn-add-organizations'])) {
    $name = htmlentities($_POST['organization-name']);
    $email = htmlentities($_POST['organization-email']);
    $username = htmlentities($_POST['organization-username']);
    $password = hashSHA384(htmlentities($_POST['organization-password']));

    $sql = $pdo->prepare("SELECT * FROM organizations WHERE email = :email OR username = :username");
    $sql->bindParam(':email', $email);
    $sql->bindParam(':username', $username);
    $sql->execute();
    $data = $sql->fetch(PDO::FETCH_ASSOC);
    if ($data > 0) {
        //username atau email sudah digunakan
        message_failed("Sorry, your email or username already used");
    } else {
        $query = "INSERT INTO organizations (name, email, username, password) VALUES (:name, :email, :username, :password)";
        $sql = $pdo->prepare($query);
        $sql->bindParam(':name', $name);
        $sql->bindParam(':email', $email);
        $sql->bindParam(':username', $username);
        $sql->bindParam(':password', $password);
        if ($sql->execute()) {
            message_success("Successfully added organization");
        } else {
            message_failed("Sorry, failed added organizations");
        }
    }
    header("Location: organization");
    exit();
}

if (isset($_POST['btn-edit-organizations'])) {
    $id = decodeURL($_GET['target']);
    $name = htmlentities($_POST['organization-name']);
    $email = htmlentities($_POST['organization-email']);
    $username = htmlentities($_POST['organization-username']);
    $password = hashSHA384(htmlentities($_POST['organization-password']));

    $query = "UPDATE organizations SET name= :name, email= :email, username= :username, password= :password WHERE id=:id";
    $sql = $pdo->prepare($query);
    $sql->bindParam(':id', $id);
    $sql->bindParam(':name', $name);
    $sql->bindParam(':email', $email);
    $sql->bindParam(':username', $username);
    $sql->bindParam(':password', $password);
    if ($sql->execute()) {
        message_success("Successfully update organization");
    } else {
        message_failed("Sorry, failed edit organizations");
    }
    header("Location: organization");
    exit();
}

if (isset($_GET['delete'])) {
    $id = htmlentities(decodeURL($_GET['target']));
    $query = "UPDATE organizations SET status = 0 WHERE id=:id";
    $sql = $pdo->prepare($query);
    $sql->bindParam(':id', $id);
    if ($sql->execute()) {
        message_success("Successfully delete organization");
    } else {
        message_failed("Sorry, failed delete organization");
    }
    header("Location: organization");
    exit();
}
?>

<body>
    <?php include('template/nav.php') ?>
    <div class="container-fluid mt-4">
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
                                        <th class="text-center">Status</th>
                                        <th class="text-center">#</th>
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
                                        <td class="text-center">
                                            <a href="?edit&target=<?= encodeURL($row['id']) ?>"
                                                class="btn btn-outline-primary btn-sm"><i class="fa fa-pencil"
                                                    aria-hidden="true"></i></a>
                                            <a href="?delete&target=<?= encodeURL($row['id']) ?>"
                                                class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"
                                                    aria-hidden="true"></i></a>
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