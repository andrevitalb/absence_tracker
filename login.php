<?php
    include('connections.php');

	$username = "";
	$password = "";
	$usuario = 0;
	$errorMsg = "";

	function userEx(){
		global $username, $password, $connect, $usuario;
		$username = $_POST['loginUser'];
		$password = $_POST['loginPassword'];
		$userEx = "Select usuarios_user from usuarios where usuarios_user = '$username'";
		$resultEx = mysqli_query($connect, $userEx);
		$rEx = mysqli_fetch_array($resultEx);

        if($rEx){
        	$pwdEx = "Select usuarios_password from usuarios where usuarios_user = '$username'";
        	$pwdResult = mysqli_query($connect, $pwdEx);
        	$pwdFnl = mysqli_fetch_array($pwdResult);

        	if($pwdFnl[0] == $password) {
        		userID();
				return $usuario;
			}
        	else {
        		errorMsg(1);
        		return -1;
        	}
        }
        else {
        	errorMsg(0);
        	return -1;
        }
	}

	function userID(){
		global $username, $usuario, $connect;
		$userID = "Select usuarios_ID from usuarios where usuarios_user = '$username'";
		$usrInd = mysqli_query($connect, $userID);
		$userInd = mysqli_fetch_array($usrInd);
		$usuario = $userInd[0];
	}

	function errorMsg($ind){
		global $errorMsg;

		switch($ind){
			case 0: $errorMsg = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>¡Error!</strong> El usuario ingresado no está registrado.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'; break;
			case 1: $errorMsg = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>¡Error!</strong> La contraseña ingresada es incorrecta o no coincide con el correo.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'; break; 
		}
	}
?>