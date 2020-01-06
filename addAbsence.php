<?php
	$hostname = "sql107.epizy.com";
    $username = "epiz_23945487";
    $password = "xrtaXLx81bkyTR";
    $databaseName = "epiz_23945487_faltas_uaa";

    $connect = mysqli_connect($hostname, $username, $password, $databaseName);
    mysqli_set_charset ($connect, "utf8");
    date_default_timezone_set('America/Mexico_City');

    $subject = $_REQUEST['currSubjectInput'];
	$date = $_REQUEST['currDateInput'];

	$queryPeriod = "Select materia_parcialActual from materias where materia_nombre = '$subject'";
	$p = mysqli_query($queryPeriod);
	$period = mysqli_fetch_array($p);
	$period = $period[0];

	$queryAbsence = "Update materias set ";

	switch($period){
		case 1: $queryAbsence .= "materia_primerParcial = materia_primerParcial + 1"; break;
		case 2: $queryAbsence .= "materia_segundoParcial = materia_segundoParcial + 1"; break;
		case 3: $queryAbsence .= "materia_tercerParcial = materia_tercerParcial + 1"; break;
	}

	$queryAbsence .= ", materia_totalFaltas = materia_totalFaltas + 1 where materia_nombre = '$subject'";
	mysqli_query($queryAbsence);

	$querySubject = "Select materia_ID from materias where materia_nombre = '$subject'";
	$s = mysqli_query($querySubject);
	$sID = mysqli_fetch_array($s);

	$subjectID = $sID[0];

	$queryAbsID = "Select MAX(falta_ID) from registrofaltas";
	$a = mysqli_query($queryAbsID);
	$aID = mysqli_fetch_array($a);

	$absID = $aID[0] + 1;

	$queryAbsenceReg = "Insert into registrofaltas values ($absID, '$date', $period, $subjectID)";
	mysqli_query($queryAbsenceReg);
?>