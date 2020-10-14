<?php
$id = htmlentities(decodeURL($_GET['target']));
$query = "SELECT A.name, A.notes, A.id, B.name AS electionName, B.id AS electionID FROM candidate A, election B WHERE A.organization_id = '$organization_id' AND A.status = 1 AND A.election_id = B.id AND A.id = :id";
$sql = $pdo->prepare($query);
// echo $query;
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
                    <input type="text" name="candidate-name" class="form-control"
                        placeholder="Please enter election name" value="<?= $data['name'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Notes</label>
                    <textarea class="form-control" rows="3" name="candidate-notes"><?= $data['notes'] ?></textarea>
                </div>
                <div class="form-group">
                    <label>Election</label>
                    <select class="form-control" name="candidate-election">
                        <option value="<?= encodeURL($data['id']) ?>"><?= $data['electionName'] ?></option>
                        <?php
                        $query = "SELECT * FROM election WHERE organization_id = '$organization_id' AND status = 1 ORDER BY id DESC";
                        $result = $pdo->query($query);
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            $name = $row['name'];
                            $id = encodeURL($row['id']);
                            echo "<option value='$id'>$name</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" name="btn-edit-candidate" class="btn btn-info float-right">Edit
                </button>
            </form>
        </div>
    </div>
</div>