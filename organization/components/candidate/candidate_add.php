<div class="col-md-4">
    <div class="card">
        <div class="card-header">
            <span class="badge badge-success p-2">Add Candidate</span>
        </div>
        <div class="card-body">
            <form method="POST" class="mb-4">
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
                <button type="submit" name="btn-add-candidate" class="btn btn-info btn-block">Add
                </button>
            </form>
            <hr>

            <div class="card">
                <div class="card-body">
                    <h3 class="text-center mt-2 card-title"> ~ Voters as Candidate ~</h3>
                    <small class="font-italic">Fitur ini untuk dapat anda gunakan apabila pemilih dapat menjadi kandidat
                        yang akan dipilih.
                        Adapun pemilih yang ditambahkan yaitu pemilih yang sudah diverifikasi.</small>
                    <hr>
                    <form method="POST">
                        <?php
                        message_check();
                        ?>
                        <div class="form-group">
                            <label>Election</label>
                            <select class="form-control" name="election">
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
                        <button type="submit" name="btn-add-voters-as-candidate" class="btn btn-success btn-block">Add
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>