<!doctype html>
<html lang="en">

<?php
include('template/head.php');
adminOrganization($_SESSION);
$organization_id = decodeURL($_SESSION['organization_id']);

if (isset($_POST['btn-add-candidate'])) {
    $name = htmlentities($_POST['candidate-name']);
    $notes = htmlentities($_POST['candidate-notes']);
    $election_id = htmlentities(decodeURL($_POST['candidate-election']));

    $query = "INSERT INTO candidate (name, notes, organization_id, election_id) VALUES ('$name', '$notes' ,'$organization_id', '$election_id')";
    $sql = $pdo->prepare($query);
    if ($sql->execute()) {
        message_success("Successfully add candidate");
    } else {
        message_failed("Failed add candidate");
    }
    header("Location: candidate");
    exit();
}

if (isset($_POST['btn-edit-candidate'])) {
    $id = decodeURL($_GET['target']);
    $name = htmlentities($_POST['candidate-name']);
    $notes = htmlentities($_POST['candidate-notes']);
    $election_id = htmlentities(decodeURL($_POST['candidate-election']));

    $query = "UPDATE candidate SET name= :name, notes= :notes, election_id = :election_id WHERE id=:id";
    $Q = "UPDATE candidate SET name= '$name', notes= '$notes', election_id = '$election_id' WHERE id='$id'";
    $sql = $pdo->prepare($query);
    $sql->bindParam(':id', $id);
    $sql->bindParam(':name', $name);
    $sql->bindParam(':notes', $notes);
    $sql->bindParam(':election_id', $election_id);
    if ($sql->execute()) {
        message_success("Successfully edit candidate");
    } else {
        message_failed($Q);
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

if (isset($_POST['btn-add-voters-as-candidate'])) {
    $election_id = decodeURL($_POST['election']);
    $organization_id = $organization_id;

    $query = "SELECT name FROM voters WHERE status = 1 AND organization_id = '$organization_id'";
    $result = $pdo->query($query);
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        //proses memasukkan nama pemilih ke kandidat
        $name = $row['name'];

        //setelah dapat nama, maka di cek dulu di kandidat, apakah sudah ada nama yang sama atau engga
        $querycek = "SELECT * FROM candidate WHERE name = '$name' AND organization_id = '$organization_id' AND election_id = '$election_id' ";
        $sqlcek = $pdo->prepare($querycek);
        $sqlcek->execute();
        $datacek = $sqlcek->fetch();
        if ($datacek > 0) {
            //jika sudah ada, tidak usah ditambahkan
        } else {
            //jika belum ada tambahkan
            $queryInsert = "INSERT INTO candidate (name, organization_id, election_id) VALUES ('$name', '$organization_id', '$election_id')";
            $sql = $pdo->prepare($queryInsert);
            $sql->execute();
        }
    }
    header("Location: candidate");
    exit();
}
?>

<body>
    <?php include('template/nav.php') ?>
    <div class="m-4">
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
                                        <th>Election</th>
                                        <th>Notes</th>
                                        <th class="text-center">#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $query = "SELECT A.name, A.notes, A.id, B.name AS electionName FROM candidate A, election B WHERE A.organization_id = '$organization_id' AND A.status = 1 AND A.election_id = B.id ORDER BY A.id DESC";
                                    $result = $pdo->query($query);
                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $row['name'] ?></td>
                                        <td><?= $row['electionName'] ?></td>
                                        <td><?= $row['notes'] ?></td>
                                        <td class="text-center">
                                            <a href="?edit&target=<?= encodeURL($row['id']) ?>"
                                                class="btn btn-outline-primary btn-sm">
                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                            </a>
                                            <a href="?delete&target=<?= encodeURL($row['id']) ?>"
                                                class="btn btn-outline-danger btn-sm">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
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