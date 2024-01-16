<?php
    // Initialize the session
    session_start();
    // Calling database connection
    include '../../partials/databaseConnection.php';

 
    // Check if the user is already logged in, if yes then redirect him to welcome page
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        header("location: ./dashboard");
        exit;
    }

    $email = "";
    $password = "";
    $emailErr = "";
    $passwordErr = "";
    $loginErr = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
 
        // Check if username is empty
        if(empty(trim($_POST["email"]))){
            $emailErr = "Please enter email.";
        } else{
            $email = trim($_POST["email"]);
        }

        // Check if password is empty
        if(empty(trim($_POST["password"]))){
            $password_err = "Please enter your password.";
        } else{
            $password = trim($_POST["password"]);
        }

        // Validate credentials
        if(empty($username_err) && empty($password_err)){
            // Prepare a select statement
            $sql = "SELECT id, email, password FROM users WHERE email = :email";
            
            if($stmt = $conn->prepare($sql)){
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(':email', $param_email, PDO::PARAM_STR);
                
                // Set parameters
                $param_email = $email;
                
                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    // Check if username exists, if yes then verify password
                    if($stmt->rowCount() == 1){                    
                        // Fetch result
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        $id = $row['id'];
                        $hashed_password = $row['password'];
        
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;                            
                            var_dump($_SESSION);
                            // Redirect user to welcome page
                            header("location: dashboard");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid email or password.";
                        }
                    } else{
                        // Username doesn't exist, display a generic error message
                        $login_err = "Invalid email or password.";
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
        
                // Close statement
                unset($stmt);
            }
        }
    }
    include '../../partials/head.php';
?>
<body>
<?php
        include '../../partials/navbarAdmin.php';
    ?>
<main>
    <div class="container">
        <div class="row">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

        <?php 
        if(!empty($loginErr)){
            echo '<div>' . $loginErr . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="flexRow column">
                <label for="email">Email:</label>
                <input type="email" name="email" <?php echo (!empty($emailErr)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <span><?php echo $emailErr; ?></span>
            </div>    
            <div class="flexRow column">
                <label for="password">Password</label>
                <input type="password" name="password" <?php echo (!empty($passwordErr)) ? 'is-invalid' : ''; ?>">
                <span><?php echo $passwordErr; ?></span>
            </div>
            <div>
                <input class="buttonNav" type="submit" value="Login">
            </div>
        </form>
        
        </main>
        <?php
        include '../../partials/footer.php';
    ?>
</body>
</html>