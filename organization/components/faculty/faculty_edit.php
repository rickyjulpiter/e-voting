<?php
$id = htmlentities(decodeURL($_GET['target']));
$sql = $pdo->prepare("SELECT * FROM faculty WHERE id = :id");
$sql->bindParam(':id', $id);
$sql->execute();
$data = $sql->fetch();
?>
<div class="col-md-4">
    <div class="card">
        <div class="card-header">
            <span class="badge badge-success p-2">Edit Faculty</span>
        </div>
        <div class="card-body">
            <form method="POST">
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                }
                ?>
                <div class="form-group">
                    <label>Faculty Name</label>
                    <input type="text" name="faculty-name" class="form-control" placeholder="Please enter faculty name"
                        value="<?= $data['name'] ?>" required>
                </div>
                <button type="submit" name="btn-edit-faculty" class="btn btn-info float-right">Edit
                </button>
            </form>
        </div>
    </div>
</div>