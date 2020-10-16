<!doctype html>
<html lang="en">

<?php
include('template/head.php');
votersOrganization($_SESSION);
$organization_id = decodeURL($_SESSION['organization_id']);

if (isset($_GET['eid'])) {
    $election_id = decodeURL($_GET['eid']);
}
$voters_id = decodeURL($_SESSION['voters_id']);

if (isset($_POST['btn-choose'])) {
    $candidate_id = decodeURL($_POST['candidate']);
    $faculty_id = decodeURL($_SESSION['faculty_id']);

    $max_voters = getMaxVotersFaculty($faculty_id, $organization_id);
    $count_voters_now = getCountVotersNow($faculty_id, $election_id, $organization_id);

    if ($max_voters <= $count_voters_now) {
        $query = "INSERT INTO voting (voters_id, candidate_id, election_id, status) VALUES (:voters_id, :candidate_id, :election_id, :status)";
        $status = 0;
    } elseif ($max_voters > $count_voters_now) {
        $query = "INSERT INTO voting (voters_id, candidate_id, election_id, status) VALUES (:voters_id, :candidate_id, :election_id, :status)";
        $status = 1;
    }
    $q = "INSERT INTO voting (voters_id, candidate_id, election_id, status) VALUES ('$voters_id', '$candidate_id', '$election_id', '$status')";
    $sql = $pdo->prepare($query);
    $sql->bindParam(':voters_id', $voters_id);
    $sql->bindParam(':candidate_id', $candidate_id);
    $sql->bindParam(':election_id', $election_id);
    $sql->bindParam(':status', $status);
    if ($sql->execute()) {
        header("Location: " . urlTrack());
        exit();
    } else {
        message_failed("Something not working, please contact administrator");
        header("Location: " . urlTrack());
        exit();
    }
}
?>

<body>
    <?php include('template/nav.php') ?>
    <div class="container mt-4">
        <h3 class="text-center"> ~ Choose Candidate ~ </h3>
        <hr>

        <?php
        $query = "SELECT * FROM voting WHERE election_id = '$election_id' AND voters_id = '$voters_id'";
        $sql = $pdo->prepare($query);
        if ($sql->execute()) {
            $data = $sql->fetch();
            if ($data > 0) {
                include('components/voting/voting_finish.php');
            } else {
                include('components/voting/voting_process.php');
            }
        } else {
        }
        ?>

    </div>

    <?php include('template/script.php') ?>
    <script>
    function confirmSubmit() {
        var agree = confirm("Are you sure?");
        if (agree)
            return true;
        else
            return false;
    }
    </script>

</body>

</html>