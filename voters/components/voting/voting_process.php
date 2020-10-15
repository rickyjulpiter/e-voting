<div class="row">
    <div class="col-md-4 mx-auto">
        <div class="card">
            <div class="card-body">
                <?php
                message_check();
                ?>
                <small class="text-justify font-weight-light font-italic">Pemilu mengingatkan kita tidak hanya
                    tentang hak
                    tetapi
                    tanggung
                    jawab
                    organisasi dalam demokrasi.</small>
                <hr>
                <form method="POST" class="mt-2">
                    <div class="form-group">
                        <select class="form-control" name="candidate" required>
                            <option disabled selected value> -- select candidate -- </option>
                            <?php
                            $result = $pdo->query("SELECT * FROM candidate WHERE status = 1 AND election_id = '$election_id' ORDER BY id DESC");
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                $name = $row['name'];
                                $id = encodeURL($row['id']);
                                echo "<option value='$id'>$name</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-info btn-block" name="btn-choose"
                        onClick='return confirmSubmit()'>Choose Candidate</button>
                </form>
                <hr>
                <small class="float-right font-weight-light">sistempintar.com</small>
            </div>
        </div>
    </div>
</div>