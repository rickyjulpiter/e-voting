<!doctype html>
<html lang="en">

<?php include('template/head.php') ?>

<?php

if (isset($_POST['btn-register'])) {
    $username = htmlentities($_POST['username']);
    $name = htmlentities($_POST['name']);
    $email = htmlentities($_POST['email']);
    $phone = htmlentities($_POST['phone']);
    $organization_id = htmlentities(decodeURL($_POST['organization']));
    $faculty_id = htmlentities(decodeURL($_POST['faculty']));
    $password = htmlentities(hashSHA384($_POST['password']));

    $query = "INSERT INTO voters (username, password, name, email, phone, faculty_id, organization_id) VALUES (:username, :password, :name, :email, :phone, :faculty_id, :organization_id)";

    // $s = "INSERT INTO voters (username, password, name, email, phone, faculty_id, organization_id) VALUES ('$username', '$password', '$name', '$email', '$phone', $faculty_id, $organization_id)";

    $sql = $pdo->prepare($query);
    $sql->bindParam(':username', $username);
    $sql->bindParam(':name', $name);
    $sql->bindParam(':email', $email);
    $sql->bindParam(':phone', $phone);
    $sql->bindParam(':organization_id', $organization_id);
    $sql->bindParam(':faculty_id', $faculty_id);
    $sql->bindParam(':password', $password);
    if ($sql->execute()) {
        message_success("Successfuly Register");
        header("Location: ./");
        exit();
    } else {
        message_failed("Failed Register");
        header("Location: register");
        exit();
    }
}

?>

<body>
    <?php include('template/nav.php') ?>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6 mb-2">
                <img src="assets/sistempintar.png" class="card-img img-fluid" alt="...">
            </div>
            <div class="col-md-4 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h4 class="p-2 text-center">Register</h4>
                        <form method="POST">
                            <?php
                            message_check();
                            ?>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Username" required>
                                <div id="response" class="ml-1"></div>
                            </div>
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Name" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="number" min="0" class="form-control" name="phone"
                                    placeholder="Phone Number" required>
                            </div>
                            <div class="form-group">
                                <label>Organization</label>
                                <select onchange="getOrg(this.value)" class="form-control" name="organization">
                                    <option disabled selected value> -- select organization -- </option>
                                    <?php
                                    $result = $pdo->query("SELECT * FROM organizations WHERE status = 1 ORDER BY id DESC");
                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                        $name = $row['name'];
                                        $id = encodeURL($row['id']);
                                        echo "<option value='$id'>$name</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div id="faculty"></div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" placeholder="Password" name="password"
                                    required>
                            </div>
                            <button type="submit" class="btn btn-info btn-block" name="btn-register">Register</button>
                            <small class="float-right mt-2">or <a href="./">Login Here</a> </small>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('template/script.php') ?>
    <script>
    function getOrg(str) {
        if (str == "") {
            document.getElementById("faculty").innerHTML = "";
            return;
        } else {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("faculty").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "getFaculty.php?q=" + str, true);
            xmlhttp.send();
        }
    }
    </script>

    <script>
    $(document).on('keyup', '#username', function() {
        if ($('#username').val() != '' && $('#username').val().length >= 8) {
            $('#val').val("0");
            $.ajax({
                url: "checkUsername.php",
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function(data) {
                    console.log(data)
                    if (data == 0) {
                        $('#val').val("1");
                        $('#response').html(
                            '<p style="color: #339966;"><b>Your username is available.</b></p>');
                    } else {
                        $('#val').val("0");
                        $('#response').html(
                            '<p style="color: #ff0000;"><b>Your username is not available.</b></p>'
                        );
                    }
                }
            })
        } else {
            var length = $('#username').val().length
            $('#val').val("0");
            $('#response').html(
                '<small class ="text-danger" ><b>The minimum length of username is 8 character.</b></small>'
            );
        }
    });
    </script>

</body>

</html>