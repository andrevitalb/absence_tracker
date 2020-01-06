<?php 
	include ('connections.php');

	$queryGetSemester = "Select semestre_actual from semestre";
	$resultGetSemester = mysqli_query($connect, $queryGetSemester);
	$rGetSemester = mysqli_fetch_array($resultGetSemester);
	$semester = $rGetSemester[0];
	
    mysqli_set_charset ($connect, "utf8");
    date_default_timezone_set('America/Mexico_City');

	function getClasses(){
		global $connect, $resultGetClasses, $semester;

		$queryGetClasses = "Select materia_ID, materia_nombre, materia_totalFaltas from materias where materia_activa = $semester";
		$resultGetClasses = mysqli_query($connect, $queryGetClasses);
	}

	getClasses();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<title>Absence Tracker</title>

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/css/styles.css">

		<link rel="icon" href="assets/img/favicon.ico">
	</head>
	<body>
		<div class="container page-wrapper">
			<div class="row" id = "titleRow">
				<div class="col-12 text-center">
					<h1>Absence Tracker</h1>
				</div>
			</div>
			<div class="row justify-content-evenly" id = "absencesRow">
				<div class="col-12 sm-text-center">
					<h2><?php echo $semester; ?>° Semestre</h2>
				</div>
				<?php 
					if($resultGetClasses) while($rowClasses = mysqli_fetch_array($resultGetClasses)) {
						echo "<div class='col-5 col-md-3 classContainer text-center' id = '$rowClasses[0]' title = '$rowClasses[1]'><div class='d-table'><div class='classContent'><h4 class = 'classTitle'>$rowClasses[1]</h4><p class='absenceCounter'><span class = 'absences'>$rowClasses[2]</span>faltas</p></div></div></div>";
					}
				?>
			</div>

			<div class="row justify-content-evenly" id="periodsRow">
				<div class="col-12 sm-text-center">
					<h2>Parciales</h2>
				</div>
				<div class="col-12 col-md-6 text-center">
					<form action="" method = "post">
						<select name="newPeriodClass" id="newPeriodClass">
							<option selected disabled>  - Selecciona una opción</option>
							<?php 
								getClasses();

								if($resultGetClasses) while($rowClasses = mysqli_fetch_array($resultGetClasses)) {
									echo "<option value='$rowClasses[0]'>$rowClasses[1]</option>";
								}
							?>
						</select>
						<button type = "button" name = "newPeriodButton" id = "newPeriodButton" class = "ownButton">Iniciar nuevo parcial</button>
					</form>
				</div>
			</div>

			<div class="row justify-content-center" id="restartingButtons">
				<div class="col-12 sm-text-center">
					<h2>Agregar</h2>
				</div>
				<div class="col-12 col-md-4 text-center">
					<button type="button" name="newSemester" id="newSemester" class = "ownButton">Nuevo Semestre</button>
				</div>
				<div class="col-12 col-md-4 text-center">
					<button type="button" name="newClass" id="newClass" class = "ownButton">Nueva Clase</button>
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
								<input type="text" id = "currSubjectInput" name = "currSubjectInput">
								<input type="text" id = "currDateInput" name = "currDateInput">
								<p id = "currSubject">Materia: </p>
								<p id = "currDate">Fecha: </p>
								<button type="submit" id = "addAbsence">Agregar</button>
							</form>
							<form action="addClass.php" id = "addClassForm">
								<label for="nombreMateria">Nombre: </label>
								<input type="text" id = "nombreMateria" name = "nombreMateria">
								<button type="submit" id = "addClass">Agregar</button>
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
				$('#currDateInput').val(day + ' - ' + month + ' - ' + year);

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