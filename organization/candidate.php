<!doctype html>
<html lang="en">

<?php
include('template/head.php');
adminOrganization($_SESSION);

if (isset($_POST['btn-add-candidate'])) {
    $name = htmlentities($_POST['candidate-name']);
    $organization_id = decodeURL($_SESSION['organization_id']);
    $notes = htmlentities($_POST['candidate-notes']);

    $query = "INSERT INTO candidate (name, notes, organization_id) VALUES ('$name', '$notes' ,'$organization_id')";
    $sql = $pdo->prepare($query);
    if ($sql->execute()) {
        message_success("Successfully add candidate");
    } else {
        message_failed("Sorry, failed added candidate");
    }
    header("Location: candidate");
    exit();
}

if (isset($_POST['btn-edit-candidate'])) {
    $id = decodeURL($_GET['target']);
    $name = htmlentities($_POST['candidate-name']);
    $notes = htmlentities($_POST['candidate-notes']);

    $query = "UPDATE candidate SET name= :name, notes= :notes WHERE id=:id";
    $sql = $pdo->prepare($query);
    $sql->bindParam(':id', $id);
    $sql->bindParam(':name', $name);
    $sql->bindParam(':notes', $notes);
    if ($sql->execute()) {
        message_success("Successfully edit candidate");
    } else {
        message_failed("Sorry, failed edit candidate");
    }
    header("Location: candidate");
    exit();
}

if (isset($_GET['delete'])) {
    $id = htmlentities(decodeURL($_GET['target']));
    $query = "UPDATE candidate SET status = 0 WHERE id=:id";
    $sql = $pdo->prepare($query);
    $sql->bindParam(':id', $id);
    if ($sql->execute()) {
        message_success("Successfully delete candidate");
    } else {
        message_success("Failed delete candidate");
    }
    header("Location: candidate");
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
                        <span class="badge badge-primary p-2">Candidate List</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Notes</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $organization_id = decodeURL($_SESSION['organization_id']);
                                    $query = "SELECT * FROM candidate WHERE organization_id = '$organization_id' AND status = 1 ORDER BY id DESC";
                                    $result = $pdo->query($query);
                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $row['name'] ?></td>
                                        <td><?= $row['notes'] ?></td>
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
                include("components/candidate/candidate_edit.php");
            } else {
                include("components/candidate/candidate_add.php");
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