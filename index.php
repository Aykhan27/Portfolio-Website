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
?>

<!DOCTYPE html>
<html lang="<?php echo $lang['lang']; ?>">
	<head>
		<meta charset="<?php echo $lang['charset']; ?>">
		<meta name="viewport" content="<?php echo $lang['viewport']; ?>">
		<title><?php echo $lang['portfolio']; ?></title>
		<link rel="stylesheet" href="/css/style.css">
		<!-- font icons -->
		<link rel="stylesheet" href="/css/themify-icons/css/themify-icons.css">
	</head>
	<body id="theme" class="<?php echo $selectedTheme; ?>">
		<div class="navbar">
			<a href="#home">
				<lord-icon src="https://cdn.lordicon.com/cswohhwz.json" trigger="hover" stroke="bold" colors="primary:#121331,secondary:#ffffff" style="width:40px;height:40px"> </lord-icon>
			</a>
			<div class="dropdown">
				<a href="#projects" class="dropbtn"><?php echo $lang['projects']; ?></a>
				<div class="dropdown-content">
					<?php
						$stmt = $pdo->query("SELECT * FROM `project`");
						while ($row = $stmt->fetch()) {
							echo "<a href='loading.php?id=" . $row['id'] . "'> " . $row['name'] . "</a>";
						}
					?>
				</div>
			</div>
			<a href="#contact"><?php echo $lang['contact']; ?></a>
			<a href="?lang=<?php echo $lang['languages']; ?>"><span style="text-transform: uppercase;"><?php echo $lang['languages']; ?></span></a>
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

		<section id="home">
			<div class="home-content">
				<div class="home-info">
					<h1><?php echo $lang['name'];?></h1>
					<p><?php
						if ($_GET['lang'] != 'fr') { echo $lang['information']; } 
						else { echo $lang['information']; }
					?></p>
					<a href="/doc/resume.pdf" download="resume.pdf"><button class="contactmeA"><h3><?php echo $lang['resume'];?></h3></button></a>
				</div>	
			</div>
		</section>

		<section id="resume">
			<h1 class="myresume">My Resume</h1>
			<div class="project-block">
				<?php
					$stmt = $pdo->query("SELECT * FROM `resume_names` ORDER BY `resume_names`.`id` ASC");
					while ($row = $stmt->fetch()) {
						echo "<div class='project'>";
						echo "<div class='circle-icon'>";
						echo "<div class='project-icon'>";
						echo "<img src='data:image/jpg;base64," . base64_encode($row['icon']) . "' alt='" . $row['id'] . "'>";
						echo "</div>";
						echo "</div>";
						echo "<div class='project-description'>";
						if ($_GET['lang'] != 'fr') {  echo "<h1>". $row['nameEN'] . "</h1>"; } 
						else { echo "<h1>". $row['nameFR'] . "</h1>"; }
						echo "<h2><br>";
						$stmp = $pdo->query("SELECT * FROM `" . $row['des'] . "`");
						while ($raw = $stmp->fetch()) {
							if ($row['id'] === 4){
								if ($_GET['lang'] != 'fr') {  echo "<br><br>" . $raw['nameEN'] ; } 
								else { echo "<br><br>" . $raw['nameFR'] ; }
								echo "<div class='progress'><div class='progress-bar' role='progressbar' style='width: " . $raw['size'] ."%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div></div>";
							}
							else if ($row['id'] === 3) {
								echo "<br><br>" . $raw['name'] ;
								echo "<div class='progress'><div class='progress-bar' role='progressbar' style='width: " . $raw['size'] ."%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div></div>";	
							}
							else {
								if ($_GET['lang'] != 'fr') { 
									echo "<br>" . $raw['nameEN'];
									echo "<br><p>" . $raw['date'] ."</p><br>";
									echo $raw['descriptionEN'] . "<br><br><hr>";
								} else {
									echo "<br>" . $raw['nameFR'];
									echo "<br><p>" . $raw['date'] ."</p><br>";
									echo $raw['descriptionFR'] . "<br><br><hr>";
								}
							}					
						}
						echo "</h2></div></div>";
					}
				?>
			</div>
		</section>

		<section id="class-achievements">
			<?php
				$stmt = $pdo->query("SELECT * FROM achievements");
				while ($row = $stmt->fetch()) {
					echo '<div class="achievement">';
					echo '<div class="class-icon"><i class="' . $row['icon'] . ' icon-xl"></i></div>';
					echo '<div class="border-light"></div>';
					echo '<div class="achievement-text">';
					echo '<div class="count">' . $row['count'] . '</div>';					
					if ($_GET['lang'] != 'fr') {  echo '<div class="count_name">' . $row['count_nameEN'] . '</div>'; } 
					else { echo '<div class="count_name">' . $row['count_nameFR'] . '</div>'; }					
					echo '</div>';
					echo '</div>';
				}
			?>
		</section>

		<section id="projects">
			<div class="centered-container">
				<div class="radio-inputs">
					<label class="radio">
						<input type="radio" name="radio" checked category="all">
						<span class="name"><?php echo $lang['all'];?></span>
					</label>
					<label class="radio">
						<input type="radio" name="radio" category="java">
						<span class="name">Java</span>
					</label>
					<label class="radio">
						<input type="radio" name="radio" category="web">
						<span class="name">Web</span>
					</label>
					<label class="radio">
						<input type="radio" name="radio" category="c">
						<span class="name">C</span>
					</label>
					<label class="radio">
						<input type="radio" name="radio" category="mips">
						<span class="name">MIPS</span>
					</label>
				</div>
			</div>
			<div class="project-block">
				<?php
					$stmt = $pdo->query("SELECT * FROM `project`");
					while ($row = $stmt->fetch()) {
						echo "<div class='project' category='" . $row['category'] . "'>";
						echo "<div class='circle-icon'>";
						echo "<div class='project-icon'>";
						echo "<img src='data:image/jpg;base64," . base64_encode($row['icon']) . "' alt='" . $row['id'] . "'>";
						echo "</div>";
						echo "</div>";
						echo "<div class='project-description'>";
						echo "<h1>". $row['name'] . "</h1>";
						echo "<h2><br>";
						if ($_GET['lang'] != 'fr') {  echo $row['textEN']; } 
						else { echo $row['textFR']; }
						echo "</h2><a href='loading.php?id=" . $row['id'] . "'> " . $lang['readmore'] . " <i class='ti-angle-double-right'></i></a>";
						echo "</h2></div></div>";
					}
				?>
			</div>
		</section>

		<section id="aboutme">
			<div class="aboutme-contact-block">
				<div id="map"></div> 
				<div class="aboutme-block">
					<h1><?php echo $lang['contactD']; ?></h1><br><br>
					<?php
						$stmt = $pdo->query("SELECT * FROM `contact_details`");
						while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
							$iconClass = $row['icon'];
							if ($_GET['lang'] != 'fr') {  
								$name = $row['nameEN'];
								$description = $row['descriptionEN'];
							} 
							else { 
								$name = $row['nameFR'];
								$description = $row['descriptionFR'];
							}
							echo "<h3><i class='$iconClass'></i>
							<span class='text-uppercase'>$name</span></h3>
							<br>$description<br><br>";
						}
					?>
					<div class="social-media">
						<a href="https://www.facebook.com"><i class="ti-facebook"></i></a>
						<a href="https://www.twitter.com"><i class="ti-twitter"></i></a>
						<a href="https://www.gmail.com"><i class="ti-google"></i></a>
						<a href="https://www.instagram.com"><i class="ti-instagram"></i></a>
						<a href="https://www.github.com"><i class="ti-github"></i></a>
					</div>
				</div>
				<div class="contact-block" id="contact">
					<h1><?php echo $lang['gettouch'];?></h1><br><br>
					<form method="POST" id="contact-form">
						<div class="form-control">
							<input type="text" id="name" name="name" required> <label></label>
						</div>
						<div class="form-control">
							<input type="text" id="email" name="email" required> <label></label>
						</div>
						<div class="form-control">
							<textarea id="message" name="message" required></textarea> <label></label>
						</div>
						<button type="submit" name="submit" id="submit-btn"><?php echo $lang['sendM'];?></button>
					</form>
					<svg class="ring" id="ring" viewBox="25 25 50 50" stroke-width="5"><circle cx="50" cy="50" r="20" /></svg>
				</div>
			</div>
		</section>

		<footer>
			<p>&copy; <?php echo date('Y'); ?> Hasanli Ayhan</p>
		</footer>

		<script src="main.js" defer></script>
		<script src="https://cdn.lordicon.com/lordicon-1.1.0.js" defer></script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCtme10pzgKSPeJVJrG1O3tjR6lk98o4w8&callback=initMap" async defer></script>
	</body>
</html>