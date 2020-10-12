<div class="col-md-4">
    <div class="card">
        <div class="card-header">
            <span class="badge badge-success p-2">Add Organization</span>
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
                    <label>Organization Name</label>
                    <input type="text" name="organization-name" class="form-control"
                        placeholder="Please enter organization name" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="organization-email"
                        placeholder="Please enter organization email" required>
                </div>
                <div class="form-group">
                    <label>Admininistrator</label>
                    <input type="text" class="form-control" name="organization-username"
                        placeholder="Please enter admin organization username" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="organization-password" class="form-control"
                        placeholder="Password for administrator" required>
                </div>
                <button type="submit" name="btn-add-organizations" class="btn btn-info float-right">Add
                </button>
            </form>
        </div>

    </div>
</div>