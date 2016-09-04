<?php

	include "../../includes/conexion.php";
	
	//Variables inicializadas
	if(isset($_POST["login"])){
		$tipo = strtolower(substr($_POST["login"], 0, 1));
		$usuario=substr($_POST["login"], 1);
	}else{
		$usuario="";
		$tipo = "";
	}
	
	if(isset($_POST["password"])){
		$clave=$_POST["password"];
	}else{
		$clave="";
	}
	
	$password="";
	$nombre="";
	
	if($tipo == "a"){
		$tabla = "alumno";
	}
	else if ($tipo == "m"){
		$tabla = "maestro";
	}
	else if ($tipo == "d"){
		$tabla = "administrador";
	}else{
		echo "<script language=\"javascript\">
				alert(\"Usuario o clave incorrectas\");
				window.location.href = \"../../vistas/index.php\"
				</script>";
	}
	
	$usuario = mysqli_escape_string($conexion, $usuario);
	
	$sql="select " . $tipo . "_contra, " . $tipo . "_nombre from " . $tabla . " where id_" . $tabla . "= '$usuario'";
	
	$result = mysqli_query($conexion, $sql);

	while($row = mysqli_fetch_assoc($result)){
		$password=$row[$tipo . '_contra'];
		$nombre=$row[$tipo . '_nombre'];
	}	


	//Si la clave ingresada es igual a la de la base de datos deja ingresar
	if(md5($clave) == $password && $usuario != ""){
		session_start();
		// store session data
		$_SESSION['matricula']=$usuario;
		$_SESSION['tipo']=$tipo;
        $_SESSION['nombre']=$nombre;
		if($tipo == "a"){
			echo "<script language=\"javascript\">
					window.location.href = \"../../vistas/menus/menuAlumno.php\"
				</script>";
		}elseif ( $tipo == "d") {
			//Establece variables de permiso
			$sqlPermiso = "select * from permiso where id_administrador =" . $usuario;
			$result = mysqli_query($conexion, $sqlPermiso);
			while($row = mysqli_fetch_assoc($result)) {
				$_SESSION['altaAdmin']=$row['p_aAdmin'];
				$_SESSION['bajaAdmin']=$row['p_bAdmin'];
				$_SESSION['cambioAdmin']=$row['p_cAdmin'];
				$_SESSION['altaMaestro']=$row['p_aMaestro'];
				$_SESSION['bajaMaestro']=$row['p_bMaestro'];
				$_SESSION['cambioMaestro']=$row['p_cMaestro'];
				$_SESSION['altaAlumno']=$row['p_aAlumno'];
				$_SESSION['bajaAlumno']=$row['p_bAlumno'];
				$_SESSION['cambioAlumno']=$row['p_cAlumno'];
				$_SESSION['altaPeriodo']=$row['p_aPeriodo'];
				$_SESSION['bajaPeriodo']=$row['p_bPeriodo'];
				$_SESSION['cambioPeriodo']=$row['p_cPeriodo'];
				$_SESSION['altaGrupoCursos']=$row['p_aGruposCursos'];
				$_SESSION['bajaGrupoCursos']=$row['p_bGruposCursos'];
				$_SESSION['cambioGrupoCursos']=$row['p_cGruposCursos'];
				$_SESSION['verReportes']=$row['p_verReportes'];
			}	

			echo "<script language=\"javascript\">
					window.location.href = \"../../vistas/menus/menuAdmin.php\"
				</script>";
		}
		else{
			echo "<script language=\"javascript\">
					window.location.href = \"../../vistas/menus/menuMaestro.php\"
				</script>";
		}
	}else{
			echo "<script language=\"javascript\">
				alert(\"Usuario o clave incorrectas\");
				window.location.href = \"../../vistas/index.php\"
				</script>";
	}
?>