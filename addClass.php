<?php
	include ('connections.php');
	
	mysqli_set_charset ($connect, "utf8");
    date_default_timezone_set('America/Mexico_City');

    $subject = $_REQUEST['nombreMateria'];
    $period = $_REQUEST['currentPeriod'];
    $user = $_REQUEST['currentUser'];

    $queryId = "Select MAX(materia_ID) from materias";
    $resultId = mysqli_query($connect, $queryId);
    $maxId = mysqli_fetch_array($resultId);
    $maxID = $maxId[0] + 1;

	$queryClass = "Insert into materias (materia_ID, materia_nombre, materia_activa, materia_usuario) values ($maxID, '$subject', $period, $user)";
	$resultClass = mysqli_query($connect, $queryClass);

	echo '<meta http-equiv="refresh" content="0;URL=index_user.php"/>';	
?>