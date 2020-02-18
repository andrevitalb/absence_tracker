<?php 
	include('connections.php');
	
	mysqli_set_charset ($connect, "utf8");
    date_default_timezone_set('America/Mexico_City');

    $subject = $_REQUEST['newPeriodClass'];
    $userID = $_REQUEST['currentUser'];

    if($subject == 69) $queryNewPeriod = "Update materias set materia_parcialActual = materia_parcialActual + 1 where materia_ID > 0 and materia_usuario = $usr";
    else $queryNewPeriod = "Update materias set materia_parcialActual = materia_parcialActual + 1 where materia_ID = $subject and materia_usuario = $usr";
    
    $resultNewPeriod = mysqli_query($connect, $queryNewPeriod);
	
	echo '<meta http-equiv="refresh" content="0;URL=index_user.php"/>';
?>