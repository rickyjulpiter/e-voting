<div class="col-md-4">
    <div class="card">
        <div class="card-header">
            <span class="badge badge-success p-2">Add Election</span>
        </div>
        <div class="card-body">
            <form method="POST">
                <?php
                message_check();
                ?>
                <div class="form-group">
                    <label>Election Name</label>
                    <input type="text" name="election-name" class="form-control"
                        placeholder="Please enter election name" required>
                </div>
                <div class="form-group">
                    <label>Date Start</label>
                    <input type="date" name="date_start" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Time Start</label>
                    <input type="time" name="time_start" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Date End</label>
                    <input type="date" name="date_end" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Time End</label>
                    <input type="time" name="time_end" class="form-control" required>
                </div>
                <button type="submit" name="btn-add-election" class="btn btn-info float-right">Add
                </button>
            </form>
        </div>

    </div>
</div>