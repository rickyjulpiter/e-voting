<?php include('template/head.php') ?>
<div class="form-group">
    <label>Faculty</label>
    <select class="form-control" name="faculty">
        <option disabled selected value> -- select faculty -- </option>
        <?php
        $q = htmlentities(decodeURL($_GET['q']));
        $result = $pdo->query("SELECT * FROM faculty WHERE organization = '$q'");
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $name = $row['name'];
            $id = encodeURL($row['id']);
            echo "<option value='$id'>$name</option>";
        }
        ?>
    </select>
</div>