<?php 
	include('connections.php');
	
	mysqli_set_charset ($connect, "utf8");
    date_default_timezone_set('America/Mexico_City');

    $subject = $_REQUEST['newPeriodClass'];

    if($subject == 69) $queryNewPeriod = "Update materias set materia_parcialActual = materia_parcialActual + 1 where materia_ID > 0";
    else $queryNewPeriod = "Update materias set materia_parcialActual = materia_parcialActual + 1 where materia_ID = $subject";
    
    $resultNewPeriod = mysqli_query($connect, $queryNewPeriod);
	
	echo '<meta http-equiv="refresh" content="0;URL=index.php"/>';
?>