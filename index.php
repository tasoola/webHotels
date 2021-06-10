<?php session_start(); ?>
<?php
  $title='webHotels | Home';
  require('header.php');
?>

<?php 
    if ( isset($_COOKIE['dark'] ) ) { ?>
        <style type="text/css">
            <?php require('style-dark.css'); ?>
        </style>
<?php } ?>

    <main id="main">
	    <div class="slideshow">
			<div class="slide fade">
				<a href="search-page.php">
					<img src="images/slideshow1.jpg" alt="slideshow1" style="width:100%"/>
				</a>
			</div>
			<div class="slide fade"> 
				<?php if ( !isset($_SESSION['username']) ) { ?>
					<a href="register-user-form.php">
						<img src="images/slideshow2a.jpg" alt="slideshow2" style="width:100%"/>
					</a>
				<?php } else { ?>
					<a href="user-page.php">
						<img src="images/slideshow2a.jpg" alt="slideshow2" style="width:100%"/>
					</a>
				<?php } ?>
			</div>
			<div class="slide fade">
				<a href="#loc">
					<img src="images/slideshow3.jpg" alt="slideshow3" style="width:100%"/>
				</a>
			</div>

			<div style="text-align:center;">
				<span class="dot"></span>
				<span class="dot"></span>
				<span class="dot"></span>
			</div>

		</div>
		<script>
			var slideIndex = 0;
			showSlides();
			
			function showSlides() {
				var i;
				var slides = document.getElementsByClassName("slide");
				var dots = document.getElementsByClassName("dot");
				for (i = 0; i < slides.length; i++) {
					slides[i].style.display = "none";  
				}
				slideIndex++;
				if (slideIndex > slides.length) {slideIndex = 1}    
				for (i = 0; i < dots.length; i++) {
					dots[i].className = dots[i].className.replace(" active", "");
				}
				slides[slideIndex-1].style.display = "block";  
				dots[slideIndex-1].className += " active";
				setTimeout(showSlides, 7000);	
			}
		</script>
		<br><br>
		<div class="text-banner">
			<h2> Ψάχνεις ξενοδοχείο για προορισμό στην Ελλάδα; </h2>
			<h3><a href="browse.php"> Βρες το καλύτερο για εσένα! </a></h3>
			<h2> ~ </h2>
			<h2> Είσαι ιδιοκτήτης ξενοδοχείου; </h2>
			<?php 
				if ( !isset($_SESSION['username']) ) { ?>
				<h3><a href="login-form.php"> Καταχώρησέ το τώρα! </a></h3>
			<?php } else { ?>
				<h3><a href="user-page.php"> Καταχώρησέ το τώρα! </a></h3>
			<?php } ?>
				
		</div>
		<br><br>
		
		<div class="listContainer">
			<div id="loc">
				<h2> Βρες τον επόμενο προορισμό σου! </h2>
				<div id="location-list" class="location-list" >
					<div class="location-selection">
						<a href="search-page.php?search[location]=Αθήνα"><img src="images/athina.jpg" alt="Αθήνα"/></a>
						<h4> Αθήνα </h4>
					</div>
					<div class="location-selection">
						<a href="search-page.php?search[location]=Κέρκυρα"><img src="images/kerkyra.jpg" alt="Κέρκυρα"/><a>
						<h4> Κέρκυρα </h4>
					</div>
					<div class="location-selection">
						<a href="search-page.php?search[location]=Πάτρα"><img src="images/patra.jpg" alt="Πάτρα"/></a>
						<h4> Πάτρα </h4>
					</div>
					<div class="location-selection">
						<a href="search-page.php?search[location]=Χαλκιδική"><img src="images/chalkidiki.jpg" alt="Χαλκιδική"/></a>
						<h4> Χαλκιδική </h4>
					</div>
					<div class="location-selection">
						<a href="search-page.php?search[location]=Θεσσαλονίκη"><img src="images/thessaloniki.jpg" alt="Θεσσαλονίκη"/></a>
						<h4> Θεσσαλονίκη </h4>
					</div>
					<div class="location-selection">
						<a href="search-page.php?search[location]=Λάρισα"><img src="images/larisa.jpg" alt="Λάρισα"/></a>
						<h4> Λάρισα </h4>
					</div>
				</div>
			</div>

		</div>
		<br><br><br>


	</main>

<?php require('footer.php'); ?>