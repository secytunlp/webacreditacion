<?
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Modificar disciplinas" )) {
	
	$oUsuario = new Usuario ( );
	
	
	
	
		$oUsuario->setCd_usuario ( $_SESSION ["cd_usuarioSession"] );
	
	
		$oEvaluadorespacialidad = new Evaluadorespecialidad();
		$oEvaluadorespacialidad->setCd_usuario($oUsuario->getCd_usuario());
		EvaluadorespecialidadQuery::eliminarEvaluadorespecialidadPorUsuario($oEvaluadorespacialidad);
		if  ( $_POST ['cd_especialidad'] ){
			$especialidades = split(',', $_POST ['cd_especialidad']);
			foreach ($especialidades as $especialidad) {
				if ($especialidad) {
					$oEvaluadorespacialidad->setCd_especialidad($especialidad);
					EvaluadorespecialidadQuery::insertEvaluadorespecialidad($oEvaluadorespacialidad);
				}
			}
		
		$oFuncion = new Funcion();
		$oFuncion -> setDs_funcion("Modificar disciplinas");
		FuncionQuery::getFuncionPorDs($oFuncion);
		$oMovimiento = new Movimiento();
		$oMovimiento->setCd_funcion($oFuncion->getCd_funcion());
		$oMovimiento->setCd_usuario($cd_usuario);
		$oMovimiento->setDs_movimiento('Disciplinas: '.$_POST ['cd_especialidad']);
		MovimientoQuery::insertarMovimiento($oMovimiento);
		header ( 'Location: ../proyectos/index.php ' ); 
	}else
		header ( 'Location: modificardisciplinas.php?er=1');

} else
	header ( 'Location:../includes/accesodenegado.php' );	