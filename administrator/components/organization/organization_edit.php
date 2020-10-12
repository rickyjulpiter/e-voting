<?php
$id = htmlentities(decodeURL($_GET['target']));
$sql = $pdo->prepare("SELECT * FROM organizations WHERE id = :id");
$sql->bindParam(':id', $id);
$sql->execute();
$data = $sql->fetch();
?>
<div class="col-md-4">
    <div class="card">
        <div class="card-header">
            <span class="badge badge-success p-2">Edit Organization</span>
        </div>
        <div class="card-body">
            <form method="POST">
                <?php
                message_check();
                ?>
                <div class="form-group">
                    <label>Organization Name</label>
                    <input type="text" name="organization-name" class="form-control"
                        placeholder="Please enter organization name" value="<?= $data['name'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="organization-email"
                        placeholder="Please enter organization email" value="<?= $data['email'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Admininistrator</label>
                    <input type="text" class="form-control" name="organization-username"
                        placeholder="Please enter admin organization username" value="<?= $data['username'] ?>"
                        required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="organization-password" class="form-control"
                        placeholder="Password for administrator" required>
                </div>
                <button type="submit" name="btn-edit-organizations" class="btn btn-info float-right">Edit
                </button>
            </form>
        </div>

    </div>
</div>