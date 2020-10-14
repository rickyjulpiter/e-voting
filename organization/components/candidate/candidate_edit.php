<?php
$id = htmlentities(decodeURL($_GET['target']));
$sql = $pdo->prepare("SELECT * FROM candidate WHERE id = :id");
$sql->bindParam(':id', $id);
$sql->execute();
$data = $sql->fetch();
?>
<div class="col-md-4">
    <div class="card">
        <div class="card-header">
            <span class="badge badge-success p-2">Edit Candidate</span>
        </div>
        <div class="card-body">
            <form method="POST">
                <?php
                message_check();
                ?>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="faculty-name" class="form-control" placeholder="Please enter election name"
                        value="<?= $data['name'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Notes</label>
                    <textarea class="form-control" rows="3" name="candidate-notes"><?= $data['notes'] ?></textarea>
                </div>
                <button type="submit" name="btn-edit-faculty" class="btn btn-info float-right">Edit
                </button>
            </form>
        </div>
    </div>
</div>