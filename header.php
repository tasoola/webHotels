<!DOCTYPE html>
<html lang="el">
    <head>
		<meta charset="utf-8" />
		<meta name="description" content="Register your hotel now!"/>
		<meta name="keywords" content="hotels,webhotels, hotel, vacation "/>
		<meta name="author" content="Anastasia Vafeiadi"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<title><?php echo $title; ?></title>
		<link rel="stylesheet" type="text/css" href="style.css"/>
    </head>


	<body>
		<header id="header" >
			<div class="home">
				<a href="index.php">
					<img src="images/header-logo-m.png" alt="Page Logo" style="width:100%"/>
				</a>
			</div>
			<nav>
				<ul>
					<li id="menu-item1">
						<a href="index.php">Αρχική</a>
					</li>
					<li id="menu-item2">
						<a href="search-page.php?search[name]=&search[location]=&search[rating]=&search[equipment][]=">Περιήγηση</a>
					</li>
					<?php 
						if ( !isset($_SESSION['username']) ) { ?>
						<li id="menu-item4">
							<a href="login-form.php">Σύνδεση</a>
						</li>
					<?php } else { ?>
						<li id="menu-item4">
							<a href="user-page.php"><?php echo $_SESSION['username'] ?></a>
						</li>
					<?php } ?>
					<?php 
						if ( !isset( $_COOKIE['dark'] ) ) { ?>
							<li id="menu-item5">
							<a href="cookie-handler.php?style=dark" style="padding: 9px 16px 9px 16px;">
								Theme<img style="width:25px; height:25px;" src="images/sun.png"/>
							</a>
							</li>
						<?php } else { ?>
							<li id="menu-item5">
							<a href="cookie-handler.php?style=light" style="padding: 9px 16px 9px 16px;">
								Theme<img style="width:25px; height:25px;" src="images/moon.png"/>
							</a>
							</li>
						<?php } ?>
					

				</ul>
			</nav>
		</header>