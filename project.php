<?php
	require 'config.php';
	$selectedTheme = isset($_COOKIE['selectedTheme']) ? $_COOKIE['selectedTheme'] : 'light-mode';
	$selectedLanguage = isset($_COOKIE['selectedLanguage']) ? $_COOKIE['selectedLanguage'] : $lang['languages'];

	// Check if the user has manually changed the language
	if (isset($_GET['lang'])) {
		$selectedLanguage = $_GET['lang'];
		setcookie('selectedLanguage', $selectedLanguage, time() + 3600 * 24 * 30); // Store the language preference for 30 days
	}

	// Check if the user has manually changed the theme
	if (isset($_GET['theme'])) {
		$selectedTheme = $_GET['theme'];
		setcookie('selectedTheme', $selectedTheme, time() + 3600 * 24 * 30); // Store the theme preference for 30 days
	}
	if (isset($_GET['id'])) {
		$id = $_GET['id'];

		$stmt = $pdo->prepare("SELECT * FROM project WHERE id = :id");
		$stmt->execute(['id' => $id]);
		$project = $stmt->fetch();
		$view_count = $project['view'];

		$view_count++;

		$stmt = $pdo->prepare("UPDATE project SET view = :view_count WHERE id = :id");
		$stmt->execute(['view_count' => $view_count, 'id' => $id]);

		$project['view'] = $view_count;
	} else {
		header('Location: index.php');
		exit();
	}
?>

<!DOCTYPE html>
<html lang="<?php echo $lang['lang']; ?>">
	<head>
		<meta charset="<?php echo $lang['charset']; ?>">
		<meta name="viewport" content="<?php echo $lang['viewport']; ?>">
		<title><?php echo $lang['portfolio']; ?></title>
		<link rel="stylesheet" href="/css/store.css">
	</head>
	<body  id="theme" class="<?php echo $selectedTheme; ?>">
		<div class="navbar">
			<a href="/index.php">
				<lord-icon src="https://cdn.lordicon.com/cswohhwz.json" trigger="hover" stroke="bold" colors="primary:#121331,secondary:#ffffff" style="width:40px;height:40px"> </lord-icon>
			</a>
			<div class="dropdown">
				<a href="/index.php#projects" class="dropbtn"><?php echo $lang['projects']; ?></a>
				<div class="dropdown-content">
					<?php
						$stmt = $pdo->query("SELECT * FROM `project`");
						while ($row = $stmt->fetch()) {
							echo "<a href='loading.php?id=" . $row['id'] . "'> " . $row['name'] . "</a>";
						}
					?>
				</div>
			</div>
			<a href="/index.php#contact"><?php echo $lang['contact']; ?></a>
			<a href="?id=<?php echo $id?>&lang=<?php echo $lang['languages']; ?>"><span style="text-transform: uppercase;"><?php echo $lang['languages']; ?></span></a>
			<label class="switch">
				<input type="checkbox" id="themeCheckbox" <?php echo $selectedTheme === 'light-mode' ? 'checked' : ''; ?>>
				<span class="slider"></span>
			</label>
			<div class="stars">
				<span style="--i: 31" class="star"></span>
				<span style="--i: 12" class="star"></span>
				<span style="--i: 57" class="star"></span>
				<span style="--i: 93" class="star"></span>
				<span style="--i: 23" class="star"></span>
				<span style="--i: 70" class="star"></span>
				<span style="--i: 6" class="star"></span>
			</div>
		</div>
		<section id="project-details">
			<div class="project-container">
				<div class="project-details">
					<h1><?php echo $project['name']; ?></h1>
					<?php
						if ($_GET['lang'] != 'fr') { echo "<p>" . $project['descriptionEN'] . "</p>"; } 
						else { echo "<p>" . $project['descriptionFR'] . "</p>"; }
					?>
					<div class="project-meta">
						<div class="project-date">
							<span>Date:</span> <?php echo $project['pubdate']; ?>
						</div>
						<div class="project-views">
							<span><?php echo $lang['view']; ?>:</span> <?php echo $project['view']; ?>
						</div>
					</div>
				</div>
				<div class="project-image">
					<img src="data:image/jpg;base64,<?php echo base64_encode($project['img']); ?>" alt="<?php echo $project['id']; ?>">
				</div>
			</div>
		</section>
		<footer>
			<p>&copy; <?php echo date('Y'); ?> Hasanli Ayhan</p>
		</footer>
		<script>
			const body = document.getElementById('theme');
			const themeCheckbox = document.getElementById('themeCheckbox');
			themeCheckbox.addEventListener('change', function () {
				body.classList.toggle('light-mode');
				const selectedTheme = body.classList.contains('light-mode') ? 'light-mode' : '';
				document.cookie = 'selectedTheme=' + selectedTheme + '; max-age=' + 3600 * 24 * 30;
			});
		</script>
		<script src="https://cdn.lordicon.com/lordicon-1.1.0.js" defer></script>
	</body>
</html>