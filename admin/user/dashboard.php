<?php
    // Initialize the session
    session_start();
    // Calling database connection
    include '../../partials/databaseConnection.php';

    include '../../partials/auth.php';
   
    include '../../partials/head.php';
?>

<body>
    <?php
        include '../../partials/navbarAdmin.php';
    ?>
<main>
    <div class="container">
        <div class="row">
            <h1>Logged in!</h1>
            <button class="buttonNav"><a href="./admin/user/users">view users</a></button>
            <button class="buttonNav"><a href="./admin/user/posts">view posts</a></button>
        </main>
        <?php
        include '../../partials/footer.php';
        ?>
</body>
</html>