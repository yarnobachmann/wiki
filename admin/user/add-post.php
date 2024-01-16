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
                $subject_part = '';
                $subject_subtitle = '';
                $editor_content = '';
                $subject_id = '';

                if(isset($_POST['submit'])) {
                    $subject_part = trim($_POST['subject_part']);
                    $subject_subtitle = trim($_POST['subject_subtitle']);
                    $editor_content = trim($_POST['editor_content']);
                    $subject_id = trim($_POST['subject_id']);
                           
                    $sql = "INSERT INTO subject_parts (subject_part, subject_subtitle, post, subject_id) 
                    VALUES (:subject_part, :subject_subtitle, :editor_content, :subject_id)";

                    
                    $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':subject_part', $subject_part);
                            $stmt->bindParam(':subject_subtitle', $subject_subtitle);
                            $stmt->bindParam(':editor_content', $editor_content);
                            $stmt->bindParam(':subject_id', $subject_id);
                
                    if ($stmt->execute()) {
                        header("Location: ../../admin/user/posts");
                        exit();
                    } else {
                        $error = "Data not processed!";
                    }
                }
             ?>
            <form autocomplete="off" action="./admin/user/add-post.php" method="post">
                <div>
                    <label for="subject_part">Subject:</label>
                    <input value="<?php echo $subject_part; ?>" type="text" name="subject_part" id="" autocomplete="off" placeholder="Your name.....">
                </div>
                <div>
                    <label for="subject_subtitle">Subtitle:</label>
                    <input value="<?php echo $subject_subtitle; ?>" type="text" name="subject_subtitle" id="" autocomplete="off" placeholder="Your email.....">
                </div>
                <div>
                    <?php 
                    
                        $stmt2 = $conn->query("SELECT * FROM subjects");

                        $subjects = $stmt2->fetchAll(PDO::FETCH_ASSOC); 
                  
                    ?>
                    <label for="subject_id">Main subject:</label>
                    <select value="<?php echo $subject_id; ?>" name="subject_id" id="">
                        <?php 
                            foreach($subjects as $subject){
                                if($subject['id'] == $subjectid){
                                echo "<option selected='selected' value='" . $subject['id'] . "'>" . $subject['title'] . "</option>";
                                }else {
                                echo "<option value='" . $subject['id'] . "'>" . $subject['title'] . "</option>";
                                }
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="editor_content">Post:</label>
                    <textarea name="editor_content" id="editor"></textarea>
                    <script>
                        ClassicEditor
                            .create(document.querySelector('#editor'))
                            .catch(error => {
                                console.error(error);
                            });
                            
                    </script>
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
