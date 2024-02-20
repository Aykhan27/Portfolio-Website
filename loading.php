<?php
    require 'config.php';

    if (isset($_GET['id'])) {
        $projectId = $_GET['id'];
    } else {
        header('Location: index.php');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="<?php echo $lang;?>">
	<head>
		<meta charset="<?php echo $lang['charset']; ?>">
		<meta name="viewport" content="<?php echo $lang['viewport']; ?>">
		<title>Loading Page</title>
        <link rel="stylesheet" href="/css/loading.css">
    </head>
    <body>
        <div class="loading-container">
            <div class="loading-animation">
                <?php
                    $numberOfBoxes = 4;
                    $numberOfStars = 7;

                    for ($i = 1; $i <= $numberOfBoxes; $i++) {
                        echo "<div class='box-of-star$i'>";
                        for ($j = 1; $j <= $numberOfStars; $j++) {
                            echo "<div class='star star-position$j'></div>";
                        }
                        echo "</div>";
                    }
                ?>
                <div data-js="astro" class="astronaut">
                    <div class="head"></div>
                    <div class="arm arm-left"></div>
                    <div class="arm arm-right"></div>
                    <div class="body">
                        <div class="panel"></div>
                    </div>
                    <div class="leg leg-left"></div>
                    <div class="leg leg-right"></div>
                    <div class="schoolbag"></div>
                </div>
            </div>
        </div>
        <script>
            setTimeout(function () {
                const projectId = <?php echo $projectId; ?>;
                window.location.href = '/project.php?id=' + projectId;
            }, 1500);
        </script>
    </body>
</html>