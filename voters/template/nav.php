<div class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03"
            aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a href="./" class="navbar-brand" href="#">E-Voting</a>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="./">Home</a>
                </li>
                <?php
                if (isset($_SESSION['voters-login'])) {
                    echo '<li class="nav-item">
                            <a class="nav-link" href="logout">Logout</a>
                        </li>';
                }
                ?>

            </ul>
        </div>
    </nav>
</div>