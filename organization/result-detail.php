<!doctype html>
<html lang="en">

<?php
include('template/head.php');
adminOrganization($_SESSION);
$organization_id = decodeURL($_SESSION['organization_id']);
$election_id = htmlentities(decodeURL($_GET['target']));

$sql = $pdo->prepare("SELECT * FROM election WHERE id=:id");
$sql->bindParam(':id', $election_id);
if ($sql->execute()) {
    $data = $sql->fetch();
}
?>

<body>
    <?php include('template/nav.php') ?>
    <div class="m-4">
        <div class="row">
            <!-- <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header">
                        <span class="badge badge-primary p-2">Result Detail : </span>
                        <span class="badge badge-success p-2"><?= $data['name'] ?></span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Faculty Name</th>
                                        <th class="text-center">In</th>
                                        <th class="text-center">Limit</th>
                                        <th class="text-center">Accepted</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $query = "SELECT * FROM faculty WHERE organization_id = '$organization_id' ORDER BY id DESC";
                                    // echo $query;
                                    $result = $pdo->query($query);
                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                        $faculty_id = $row['id'];
                                        $queryCountFaculty = "SELECT COUNT(B.faculty_id) AS facultyCount FROM voting A, voters B, faculty C, election D WHERE A.voters_id = B.id AND B.faculty_id = C.id AND B.organization_id = '$organization_id' AND B.faculty_id = '$faculty_id' AND D.organization_id = B.organization_id AND D.id = '$election_id'";

                                        $resultCountFaculty = $pdo->query($queryCountFaculty);
                                        while ($countFaculty = $resultCountFaculty->fetch(PDO::FETCH_ASSOC)) {
                                            if ($countFaculty['facultyCount'] >= $row['max_voters']) {
                                                $accepted = $row['max_voters'];
                                            } else {
                                                $accepted = $countFaculty['facultyCount'];
                                            }
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $row['name'] ?></td>
                                        <td class="text-center"><?= $countFaculty['facultyCount'] ?></td>
                                        <td class="text-center"><?= $row['max_voters'] ?></td>
                                        <td class="text-center"><?= $accepted ?></td>
                                    </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <span class="badge badge-primary p-2">Election Result</span>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Candidate Name</th>
                                    <th class="text-center">Total</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $arrayTotalVote = [];
                                $query = "SELECT * FROM candidate A WHERE A.organization_id = '$organization_id' AND A.election_id = '$election_id' ORDER BY A.id DESC";
                                $result = $pdo->query($query);
                                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                    $candidate_id = $row['id'];

                                    $queryCountVote = "SELECT COUNT(A.id) AS voteTotal FROM voting A, voters B WHERE A.candidate_id = '$candidate_id' AND A.voters_id = B.id AND A.status = 1";

                                    $resultVote = $pdo->query($queryCountVote);
                                    while ($rowVote = $resultVote->fetch(PDO::FETCH_ASSOC)) {
                                        $voteTotalCandidate = $rowVote['voteTotal'];
                                        array_push($arrayTotalVote, $voteTotalCandidate);
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['name'] ?></td>
                                    <td class="text-center"><?= $voteTotalCandidate ?></td>
                                </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="font-weight-bold text-center">Total</td>
                                    <td class="font-weight-bold text-center"><?= array_sum($arrayTotalVote) ?></td>
                                </tr>
                            </tfoot>
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