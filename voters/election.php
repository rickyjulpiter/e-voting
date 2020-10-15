<!doctype html>
<html lang="en">

<?php
include('template/head.php');
votersOrganization($_SESSION);
$organization_id = decodeURL($_SESSION['organization_id']);
?>

<body>
    <?php include('template/nav.php') ?>
    <div class="container mt-4">
        <h3 class="text-center"> - Choose Election - </h3>
        <hr>
        <div class="row">
            <?php
            $query = "SELECT * FROM election WHERE organization_id = '$organization_id' ORDER BY id DESC";
            $result = $pdo->query($query);
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $date_start = $row['date_start'];
                $date_end = $row['date_end'];
                $time_start = $row['time_start'];
                $time_end = $row['time_end'];

                $date_now = date("Y-m-d");
                $time_now = date("h:i:s");

                $datetime_start = date('Y-m-d H:i:s', strtotime("$date_start $time_start"));
                $datetime_end = date('Y-m-d H:i:s', strtotime("$date_end $time_end"));
                $datetime_now = date('Y-m-d H:i:s', strtotime("$date_now $time_now"));

                if ($datetime_start <= $datetime_now && $datetime_end >= $datetime_now) {
                    //sedang berlangsung
                    $election_status = "Live";
                    $class = "info";
                    $href = "voting?target=" . encodeURL("apa lihat-lihat?") . "&message=" . encodeURL("udahlah gausah di cari tau lagi") . "&eid=" . encodeURL($row['id']) . "&id=" . encodeURL(hashSHA384("Sistem Pintar"));
                } elseif ($datetime_start > $datetime_now && $datetime_end > $datetime_now) {
                    //coming soon
                    $election_status = "Coming Soon";
                    $class = "primary";
                    $href = "#";
                } elseif ($datetime_start < $datetime_now && $datetime_end < $datetime_now) {
                    //end
                    $election_status = "End";
                    $class = "secondary";
                    $href = "#";
                }
            ?>
            <div class="col-md-4 mb-1">
                <div class="card mb-3">
                    <div class="card-body">
                        <?= $row['name'] ?>
                        <span class="badge badge-<?= $class ?> float-right font-italic mt-1 text-white">
                            <a href="<?= $href ?>" class="text-white"><?= $election_status ?></a>
                        </span>
                    </div>

                </div>
            </div>
            <?php } ?>
        </div>
    </div>

    <?php include('template/script.php') ?>

</body>

</html>