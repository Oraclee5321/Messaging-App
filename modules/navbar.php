<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href=#>Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="php-functions/log-out.php">Log Out</a>
                </li>
                <li class="navbar-text">
                    <?php
                    if (isset($_SESSION['username'])) {
                    echo "Welcome, " . $_SESSION['username'];
                    } else {
                    echo "Welcome, Guest!";
                    }
                    ?>
                </li>
            </ul>
        </div>
    </div>
</nav>