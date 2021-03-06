<?php session_start();
    if(!isset($_SESSION['usr'])) {
        header('Location: index.php');
        die();
    }

	include ('connections.php');
	$usr =  $_SESSION['usr'];

	$queryGetSemester = "Select usuarios_semestre from usuarios";
	$resultGetSemester = mysqli_query($connect, $queryGetSemester);
	$rGetSemester = mysqli_fetch_array($resultGetSemester);
	$semester = $rGetSemester[0];

    $queryUser = "Select usuarios_nombre from usuarios where usuarios_ID = $usr";
    $resultUser = mysqli_query($connect, $queryUser);
    $name = mysqli_fetch_array($resultUser);
	$name = $name[0];
	
    mysqli_set_charset ($connect, "utf8");
    date_default_timezone_set('America/Mexico_City');

	function getClasses(){
		global $connect, $resultGetClasses, $semester, $usr;

		$queryGetClasses = "Select materia_ID, materia_nombre, materia_totalFaltas from materias where materia_activa = $semester and materia_usuario = $usr";
		$resultGetClasses = mysqli_query($connect, $queryGetClasses);
	}
	$countClasses = 0;

	function newSemester(){
		global $connect, $usr;

		$queryNewSemester = "Update usuarios set usuarios_semestre = usuarios_semestre + 1 where usuarios_ID = $usr";
		mysqli_query($connect, $queryNewSemester);
	}

	function getAbsences(){
		global $connect, $resultGetAbsences, $semester, $usr;

		$queryGetAbsences = "Select materia_ID, falta_fecha from registrofaltas inner join materias on falta_materia = materia_ID where materia_activa = $semester and materia_usuario = $usr group by falta_fecha order by falta_fecha desc";
		$resultGetAbsences = mysqli_query($connect, $queryGetAbsences);
	}

	function getAbsenceDate($date){
		global $connect, $resultGetDate, $semester, $usr;

		$queryGetDate = "Select materia_ID from registrofaltas inner join materias on falta_materia = materia_ID where materia_activa = $semester and materia_usuario = $usr and falta_fecha = '$date'";
		$resultGetDate = mysqli_query($connect, $queryGetDate);
	}

	getClasses();
	getAbsences();
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
		<link rel="shortcut icon" href="assets/img/favicon.png">
		<link rel="apple-touch-icon" href="assets/img/apple-touch-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="72x72" href="assets/img/apple-touch-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="114x114" href="assets/img/apple-touch-icon-114x114.png">
		<link rel="icon" type="image/png" sizes="36x36" href="assets/img/android-chrome-36x36.png">
		<link rel="icon" type="image/png" sizes="48x48" href="assets/img/android-chrome-48x48.png">
		<link rel="icon" type="image/png" sizes="72x72" href="assets/img/android-chrome-72x72.png">
		<link rel="icon" type="image/png" sizes="96x96" href="assets/img/android-chrome-96x96.png">
		<link rel="icon" type="image/png" sizes="144x144" href="assets/img/android-chrome-144x144.png">
		<link rel="icon" type="image/png" sizes="192x192" href="assets/img/android-chrome-192x192.png">

		<!-- PWA -->
		<link rel="manifest" href="manifest.json">
	</head>
	<body>
		<header>
			<div class="container-fluid">
				<div class="row justify-content-evenly">
					<div class = "col-3 col-md-3" id = "navLogOut">
						<a href="cerrar.php">
							<i class="far fa-power-off"></i>
							<span>Cerrar Sesión</span>
						</a>
					</div>
					<div class = "col-9 col-md-6" id = "navTitle">
						<h3>Absence Tracker</h3>
					</div>
					<div class = "col-6 col-md-3" id = "navUser">
						<p><?php echo $name;?></p>
					</div>
				</div>
			</div>
		</header>
		<div class="container page-wrapper">
			<div class="row justify-content-evenly" id = "absencesRow">
				<div class="col-12 sm-text-center">
					<h2><?php echo $semester; ?>° Semestre</h2>
				</div>
				<?php 
					if($resultGetClasses) while($rowClasses = mysqli_fetch_array($resultGetClasses)) {
						echo "<div class='col-5 col-md-3 classContainer text-center' id = '$rowClasses[0]' title = '$rowClasses[1]'><div class='d-table'><div class='classContent'><h4 class = 'classTitle'>$rowClasses[1]</h4><p class='absenceCounter'><span class = 'absences'>$rowClasses[2]</span>faltas</p></div></div></div>";
						$countClasses++;
					}
				?>
			</div>

			<div class="row justify-content-center" id="actionButtons">
				<div class="col-12 sm-text-center">
					<h2>Acciones</h2>
				</div>
				<div class="col-12 col-md-4 text-center">
					<button type="button" name="newClass" id="newClass" class = "ownButton">Nueva Clase</button>
				</div>
				<div class="col-12 col-md-4 text-center">
					<form action="" method = "post">
						<button type="submit" name="newSemester" id="newSemester" class = "ownButton">Nuevo Semestre</button>
						<?php 
							if(isset($_POST['newSemester'])) {
								newSemester();
								echo '<meta http-equiv="refresh" content="0;URL=/" />';
							} 
						?>
					</form>
				</div>
				<div class="col-12 text-center">
					<form action="newPeriod.php" method = "post" class = "row">
						<div class="col-12 col-md-8">
							<select name="newPeriodClass" id="newPeriodClass">
								<option selected disabled required>  - Selecciona una opción</option>
								<?php 
									getClasses();

									if($resultGetClasses) while($rowClasses = mysqli_fetch_array($resultGetClasses)) {
										echo "<option value='$rowClasses[0]'>$rowClasses[1]</option>";
									}
								?>
								<option value='69'>Todas</option>
							</select>
							<input type="hidden" name="currentUser" value = "<?php echo $usr; ?>">
						</div>
						<div class="col-12 col-md-4">
							<button type = "submit" name = "newPeriodButton" id = "newPeriodButton" class = "ownButton">Iniciar nuevo parcial</button>
						</div>
					</form>
				</div>
			</div>

			<div class="row justify-content-center" id = "absenceTable">
				<div class="col-12 sm-text-center">
					<h2>Faltas por fecha</h2>
				</div>
				<div class="col-12 col-md-8">
					<div class="table-responsive">
						<table class="table table-dark table-striped table-hover table-bordered ">
							<thead>
								<tr>
									<th scope="col"><p>Fecha</p></th>
									<?php 
										getClasses();
										$classes = array();

										if($resultGetClasses) while($rowClasses = mysqli_fetch_array($resultGetClasses)) {
											echo "<th scope='col'>$rowClasses[1]</th>";
											array_push($classes, $rowClasses[0]);
										}
									?>
								</tr>
							</thead>
							<tbody>
								<?php 
									while($rowAbsences = mysqli_fetch_array($resultGetAbsences)) {
										echo "<tr><th scope='row'>$rowAbsences[1]</th>";

										getAbsenceDate($rowAbsences[1]);
										$dayAbs = array();
										while($rowDay = mysqli_fetch_array($resultGetDate)) array_push($dayAbs, $rowDay[0]);

										for($i = 0; $i < $countClasses; $i++){
											echo "<td class='text-center' value='$classes[$i]'>";
											if(in_array($classes[$i], $dayAbs)) echo "<i class='fal fa-check-square'></i>";
											echo "</td>";
										}

										echo "</tr>";
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		
		<div class="container-fluid modal-wrapper">
			<div class="row justify-content-center">
				<div>
					<div class="modal col-11 col-md-5">
						<a class="btn-close" href="javascript:;"></a>
						<div class="content text-center">
							<form action="addAbsence.php" id = "addAbsenceForm">
								<input type="text" id = "currSubjectInput" name = "currSubjectInput" required>
								<p id = "currSubject">Materia: </p>
								<p id = "currDate">Fecha: </p>
								<button type="submit" id = "addAbsence">Agregar</button>
							</form>
							<form action="addClass.php" id = "addClassForm" class = "row">
								<div class="col-12">
									<label for="nombreMateria">Nombre: </label>
									<input type="text" id = "nombreMateria" name = "nombreMateria" required>
									<input type="hidden" name = "currentPeriod" value="<?php echo $semester;?>">
									<input type="hidden" name = "currentUser" value="<?php echo $usr;?>">
								</div>
								<div class="col-12">
									<button type="submit" id = "addClass">Agregar</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
		<script>
			var today = new Date();
			var day = String(today.getDate()).padStart(2, '0');
			var month = String(today.getMonth() + 1).padStart(2, '0'); 
			var year = today.getFullYear();

			$(document).ready(function() {
				$('#currDate').html("<strong>Fecha:</strong> " + day + ' - ' + month + ' - ' + year);

				$('.btn-close').click(function() {
					$('.modal-wrapper').toggleClass('open');
					$('.page-wrapper').toggleClass('blur');
					$('#addAbsenceForm').css('display', 'none');
					$('#addClassForm').css('display', 'none');
					return false;
				});

				$('.classContainer').click(function() {
					$('#currSubject').html("<strong>Materia:</strong> " + $(this).attr('title'));
					$('#currSubjectInput').val($(this).attr('id'));
					$('.modal-wrapper').toggleClass('open');
					$('.page-wrapper').toggleClass('blur');
					$('#addAbsenceForm').css('display', 'block');
					return false;
				});

				$('#newClass').click(function(){
					$('.modal-wrapper').toggleClass('open');
					$('.page-wrapper').toggleClass('blur');
					$('#addClassForm').css('display', 'block');
				});
			});
		</script>
	</body>
</html>