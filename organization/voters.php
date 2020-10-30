<!doctype html>
<html lang="en">

<?php
include('template/head.php');
adminOrganization($_SESSION);
$organization_id = decodeURL($_SESSION['organization_id']);

if (isset($_GET['target'])) {
    $targetID = decodeURL($_GET['target']);
    if (isset($_GET['verif'])) {
        $status = 1;
    }

    if (isset($_GET['unverif'])) {
        $status = 0;
    }

    $sql = $pdo->prepare("UPDATE voters SET status = '$status' WHERE id = :id");
    $sql->bindParam(':id', $targetID);
    if ($sql->execute()) {
        message_success("Successfully update status");
        header("Location: voters");
        exit();
    } else {
        message_failed("Failed update status");
        header("Location: voters");
        exit();
    }
}
?>

<body>
    <?php include('template/nav.php') ?>
    <div class="m-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header">
                        <span class="badge badge-primary p-2">Voters List</span>
                    </div>
                    <div class="card-body">
                        <?php message_check() ?>
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Faculty</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $result = $pdo->query("SELECT A.id,     A.name, A.email, A.phone, B.name AS faculty_name, A.status FROM voters A, faculty B WHERE A.organization_id = '$organization_id' AND A.faculty_id = B.id ORDER BY A.id DESC");
                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $row['name'] ?></td>
                                        <td><?= $row['email'] ?></td>
                                        <td><?= $row['phone'] ?></td>
                                        <td><?= $row['faculty_name'] ?></td>
                                        <td>
                                            <?php
                                                if ($row['status'] == 1) {
                                                    echo "<a href='?target=" . encodeURL($row['id']) . "&unverif' class='btn btn-sm btn-info'>Verified</a>";
                                                } else {
                                                    echo "<a href='?target=" . encodeURL($row['id']) . "&verif' class='btn btn-sm btn-warning'>Unverified</a>";
                                                }
                                                ?>
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
                        <span class="badge badge-info p-2">Voters Summary</span>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Faculty</th>
                                    <th class="text-center">Verified</th>
                                    <th class="text-center">Unverified</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $query = "SELECT * FROM faculty WHERE organization_id = '$organization_id' AND status = 1";
                                $result = $pdo->query($query);
                                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                    $faculty_id = $row['id'];
                                    $faculty_name = $row['name'];
                                    $queryCount =
                                        "SELECT 
                                        COUNT(CASE WHEN status = 1 then 1 else null end) as verifiedVoters, 
                                        COUNT(CASE WHEN status = 0 then 0 else null end) as unverifiedVoters 
                                        FROM voters WHERE organization_id = '$organization_id' AND faculty_id = '$faculty_id'";

                                    $sql = $pdo->prepare($queryCount);
                                    $sql->bindParam(':username', $username);
                                    $sql->bindParam(':password', $password);
                                    $sql->execute();
                                    $data = $sql->fetch();
                                ?>
                                <tr>
                                    <td><?= $faculty_name ?></td>
                                    <td class="text-center"><?= $data['verifiedVoters'] ?></td>
                                    <td class="text-center"><?= $data['unverifiedVoters'] ?></td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
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