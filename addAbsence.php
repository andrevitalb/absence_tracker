<?php
	include ('connections.php');
	
	mysqli_set_charset ($connect, "utf8");
    date_default_timezone_set('America/Mexico_City');

    $subject = $_REQUEST['currSubjectInput'];

	$queryPeriod = "Select materia_parcialActual from materias where materia_id = $subject";
	$resultPeriod = mysqli_query($connect, $queryPeriod);
	$p = mysqli_fetch_array($resultPeriod);
	$period = $p[0];

	$queryAbsence = "Update materias set ";

	switch($period){
		case 1: $queryAbsence .= "materia_primerParcial = materia_primerParcial + 1"; break;
		case 2: $queryAbsence .= "materia_segundoParcial = materia_segundoParcial + 1"; break;
		case 3: $queryAbsence .= "materia_tercerParcial = materia_tercerParcial + 1"; break;
	}

	$queryAbsence .= ", materia_totalFaltas = materia_totalFaltas + 1 where materia_id = $subject";
	$resultAbsence = mysqli_query($connect, $queryAbsence);

	$queryAbsID = "Select MAX(falta_ID) from registrofaltas";
	$a = mysqli_query($connect, $queryAbsID);
	$aID = mysqli_fetch_array($a);

	$absID = $aID[0] + 1;

	$queryAbsenceReg = "Insert into registrofaltas values ($absID, CURDATE(), $period, $subject)";
	$resultAbsenceReg = mysqli_query($connect, $queryAbsenceReg);
	
	echo '<meta http-equiv="refresh" content="0;URL=index.php"/>';	
?>