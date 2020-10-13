<!doctype html>
<html lang="en">

<?php include('template/head.php') ?>

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
                                <input type="text" class="form-control" name="username" placeholder="Username" required>
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
                            <button type="submit" class="btn btn-info btn-block" name="btn-login">Login</button>
                            <small class="float-right mt-2">or <a href="register">Register Here</a> </small>
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
            console.log("kosong");
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

</body>

</html>