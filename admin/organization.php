<!doctype html>
<html lang="en">

<?php
include('template/head.php');
adminSession($_SESSION);
?>

<body>
    <?php include('template/nav.php') ?>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header">
                        <span class="badge badge-primary p-2">Organization List</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Organization Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Komunitas Mahasiswa Buddha</td>
                                        <td>
                                            <a href="" class="btn btn-outline-primary btn-sm">Edit</a>
                                            <a href="" class="btn btn-outline-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Komunitas Mahasiswa Buddha</td>
                                        <td>
                                            <a href="" class="btn btn-outline-primary btn-sm">Edit</a>
                                            <a href="" class="btn btn-outline-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <span class="badge badge-success p-2">Add Organization</span>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label>Organization Name</label>
                                <input type="text" class="form-control" placeholder="Please enter organization name"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Admininistrator</label>
                                <input type="text" class="form-control"
                                    placeholder="Please enter admin organization name" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" placeholder="Password for administrator"
                                    required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block float-right">Submit</button>
                        </form>
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