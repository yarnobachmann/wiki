<?php
    $styles = '<link rel="stylesheet" href="./css/prism.css">
    <script src="./js/prism.js"></script>';

    include './partials/head.php';
?>
<body>
    <?php
        include './partials/databaseConnection.php';
    
        include './partials/navbar.php';
    ?>
    <main>
        <div class="sidebar fc">
            <div class="sideContainer">
                <h3>Tutorials</h3>
                <ul class="noPadding">    
                    <?php
                        $sql = "SELECT subjects.id, subjects.title, subject_parts.subject_part, subject_parts.subject_subtitle, subject_parts.post
                        FROM subjects
                        LEFT JOIN subject_parts ON subjects.id = subject_parts.subject_id";
               
                        $stmt = $conn->query($sql);
                        $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        $currentSubject = null;

                        foreach ($subjects as $subject) {
                            if ($currentSubject !== $subject['id']) {
                                // If the subject ID changes, start a new subject
                                if ($currentSubject !== null) {
                                    // Close the previous subject if it exists
                                    echo "</ul></li>";
                                }
                                // Open a new subject
                                echo "<p>" . $subject['title'] . "</p><ul>";
                                $currentSubject = $subject['id'];
                            }
                            // Display the subject part for the current subject
                            echo "<li><a href='#" . $subject['subject_part'] . "'>" . $subject['subject_part'] . "</a></li>";
                        }
                        // Close the last subject
                        if ($currentSubject !== null) {
                            echo "</ul></li>";
                        }
                    ?>
                </div>
            </div>
        <div class="main">
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['editor_content'])) {
                    $content = $_POST['editor_content'];
                    // Process the content here as needed
                    // For example, you can display it:
                    echo "<h3>Submitted Content:</h3>";
                    echo "<pre>" . $content . "</pre>";
                }
            }
        ?>
       <div class="container">
    <div class="row">
        <?php
        $currentSubject = null;
        foreach ($subjects as $subject) {
            if ($currentSubject !== $subject['id']) {
                if ($currentSubject !== null) {
                    // Close the previous subject's content
                    echo '</div></div>';
                }
                // Start a new subject
                echo '<div class="subject">';
                echo "<h1>" . $subject['title'] . "</h1>";
                $currentSubject = $subject['id'];
            }
            // Display subtitle for each subject part
            echo "<h2>" . $subject['subject_part'] . "</h2>";
            echo "<h3>" . $subject['subject_subtitle'] . "</h3>";
            // For each subject part
            echo '<div class="card" id="' . $subject["subject_part"] . '">';
            echo $subject['post'];
            echo '</div>';
        }
        // Close the last subject's content
        if ($currentSubject !== null) {
            echo '</div></div>';
        }
        ?>
    </div>
</div>



    </div>
</main>
<?php
    include './partials/footer.php';
?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    const codeBlocks = document.querySelectorAll('.code-toolbar pre');

    codeBlocks.forEach(function(codeBlock) {
    const codeLines = codeBlock.textContent.trim().split('\n');

    const lineNumbersWrapper = document.createElement('div');
    lineNumbersWrapper.classList.add('line-numbers');

    codeLines.forEach(function(_, index) {
    const lineNumber = document.createElement('span');
    lineNumber.classList.add('line-number');
    lineNumber.textContent = index + 1;
    lineNumbersWrapper.appendChild(lineNumber);
});

    codeBlock.parentNode.insertBefore(lineNumbersWrapper, codeBlock);
    });
});
</script>
</body>
</html>