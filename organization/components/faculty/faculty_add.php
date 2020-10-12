<div class="col-md-4">
    <div class="card">
        <div class="card-header">
            <span class="badge badge-success p-2">Add Faculty</span>
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
                    <label>Name</label>
                    <input type="text" name="faculty-name" class="form-control" placeholder="Please enter faculty name"
                        required>
                </div>
                <button type="submit" name="btn-add-faculty" class="btn btn-info float-right">Add
                </button>
            </form>
        </div>

    </div>
</div>