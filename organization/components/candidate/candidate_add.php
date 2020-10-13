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
                <button type="submit" name="btn-add-candidate" class="btn btn-info float-right">Add
                </button>
            </form>
        </div>

    </div>
</div>