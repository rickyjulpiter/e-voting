<!doctype html>
<html lang="en">

<?php
date_default_timezone_set('Asia/Jakarta');
include('template/head.php');
adminOrganization($_SESSION);
$organization_id = decodeURL($_SESSION['organization_id']);
?>

<body>
    <?php include('template/nav.php') ?>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card mb-3">
                    <div class="card-header">
                        <span class="badge badge-primary p-2">Result</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Election Name</th>
                                        <th class="text-center">#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $result = $pdo->query("SELECT * FROM election WHERE organization_id = '$organization_id' AND status = 1 ORDER BY id DESC");
                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                        $date_start = $row['date_start'];
                                        $date_end = $row['date_end'];
                                        $time_start = $row['time_start'];
                                        $time_end = $row['time_end'];

                                        $date_now = date("Y-m-d");
                                        $time_now = date("h:i:s");

                                        $datetime_start = date('Y-m-d H:i:s', strtotime("$date_start $time_start"));
                                        $datetime_end = date('Y-m-d H:i:s', strtotime("$date_end $time_end"));
                                        $datetime_now = date("Y-m-d H:i:s");

                                        //election id
                                        $id = encodeURL($row['id']);
                                        if ($datetime_start <= $datetime_now && $datetime_end >= $datetime_now) {
                                            //sedang berlangsung
                                            $action = "<a href='result-detail?target=" . $id . "' class='btn btn-outline-primary btn-sm'>Show Result</a>";
                                        } elseif ($datetime_start > $datetime_now && $datetime_end > $datetime_now) {
                                            //coming soon
                                            $action = "<a href='#' class='btn btn-outline-secondary btn-sm '>Coming Soon</a>";
                                        } elseif ($datetime_start < $datetime_now && $datetime_end < $datetime_now) {
                                            //end
                                            $action = "<a href='result-detail?target=" . $id . "' class='btn btn-outline-primary btn-sm'>Show Result</a>";
                                        }
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $row['name'] ?></td>
                                        <td class="text-center">
                                            <?= $action ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
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