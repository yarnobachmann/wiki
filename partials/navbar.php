<?php session_start(); ?>
<nav>
    <div class="wrapper flexRow align spaceBetween">
            <div class="logo">
                <h1>1</h1>
            </div>
            <div class="flexRow btnGroup">
                <?php
                    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
                        echo '<button class="buttonNav"><a href="./admin/user/login">Login</a></button>';
                    }else {
                        echo '<button class="buttonNav"><a href="./admin/user/dashboard">Dashboard</a></button><button class="buttonNav"><a href="./admin/user/logout">Logout</a></button>';
                    }
                ?>
        </div>
    </div>
</nav>