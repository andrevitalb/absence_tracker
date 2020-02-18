<?php session_start();
    if(isset($_SESSION['usr'])) {
        header('Location: index_user.php');
        die();
    }

    include('login.php');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-143184290-1"></script>
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());

			gtag('config', 'UA-143184290-1');
		</script>
		<title>Absence Tracker</title>

		<link rel="canonical" href="https://absences.andrevital.com/">

		<meta charset="utf-8">
	   	<meta name="theme-color" content="#000">
		<meta name="title" content="Absence Tracker | Absence Tracking Tool">
		<meta name="application-name" content="Absence Tracker">
		<meta name="description" content="Absence tracking tool with dynamic class control & absence calendar display">
		<meta name="author" content="André Vital">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

		<meta property="og:site_name" content="Absence Tracker">
		<meta property="og:title" content="Absence Tracker | Absence Tracking Tool">
		<meta property="og:type" content="website">
		<meta property="og:url" content="https://absences.andrevital.com/">
		<meta property="og:image" content="https://andrevital.com/images/absences.jpg">
		<meta property="og:description" content="Absence tracking tool with dynamic class control & absence calendar display.">

		<meta property="twitter:card" content="summary_large_image">
		<meta property="twitter:url" content="https://absences.andrevital.com/">
		<meta property="twitter:title" content="Absence Tracker | Absence Tracking Tool">
		<meta property="twitter:description" content="Absence tracking tool with dynamic class control & absence calendar display">
		<meta property="twitter:image" content="https://andrevital.com/images/absences.jpg">
		<meta name="twitter:image:alt" content="Absence Tracker | Absence Tracking Tool">
		<meta name="twitter:site" content="@andrevitalb">

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/css/styles.css">
		<link rel="stylesheet" href="assets/css/all.min.css">

		<!-- Favicon -->
		<link rel="icon" type="image/ico" href="assets/img/favicon.ico">

		<!-- PWA -->
        <link rel="manifest" href="manifest.json">
	</head>
	<body>
		<div class="container page-wrapper">
			<div class="row justify-content-center" id = "titleRow">
				<div class="col-12 col-md-6">
					<div id="loginHolder">
						<h2>Login</h2>
						<form method="post">
							<input type="text" id="loginUser" name="loginUser" placeholder="Usuario *" required>
							<input type="password" id="loginPassword" name="loginPassword" placeholder="Contraseña *" required>
							<div class="text-right">
								<button type="submit" id="loginSubmit" name="loginSubmit">Login<i class="far fa-arrow-right"></i></button>
							</div>
							<div class="col-12">
								<?php
				                    if(isset($_POST['loginUser']) && isset($_POST['loginPassword'])){
				                        if(userEx() != -1){
				                            $_SESSION['usr'] = $usuario;
											echo '<meta http-equiv="refresh" content="0; url=index_user.php">';
				                        }
				                        else echo $errorMsg;
				                    }
				                  ?>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	</body>
</html>