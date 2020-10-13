<!DOCTYPE html>
<html lang="en">
<?php include('template/head.php') ?>

<body>
    <select id="org" onchange="getOrg(this)" class="form-control" name="organization">
        <option disabled selected value> -- select organization -- </option>
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
</body>

</html>