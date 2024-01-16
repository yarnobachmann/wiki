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
        <?php
        $id = $_GET['id'];

        $stmt3 = $conn->query("SELECT * FROM users WHERE id='$id'");
    
        $user = $stmt3->fetch(PDO::FETCH_ASSOC); 
    
        $name = $user['name'];
        $email = $user['email'];
        $password = $user['password'];
        $confirm_password = '';
        $roleid = $user['role'];
                if(isset($_POST['submit'])) {
                    // Validate name using regex to allow only letters, spaces, and hyphens
                    if (preg_match("/^[a-zA-Z\s\-']+$/", $_POST['name'])) {
                        $name = trim($_POST['name']);
                        $email = trim($_POST['email']);
                        $password = trim($_POST['password']);
                        $confirm_password = trim($_POST['confirm_password']);
                        $role = trim($_POST['role']);

                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            echo "Invalid email format!";
                            exit();
                        } 

                        if (!empty($_POST['password'])) {
                            // User has provided a new password
                            $password = trim($_POST['password']);

                            if ($password !== $confirm_password) {
                                echo "Passwords do not match!";
                                // Handle the error here
                                exit();
                            }

                            if (strlen($password) < 8) {
                                echo "Password must be at least 8 characters long!";
                                // Handle the error here
                                exit();
                            }
                            
                            // Include the password field in the update query
                            $sql = "UPDATE `users` SET 
                                    name='$name', email='$email', password='$password', role='$role'
                                    WHERE id=$id";
                            } else {
                                // User didn't provide a new password, exclude the password field from the update query
                                $sql = "UPDATE `users` SET 
                                        name='$name', email='$email', role='$role'
                                        WHERE id=$id";
                            }
                                
                            $sql2 = "
                            UPDATE user_role
                            SET role_id = (
                                SELECT roles.id
                                FROM users
                                JOIN roles ON users.role = roles.id
                                WHERE users.email = '$email'
                            )
                            WHERE user_id = (
                                SELECT id
                                FROM users
                                WHERE email = '$email'
                            );
                            ";
                    
                            $stmt = $conn->query($sql);

                            $stmt2 = $conn->query($sql2);
                        
                            if ($stmt && $stmt2) {
                                header("Location: ../../admin/user/users");
                            }
                            else {
                                echo "Data not processed!";
                            }

                            } else {
                                echo "Invalid name format!";
                                // Handle the error here, such as setting $name to a default value or showing an error message
                            }  
                        }
            ?>
            <form autocomplete="off" action="./admin/user/edit-user?id=<?php echo $id ?>" method="post">
                <div>
                    <label for="name">Name:</label>
                    <input value="<?php echo $name; ?>" type="text" name="name" id="" autocomplete="off" placeholder="Your name.....">
                </div>
                <div>
                    <label for="email">Email:</label>
                    <input value="<?php echo $email; ?>" type="email" name="email" id="" autocomplete="off" placeholder="Your email.....">
                </div>
                <div>
                    <?php 
                    
                        $stmt = $conn->query("SELECT * FROM roles");

                        $roles = $stmt->fetchAll(PDO::FETCH_ASSOC); 
                    
                    ?>
                    <label for="role">Role:</label>
                    <select value="<?php echo $role; ?>" name="role" id="">
                        <?php 
                            foreach($roles as $role){
                                if($role['id'] == $roleid){
                                echo "<option selected='selected' value='" . $role['id'] . "'>" . $role['title'] . "</option>";
                                }else {
                                echo "<option value='" . $role['id'] . "'>" . $role['title'] . "</option>";
                                }
                            }
                        ?>
                    </select>
                </div>
                <p>Leave empty if you want to keep your old password.</p>
                <div>
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="" autocomplete="off" placeholder="Your password.....">
                </div>
                <div>
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" name="confirm_password" id="" autocomplete="off" placeholder="Confirm password.....">
                </div>
                <input type="submit" name="submit" value="Edit">
            </form>
        </div>
    </div>
</main>
<?php
        include '../../partials/footer.php';
    ?>
</body>
</html>
