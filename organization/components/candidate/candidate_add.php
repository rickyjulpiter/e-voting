<div class="col-md-4">
    <div class="card">
        <div class="card-header">
            <span class="badge badge-success p-2">Add Candidate</span>
        </div>
        <div class="card-body">
            <form method="POST">
                <?php
                message_check();
                ?>
                <div class="form-group">
                    <label>Candidate Name</label>
                    <input type="text" name="candidate-name" class="form-control"
                        placeholder="Please enter candidate name" required>
                </div>
                <div class="form-group">
                    <label>Notes</label>
                    <textarea class="form-control" rows="3" name="candidate-notes"></textarea>
                </div>
                <div class="form-group">
                    <label>Election</label>
                    <select class="form-control" name="candidate-election">
                        <option disabled selected value> -- select election -- </option>
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
                <button type="submit" name="btn-add-candidate" class="btn btn-info float-right">Add
                </button>
            </form>
        </div>

    </div>
</div>