<?php
    // Initialize the session
    session_start();
    // Calling database connection
    include '../../partials/databaseConnection.php';
    
    include '../../partials/auth.php';

    $stmt = $conn->query("SELECT * FROM users");

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    include '../../partials/head.php';
?>

<?php
        include '../../partials/navbarAdmin.php';
    ?>
<main>
    <div class="container">
        <div class="row">
            <button class="buttonNav"><a href="./admin/user/add-user">Add user</a></button>
            <table>
                <thead>
                    <tr>
                        <th>name</th>
                        <th>email</th>
                        <th>role</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        foreach($users as $user){
                            $id = $user['id'];
                            $name = $user['name'];
                            $email = $user['email'];
                            $role = $user['role'];

                            $stmt = $conn->query("SELECT title FROM roles WHERE id='$role'");
                            $role_result = $stmt->fetch(PDO::FETCH_ASSOC);
                            $role_title = $role_result['title']; // Fetch the role title


                            echo "<tr>";
                            echo "<th>" . $name . "</th>";
                            echo "<th>" . $email . "</th>";  
                            echo "<th>" . $role_title . "</th>"; 
                            echo "<th><button class='buttonNav'><a href='./admin/user/edit-user?id=" . $id . "'>Edit</a></button></th>";
                            echo "<th><button class='buttonNav'><a href='./admin/user/delete-user?id=" . $id . "'>Remove</a></button></th>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>

        </div>
    </div>
</main>
<?php
        include '../../partials/footer.php';
    ?>
</body>
</html>
