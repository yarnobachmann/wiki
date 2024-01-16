<?php
    // Initialize the session
    session_start();
    // Calling database connection
    include '../../partials/databaseConnection.php';
    
    include '../../partials/auth.php';

    $stmt = $conn->query("SELECT * FROM subject_parts");

    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    include '../../partials/head.php';
?>

<?php
        include '../../partials/navbarAdmin.php';
    ?>
<main>
    <div class="container">
        <div class="row">
            <button class="buttonNav"><a href="./admin/user/add-post">Add post</a></button>
            <table>
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Tutorial</th>
                        <th>Subtitle</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        foreach($posts as $post){
                            $id = $post['id'];
                            $subject_id = $post['subject_id'];
                            $subject_part = $post['subject_part'];
                            $subject_subtitle = $post['subject_subtitle'];
                            
                            $stmt = $conn->query("SELECT title FROM subjects WHERE id='$subject_id'");
                            $subject_result = $stmt->fetch(PDO::FETCH_ASSOC);
                            $subject_title = $subject_result['title']; // Fetch the role title

                            echo "<tr>";
                            echo "<th>" . $subject_title. "</th>";
                            echo "<th>" . $subject_part . "</th>";  
                            echo "<th>" . $subject_subtitle . "</th>"; 
                            echo "<th><button class='buttonNav'><a href='./admin/user/edit-post?id=" . $id . "'>Edit</a></button></th>";
                            echo "<th><button class='buttonNav'><a href='./admin/user/delete-post?id=" . $id . "'>Remove</a></button></th>";
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
