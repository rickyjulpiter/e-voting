<!doctype html>
<html lang="en">

<?php
include('template/head.php');
adminOrganization($_SESSION);
$organization_id = decodeURL($_SESSION['organization_id']);

if (isset($_POST['btn-add-faculty'])) {
    $name = htmlentities($_POST['faculty-name']);
    $max_voters = htmlentities($_POST['faculty-max-voters']);

    $sql = $pdo->prepare("SELECT * FROM faculty WHERE name = :name AND organization_id = :organization_id");
    $sql->bindParam(':name', $name);
    $sql->bindParam(':organization_id', $organization_id);
    $sql->execute();
    $data = $sql->fetch(PDO::FETCH_ASSOC);
    if ($data > 0) {
        //jika nama fakultas sudah ada, aktifkan kembali
        if ($data['status'] == 0) {
            $sql = $pdo->prepare("UPDATE faculty SET status = 1 WHERE name = :name");
            $sql->bindParam(':name', $name);
            if ($sql->execute()) {
                message_success("Successfully added faculty");
            }
        } else {
            message_success("Faculty already on list");
        }
        header("Location: faculty");
        exit();
    } else {
        $query = "INSERT INTO faculty (name, max_voters, organization_id) VALUES (:name, :max_voters, :organization_id)";
        $sql = $pdo->prepare($query);
        $sql->bindParam(':name', $name);
        $sql->bindParam(':max_voters', $max_voters);
        $sql->bindParam(':organization_id', $organization_id);
        if ($sql->execute()) {
            message_success("Successfully added faculty");
        } else {
            message_failed("Sorry, failed added faculty");
        }
        header("Location: faculty");
        exit();
    }
}

if (isset($_POST['btn-edit-faculty'])) {
    $id = htmlentities(decodeURL($_GET['target']));
    $name = htmlentities($_POST['faculty-name']);
    $max_voters = htmlentities($_POST['faculty-max-voters']);

    $query = "UPDATE faculty SET name= :name, max_voters= :max_voters WHERE id=:id";
    $sql = $pdo->prepare($query);
    $sql->bindParam(':id', $id);
    $sql->bindParam(':name', $name);
    $sql->bindParam(':max_voters', $max_voters);
    if ($sql->execute()) {
        message_success("Successfully edit faculty");
    } else {
        message_failed("Sorry, failed edit faculty");
    }
    header("Location: faculty");
    exit();
}

if (isset($_GET['delete'])) {
    $id = htmlentities(decodeURL($_GET['target']));
    $query = "UPDATE faculty SET status = 0 WHERE id=:id";
    $sql = $pdo->prepare($query);
    $sql->bindParam(':id', $id);
    if ($sql->execute()) {
        message_success("Successfully delete faculty");
    } else {
        message_success("Failed delete faculty");
    }
    header("Location: faculty");
    exit();
}
?>

<body>
    <?php include('template/nav.php') ?>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header">
                        <span class="badge badge-primary p-2">Faculty List</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Max Accepted Voters</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $result = $pdo->query("SELECT * FROM faculty WHERE organization_id = '$organization_id' AND status = 1 ORDER BY id DESC");
                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $row['name'] ?></td>
                                        <td><?= $row['max_voters'] ?></td>
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
                include("components/faculty/faculty_edit.php");
            } else {
                include("components/faculty/faculty_add.php");
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