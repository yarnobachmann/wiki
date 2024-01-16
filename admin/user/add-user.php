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
                $error = '';
                $name = '';
                $email = '';
                $password = '';
                $confirm_password = '';
                $role = '';

                if(isset($_POST['submit'])) {
                     // Validate name using regex to allow only letters, spaces, and hyphens
                     if (preg_match("/^[a-zA-Z\s\-']+$/", $_POST['name'])) {
                        $name = trim($_POST['name']);
                    } else {
                        echo "Invalid name format!";
                        // Handle the error here, such as setting $name to a default value or showing an error message
                    }
                    $email = trim($_POST['email']);
                    $password = trim($_POST['password']);
                    if (strlen($password) < 8) {
                        echo "Password must be at least 8 characters long!";
                        // Handle the error here
                    }
                    $confirm_password = trim($_POST['confirm_password']);
                    $role = trim($_POST['role']);
            
                    if ($password !== $confirm_password) {
                        $error = "Passwords do not match!";
                    } else {
                        $existing_email_check = $conn->prepare("SELECT * FROM users WHERE email = :email");
                        $existing_email_check->bindParam(':email', $email);
                        $existing_email_check->execute();
            
                        if ($existing_email_check->rowCount() > 0) {
                            $error = "Email already exists!";
                        } else {
                            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                echo "Invalid email format!";
                            } else {
                            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
                            $sql = "
                                INSERT INTO users (name, email, password, role)
                                VALUES (:name, :email, :hashedPassword, :role);      
                            ";
            
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':name', $name);
                            $stmt->bindParam(':email', $email);
                            $stmt->bindParam(':hashedPassword', $hashedPassword);
                            $stmt->bindParam(':role', $role);
            
                            if ($stmt->execute()) {
                                header("Location: ../../admin/user/users");
                                exit();
                            } else {
                                $error = "Data not processed!";
                            }
                        }
                        }
                    }
                }
            

            if (!empty($error)) { 
                echo "<p>$error</p>";
             } 
             ?>
            <form autocomplete="off" action="./admin/user/add-user.php" method="post">
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
                    <select value="<?php echo $roleid; ?>" name="role" id="">
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
                <div>
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="" autocomplete="off" placeholder="Your password.....">
                </div>
                <div>
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" name="confirm_password" id="" autocomplete="off" placeholder="Confirm password.....">
                </div>
                <input type="submit" name="submit" value="Submit">
            </form>
        </div>
    </div>
</main>
<?php
        include '../../partials/footer.php';
    ?>
</body>
</html>
