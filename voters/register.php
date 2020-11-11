<!doctype html>
<html lang="en">

<?php include('template/head.php') ?>

<?php
if (isset($_POST['btn-register'])) {
    $username = htmlentities(string_formatter($_POST['name']));
    $name = htmlentities($_POST['name']);
    $email = htmlentities($_POST['email']);
    $phone = htmlentities($_POST['phone']);
    $organization_id = htmlentities(decodeURL($_POST['organization']));
    $faculty_id = htmlentities(decodeURL($_POST['faculty']));
    // $password = htmlentities(hashSHA384($_POST['password']));

    $randomPassword = rand(272819, 2838958192);
    $password = hashSHA384($randomPassword);

    $sql = $pdo->prepare("SELECT * FROM voters WHERE email = :email");
    $sql->bindParam(':username', $email);
    $sql->execute();
    $data = $sql->fetch(PDO::FETCH_ASSOC);
    if ($data > 0) {
        message_failed("Email already taken");
        header("Location: register");
        exit();
    } else {
        $emailDestination = $email;
        $emailFrom = "e-voting@sistempintar.com";
        $subject = "E-Voting: Voter's Code";
        $message = "Email: " . $email . " | Password: " . $randomPassword;

        // send email
        try {
            if (mail($emailDestination, $subject, $message)) {
                $query = "INSERT INTO voters (username, password, name, email, phone, faculty_id, organization_id) VALUES (:username, :password, :name, :email, :phone, :faculty_id, :organization_id)";

                $sql = $pdo->prepare($query);
                $sql->bindParam(':username', $username);
                $sql->bindParam(':name', $name);
                $sql->bindParam(':email', $email);
                $sql->bindParam(':phone', $phone);
                $sql->bindParam(':organization_id', $organization_id);
                $sql->bindParam(':faculty_id', $faculty_id);
                $sql->bindParam(':password', $password);
                if ($sql->execute()) {
                    message_success("Successfuly Register, check your email for password account");
                    header("Location: ./");
                    exit();
                } else {
                    message_failed("Failed Register");
                    header("Location: register");
                    exit();
                }
            } else {
                message_failed("Failed Register");
                header("Location: register");
                exit();
            }
        } catch (Exception $e) {
            message_failed("Failed Register");
            header("Location: register");
            exit();
        }
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
                            <!-- <div class="form-group">
                                <label>Username</label>
                                <input type="hidden" class="form-control" id="username" name="username"
                                    placeholder="Username" autocomplete="off" required>
                                <div id="result"></div>
                            </div> -->
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Name" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                    required>
                                <div id="result"></div>
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="number" min="0" class="form-control" name="phone"
                                    placeholder="Phone Number" required>
                            </div>
                            <div class="form-group">
                                <label>Organization</label>
                                <select onchange="getOrg(this.value)" class="form-control" name="organization" required>
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
                            <button type="submit" id="btn-register" class="btn btn-info btn-block"
                                name="btn-register">Register</button>
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

    <script type="text/javascript">
    $(document).ready(function() {
        $('#email').keyup(function() {
            var uname = $('#email').val();
            if (uname == 0) {
                $('#result').text('');
            } else {
                $.ajax({
                    url: 'checkEmail.php',
                    type: 'POST',
                    data: 'email=' + uname,
                    success: function(hasil) {
                        if (hasil > 0) {
                            document.getElementById("result").innerHTML = `
                            <small class="text-danger">Email already taken</small>
                            `
                            document.getElementById("btn-register").disabled = true;
                        } else {
                            document.getElementById("result").innerHTML = `
                            <small class="text-success">Email is avalaible</small>
                            `
                            document.getElementById("btn-register").disabled = false;
                        }
                    }
                });
            }
        });
    });
    </script>

</body>

</html>