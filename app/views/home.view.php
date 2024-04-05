<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= ROOT ?>/public/assests/css/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>Monstergram</title>
</head>
<body>
    <nav class="navbar nav-container">
        <a href="home" class="navbar-brand">Monstergram</a>
        <ul class="navbar-nav">
            <li>
                <p class="greeting">
                    Hello <?php echo $_SESSION['username']; ?>
                </p>
            </li>
            <li><a class="logout-btn" href="CreatePost" class="nav-link">Create Post +</a></li>
            <li class="nav-item"><a href="profile" class="nav-link">Profile</a></li>
            <li class="nav-item"><a href="home" class="nav-link">Home</a></li>
            <li><a class="logout-btn" href="logout" class="nav-link">Logout</a></li>
        </ul>
    </nav>
    <div class="posts-container" id="load-more">
    </div>
    <div class="button-container" style="display: none;">
        <button id="load-more-btn">Load More</button>
    </div>
</body>
</html>
<script src="<?php echo ROOT?>/public/assests/javascript/script.js"></script>