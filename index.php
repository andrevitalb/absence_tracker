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
					<h2>4° Semestre</h2>
				</div>
				<div class="col-5 col-md-3 classContainer text-center" id = "0" title = "Lenguajes de Computación IV">
					<div class="d-table">
						<div class="classContent">
							<h4 class = "classTitle">Lenguajes de Computación IV</h4>
							<p class="absenceCounter"><span class = "absences">16</span>faltas</p>
						</div>
					</div>
				</div>
				<div class="col-5 col-md-3 classContainer text-center" id = "1" title = "Programación Científica">
					<div class="d-table">
						<div class="classContent">
							<h4 class = "classTitle">Programación Científica</h4>
							<p class="absenceCounter"><span class = "absences">16</span>faltas</p>
						</div>
					</div>
				</div>
				<div class="col-5 col-md-3 classContainer text-center" id = "2" title = "Organización Computacional">
					<div class="d-table"
>						<div class="classContent">
							<h4 class = "classTitle">Organización Computacional</h4>
							<p class="absenceCounter"><span class = "absences">16</span>faltas</p>
						</div>
					</div>
				</div>
				<div class="col-5 col-md-3 classContainer text-center" id = "3" title = "Análisis y Diseño">
					<div class="d-table">
						<div class="classContent">
							<h4 class = "classTitle">Análisis y Diseño</h4>
							<p class="absenceCounter"><span class = "absences">16</span>faltas</p>
						</div>
					</div>
				</div>
				<div class="col-5 col-md-3 classContainer text-center" id = "4" title = "Técnicas Inteligentes para Procesos de Desarrollo">
					<div class="d-table">
						<div class="classContent">
							<h4 class = "classTitle">Técnicas Inteligentes para Procesos de Desarrollo</h4>
							<p class="absenceCounter"><span class = "absences">16</span>faltas</p>
						</div>
					</div>
				</div>
				<div class="col-5 col-md-3 classContainer text-center" id = "5" title = "Mecánica">
					<div class="d-table">
						<div class="classContent">
							<h4 class = "classTitle">Mecánica</h4>
							<p class="absenceCounter"><span class = "absences">16</span>faltas</p>
						</div>
					</div>
				</div>
			</div>

			<div class="row justify-content-evenly" id="periodsRow">
				<div class="col-12 sm-text-center">
					<h2>Parciales</h2>
				</div>
				<div class="col-12 col-md-6 text-center">
					<select name="newPeriodClass" id="newPeriodClass">
						<option value="1">Lenguajes de Computación IV</option>
						<option value="2">Programación Científica</option>
						<option value="3">Organización Computacional</option>
						<option value="4"></option>
						<option value="5"></option>
						<option value="6"></option>
					</select>
				</div>
				<div class="col-5 col-md-3 text-center subjectPeriod">
					<h4 class = "classTitle">Programación Científica</h4>
					<p class="newPeriodButton">Iniciar nuevo parcial</p>
				</div>
				<div class="col-5 col-md-3 text-center subjectPeriod">
					<h4 class = "classTitle">Organización Computacional</h4>
					<p class="newPeriodButton">Iniciar nuevo parcial</p>
				</div>
				<div class="col-5 col-md-3 text-center subjectPeriod">
					<h4 class = "classTitle">Análisis y Diseño</h4>
					<p class="newPeriodButton">Iniciar nuevo parcial</p>
				</div>
				<div class="col-5 col-md-3 text-center subjectPeriod">
					<h4 class = "classTitle">Técnicas Inteligentes para Procesos de Desarrollo</h4>
					<p class="newPeriodButton">Iniciar nuevo parcial</p>
				</div>
				<div class="col-5 col-md-3 text-center subjectPeriod">
					<h4 class = "classTitle">Mecánica</h4>
					<p class="newPeriodButton">Iniciar nuevo parcial</p>
				</div>
			</div>
		</div>
		
		<div class="container-fluid modal-wrapper">
			<div class="row justify-content-center">
				<div>
					<div class="modal col-11 col-md-5">
						<a class="btn-close" href="javascript:;"></a>
						<div class="content text-center">
							<form action="addAbsence.php">
								<input type="text" id = "currSubjectInput" name = "currSubjectInput">
								<input type="text" id = "currDateInput" name = "currDateInput">
								<p id = "currSubject">Materia: </p>
								<p id = "currDate">Fecha: </p>
								<button type="submit" id = "addAbsence">Agregar</button>
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
					return false;
				});

				$('.classContainer').click(function() {
					$('#currSubject').html("<strong>Materia:</strong> " + $(this).attr('title'));
					$('#currSubjectInput').val($(this).attr('id'));
					$('.modal-wrapper').toggleClass('open');
					$('.page-wrapper').toggleClass('blur');
					return false;
				});
			});
		</script>
	</body>
</html>