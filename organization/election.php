<!doctype html>
<html lang="en">

<?php
include('template/head.php');
adminOrganization($_SESSION);

if (isset($_POST['btn-add-election'])) {
    $name = htmlentities($_POST['election-name']);
    $organization_id = decodeURL($_SESSION['organization_id']);
    $date_start = htmlentities($_POST['date_start']);
    $time_start = htmlentities($_POST['time_start']);
    $date_end = htmlentities($_POST['date_end']);
    $time_end = htmlentities($_POST['time_end']);

    $query = "INSERT INTO election (name, date_start, date_end, time_start, time_end, organization) VALUES ('$name', '$date_start', '$date_end', '$time_start', '$time_end' ,'$organization_id')";
    $sql = $pdo->prepare($query);
    if ($sql->execute()) {
        message_success("Successfully add election");
    } else {
        message_failed("Sorry, failed added election");
    }
    header("Location: election");
    exit();
}

if (isset($_POST['btn-edit-election'])) {
    $id = decodeURL($_GET['target']);
    $name = htmlentities($_POST['election-name']);

    $query = "UPDATE election SET name= :name WHERE id=:id";
    $sql = $pdo->prepare($query);
    $sql->bindParam(':id', $id);
    $sql->bindParam(':name', $name);
    if ($sql->execute()) {
        message_success("Successfully edit election");
    } else {
        message_failed("Sorry, failed edit election");
    }
    header("Location: election");
    exit();
}

if (isset($_GET['delete'])) {
    $id = htmlentities(decodeURL($_GET['target']));
    $query = "UPDATE election SET status = 0 WHERE id=:id";
    $sql = $pdo->prepare($query);
    $sql->bindParam(':id', $id);
    if ($sql->execute()) {
        message_success("Successfully delete election");
    } else {
        message_success("Failed delete election");
    }
    header("Location: election");
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
                        <span class="badge badge-primary p-2">Election List</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Date Start</th>
                                        <th>Time Start</th>
                                        <th>Date End</th>
                                        <th>Time End</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $organization_id = decodeURL($_SESSION['organization_id']);
                                    $query = "SELECT * FROM election WHERE organization = '$organization_id' ORDER BY id DESC";
                                    $result = $pdo->query($query);
                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $row['name'] ?></td>
                                        <td><?= $row['date_start'] ?></td>
                                        <td><?= $row['time_start'] ?></td>
                                        <td><?= $row['date_end'] ?></td>
                                        <td><?= $row['time_end'] ?></td>
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
                include("components/election/election_edit.php");
            } else {
                include("components/election/election_add.php");
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