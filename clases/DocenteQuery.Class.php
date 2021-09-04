<?php
class DocenteQuery {

	function getDocentePorDocumento(Docente $obj) {
		$db = Db::conectar ();
		$nu_documento = $obj->getNu_documento ();
		$sql = "SELECT D.*, ds_categoria, ds_facultad, ds_cargo, ds_deddoc, ds_universidad, ds_titulo, ds_carrerainv, ds_organismo, ds_unidad, ds_provincia FROM docente D LEFT JOIN categoria C ON D.cd_categoria = C.cd_categoria LEFT JOIN facultad F ON D.cd_facultad = F.cd_facultad LEFT JOIN cargosipi CA ON D.cd_cargo = CA.cd_cargo LEFT JOIN deddoc DD ON D.cd_deddoc = DD.cd_deddoc LEFT JOIN universidad U ON D.cd_universidad = U.cd_universidad LEFT JOIN carrerainv CI ON D.cd_carrerainv = CI.cd_carrerainv LEFT JOIN organismo O ON D.cd_organismo = O.cd_organismo LEFT JOIN titulo T on D.cd_titulo = T.cd_titulo LEFT JOIN unidad UN on D.cd_unidad = UN.cd_unidad LEFT JOIN provincia P ON D.cd_provincia = P.cd_provincia WHERE nu_documento = $nu_documento";
		$result = $db->sql_query ( $sql );
		if ($db->sql_numrows () > 0) {
			$tc = $db->sql_fetchassoc ( $result );
			$obj->setNu_ident ( $tc ['nu_ident'] );
			$obj->setCd_docente ( $tc ['cd_docente'] );
			$obj->setDs_nombre ( $tc ['ds_nombre'] );
			$obj->setDs_apellido ( $tc ['ds_apellido'] );
			$obj->setNu_precuil ( $tc ['nu_precuil'] );
			$obj->setNu_documento ( $tc ['nu_documento'] );
			$obj->setNu_postcuil ( $tc ['nu_postcuil'] );
			$obj->setDt_nacimiento ( $tc ['dt_nacimiento'] );
			$obj->setDs_sexo ( $tc ['ds_sexo'] );
			$obj->setDs_calle ( $tc ['ds_calle'] );
			$obj->setNu_nro ( $tc ['nu_nro'] );
			$obj->setNu_piso ( $tc ['nu_piso'] );
			$obj->setDs_depto ( $tc ['ds_depto'] );
			$obj->setDs_localidad ( $tc ['ds_localidad'] );
			$obj->setCd_provincia ( $tc ['cd_provincia'] );
			$obj->setDs_provincia ( $tc ['ds_provincia'] );
			$obj->setNu_cp ( $tc ['nu_cp'] );
			$obj->setNu_telefono ( $tc ['nu_telefono'] );
			$obj->setDs_mail ( $tc ['ds_mail'] );
			$obj->setCd_categoria ( $tc ['cd_categoria'] );
			$obj->setDs_categoria ( $tc ['ds_categoria'] );
			$obj->setNu_dedinv ( $tc ['nu_dedinv'] );
			$obj->setNu_horasinv ( $tc ['nu_horasinv'] );
			$obj->setNu_semanasinv ( $tc ['nu_semanasinv'] );
			$obj->setNu_horasspu ( $tc ['nu_horasspu'] );
			$obj->setNu_semanasspu ( $tc ['nu_semanasspu'] );
			$obj->setCd_facultad ( $tc ['cd_facultad'] );
			$obj->setDs_facultad ( $tc ['ds_facultad'] );
			$obj->setCd_cargo ( $tc ['cd_cargo'] );
			$obj->setDs_cargo ( $tc ['ds_cargo'] );
			$obj->setCd_deddoc ( $tc ['cd_deddoc'] );
			$obj->setDs_deddoc ( $tc ['ds_deddoc'] );
			$obj->setNu_horasdoc1c ( $tc ['nu_horasdoc1c'] );
			$obj->setNu_semanasdoc1c ( $tc ['nu_semanasdoc1c'] );
			$obj->setNu_horasdoc2c ( $tc ['nu_horasdoc2c'] );
			$obj->setNu_semanasdoc2c ( $tc ['nu_semanasdoc2c'] );
			$obj->setCd_universidad ( $tc ['cd_universidad'] );
			$obj->setDs_universidad ( $tc ['ds_universidad'] );
			$obj->setCd_titulo ( $tc ['cd_titulo'] );
			$obj->setCd_titulopost ( $tc ['cd_titulopost'] );
			$obj->setDs_titulo ( $tc ['ds_titulo'] );
			$obj->setDs_codigootro ( $tc ['ds_codigootro'] );
			$obj->setDs_titulootro ( $tc ['ds_titulootro'] );
			$obj->setDs_duracionotro ( $tc ['ds_duracionotro'] );
			$obj->setNu_horasotro( $tc ['nu_horasotro'] );
			$obj->setDs_unidad( $tc ['ds_unidad'] );
			$obj->setCd_unidad( $tc ['cd_unidad'] );
			$obj->setNu_nivelunidad( $tc ['nu_nivelunidad'] );
			$obj->setCd_carrerainv ( $tc ['cd_carrerainv'] );
			$obj->setDs_carrerainv( $tc ['ds_carrerainv'] );
			$obj->setCd_organismo( $tc ['cd_organismo'] );
			$obj->setDs_organismo( $tc ['ds_organismo'] );
			$obj->setBl_becario( $tc ['bl_becario'] );
			$obj->setDs_tipobeca( $tc ['ds_tipobeca'] );
			$obj->setDs_orgbeca( $tc ['ds_orgbeca'] );
			$obj->setBl_director( $tc ['bl_director'] );
			$obj->setDt_cargo( $tc ['dt_cargo'] );
		}
		$db->sql_close;
		return ($result);
	}

	function getDocentesPorApellido(Docente $obj) {
		$db = Db::conectar ();
		$ds_apellido = $obj->getDs_apellido();
		$apellido = explode ( ",", $ds_apellido );
		if (count($apellido)==1) {
			$ds_apellido = str_replace(' ','%',$ds_apellido);
			$ds_nombre ='%%';
		}
		else{
			$ds_apellido = str_replace(' ','%',$apellido[0]);
			$ds_nombre = str_replace(' ','%',$apellido[1]);
		}

		 
		$sql = "SELECT D. *
                        FROM docente D
                        WHERE  D.ds_apellido LIKE '%$ds_apellido%' AND  D.ds_nombre LIKE '%$ds_nombre%' ORDER BY D.ds_apellido, D.ds_nombre";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $tc = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('nu_ident' => $tc ['nu_ident'], 'cd_docente' => $tc ['cd_docente'], 'ds_nombre' => $tc ['ds_nombre'], 'ds_apellido' => $tc ['ds_apellido'], 'nu_precuil' => $tc ['nu_precuil'], 'nu_documento' => $tc ['nu_documento'], 'nu_postcuil' => $tc ['nu_postcuil'] );
				$i ++;
			}
		}

		$db->sql_close;
		return ($res);
	}


	function getDocentePorId(Docente $obj) {
		$db = Db::conectar ();
		$cd_docente = $obj->getCd_docente();
		$sql = "SELECT D.*, ds_categoria, ds_facultad, ds_cargo, ds_deddoc, ds_universidad, ds_titulo, ds_carrerainv, ds_organismo, ds_unidad, ds_provincia FROM docente D LEFT JOIN categoria C ON D.cd_categoria = C.cd_categoria LEFT JOIN facultad F ON D.cd_facultad = F.cd_facultad LEFT JOIN cargo CA ON D.cd_cargo = CA.cd_cargo LEFT JOIN deddoc DD ON D.cd_deddoc = DD.cd_deddoc LEFT JOIN universidad U ON D.cd_universidad = U.cd_universidad LEFT JOIN carrerainv CI ON D.cd_carrerainv = CI.cd_carrerainv LEFT JOIN organismo O ON D.cd_organismo = O.cd_organismo LEFT JOIN titulo T on D.cd_titulo = T.cd_titulo LEFT JOIN unidad UN on D.cd_unidad = UN.cd_unidad LEFT JOIN provincia P ON D.cd_provincia = P.cd_provincia WHERE cd_docente = $cd_docente";
		$result = $db->sql_query ( $sql );
		if ($db->sql_numrows () > 0) {
			$tc = $db->sql_fetchassoc ( $result );
			$obj->setNu_ident ( $tc ['nu_ident'] );
			$obj->setDs_nombre ( $tc ['ds_nombre'] );
			$obj->setDs_apellido ( $tc ['ds_apellido'] );
			$obj->setNu_precuil ( $tc ['nu_precuil'] );
			$obj->setNu_documento ( $tc ['nu_documento'] );
			$obj->setNu_postcuil ( $tc ['nu_postcuil'] );
			$obj->setDt_nacimiento ( $tc ['dt_nacimiento'] );
			$obj->setDs_sexo ( $tc ['ds_sexo'] );
			$obj->setDs_calle ( $tc ['ds_calle'] );
			$obj->setNu_nro ( $tc ['nu_nro'] );
			$obj->setNu_piso ( $tc ['nu_piso'] );
			$obj->setDs_depto ( $tc ['ds_depto'] );
			$obj->setDs_localidad ( $tc ['ds_localidad'] );
			$obj->setCd_provincia ( $tc ['cd_provincia'] );
			$obj->setDs_provincia ( $tc ['ds_provincia'] );
			$obj->setNu_cp ( $tc ['nu_cp'] );
			$obj->setNu_telefono ( $tc ['nu_telefono'] );
			$obj->setDs_mail ( $tc ['ds_mail'] );
			$obj->setCd_categoria ( $tc ['cd_categoria'] );
			$obj->setDs_categoria ( $tc ['ds_categoria'] );
			$obj->setNu_dedinv ( $tc ['nu_dedinv'] );
			$obj->setNu_horasinv ( $tc ['nu_horasinv'] );
			$obj->setNu_semanasinv ( $tc ['nu_semanasinv'] );
			$obj->setNu_horasspu ( $tc ['nu_horasspu'] );
			$obj->setNu_semanasspu ( $tc ['nu_semanasspu'] );
			$obj->setCd_facultad ( $tc ['cd_facultad'] );
			$obj->setDs_facultad ( $tc ['ds_facultad'] );
			$obj->setCd_cargo ( $tc ['cd_cargo'] );
			$obj->setDs_cargo ( $tc ['ds_cargo'] );
			$obj->setCd_deddoc ( $tc ['cd_deddoc'] );
			$obj->setDs_deddoc ( $tc ['ds_deddoc'] );
			$obj->setNu_horasdoc1c ( $tc ['nu_horasdoc1c'] );
			$obj->setNu_semanasdoc1c ( $tc ['nu_semanasdoc1c'] );
			$obj->setNu_horasdoc2c ( $tc ['nu_horasdoc2c'] );
			$obj->setNu_semanasdoc2c ( $tc ['nu_semanasdoc2c'] );
			$obj->setCd_universidad ( $tc ['cd_universidad'] );
			$obj->setDs_universidad ( $tc ['ds_universidad'] );
			$obj->setCd_titulopost ( $tc ['cd_titulopost'] );
			$obj->setCd_titulo ( $tc ['cd_titulo'] );
			$obj->setDs_titulo ( $tc ['ds_titulo'] );
			$obj->setDs_codigootro ( $tc ['ds_codigootro'] );
			$obj->setDs_titulootro ( $tc ['ds_titulootro'] );
			$obj->setDs_duracionotro ( $tc ['ds_duracionotro'] );
			$obj->setNu_horasotro( $tc ['nu_horasotro'] );
			$obj->setDs_unidad( $tc ['ds_unidad'] );
			$obj->setCd_unidad( $tc ['cd_unidad'] );
			$obj->setNu_nivelunidad( $tc ['nu_nivelunidad'] );
			$obj->setCd_carrerainv ( $tc ['cd_carrerainv'] );
			$obj->setDs_carrerainv( $tc ['ds_carrerainv'] );
			$obj->setCd_organismo( $tc ['cd_organismo'] );
			$obj->setDs_organismo( $tc ['ds_organismo'] );
			$obj->setBl_becario( $tc ['bl_becario'] );
			$obj->setDs_tipobeca( $tc ['ds_tipobeca'] );
			$obj->setDs_orgbeca( $tc ['ds_orgbeca'] );
			$obj->setBl_director( $tc ['bl_director'] );
			$obj->setDt_cargo( $tc ['dt_cargo'] );
		}
		$db->sql_close;
		return ($result);
	}




	function insertarDocente(Docente $obj) {
		$db = Db::conectar ();
		$id = DocenteQuery::insert_id ( $db );
		$obj->setCd_docente ( $id+1 );
		$cd_docente = $obj->getCd_docente();
		$nu_ident= $obj->getNu_ident();
		$ds_nombre= $obj->getDs_nombre();
		$ds_apellido= $obj->getDs_apellido();
		$nu_precuil= $obj->getNu_precuil();
		$nu_documento= $obj->getNu_documento();
		$nu_postcuil= $obj->getNu_postcuil();
		$dt_nacimiento= $obj->getDt_nacimiento();
		$ds_sexo= $obj->getDs_sexo();
		$ds_calle= $obj->getDs_calle();
		$nu_nro= $obj->getNu_nro();
		$nu_piso= $obj->getNu_piso();
		$ds_depto= $obj->getDs_depto();
		$cd_provincia= $obj->getCd_provincia();
		$ds_localidad= $obj->getDs_localidad();
		$nu_cp= $obj->getNu_cp();
		$nu_telefono= $obj->getNu_telefono();
		$ds_mail= $obj->getDs_mail();
		$cd_categoria= ($obj->getCd_categoria())?$obj->getCd_categoria():1;
		$nu_dedinv= $obj->getNu_dedinv();
		$cd_carrerainv= (($obj->getCd_carrerainv())&&($obj->getCd_carrerainv()!=12))?$obj->getCd_carrerainv():11;
		$cd_organismo= ($obj->getCd_organismo())?$obj->getCd_organismo():7;
		$nu_horasinv= $obj->getNu_horasinv();
		$nu_semanasinv= $obj->getNu_semanasinv();
		$nu_horasspu= $obj->getNu_horasspu();
		$nu_semanasspu= $obj->getNu_semanasspu();
		$cd_facultad= ($obj->getCd_facultad())?$obj->getCd_facultad():574;
		$cd_cargo= ($obj->getCd_cargo())?$obj->getCd_cargo():6;
		$cd_deddoc= ($obj->getCd_deddoc())?$obj->getCd_deddoc():4;
		$nu_horasdoc1c= $obj->getNu_horasdoc1c();
		$nu_semanasdoc1c= $obj->getNu_semanasdoc1c();
		$nu_horasdoc2c= $obj->getNu_horasdoc2c();
		$nu_semanasdoc2c= $obj->getNu_semanasdoc2c();
		$cd_universidad= $obj->getCd_universidad();
		$cd_titulo= ($obj->getCd_titulo())?$obj->getCd_titulo():9999;
		$cd_titulopost= ($obj->getCd_titulopost())?$obj->getCd_titulopost():9999;
		$ds_titulootro= $obj->getDs_titulootro();
		$ds_codigootro= $obj->getDs_codigootro();
		$ds_duracionotro= $obj->getDs_duracionotro();
		$nu_horasotro= $obj->getNu_horasotro();
		$cd_unidad= $obj->getCd_unidad();
		$nu_nivelunidad= $obj->getNu_nivelunidad();
		$bl_becario= $obj->getBl_becario();
		$ds_tipobeca= $obj->getDs_tipobeca();
		$ds_orgbeca= $obj->getDs_orgbeca();
		$cd_tipomodificacion= $obj->getCd_tipomodificacion();
		$bl_director= $obj->getBl_director();
		$dt_cargo= $obj->getDt_cargo();
		$sql = "INSERT INTO docente
		(cd_docente, nu_ident, ds_nombre, ds_apellido, nu_precuil, nu_documento, nu_postcuil, dt_nacimiento, ds_sexo, ds_calle,	nu_nro, nu_piso, ds_depto, ds_localidad, cd_provincia, nu_cp, nu_telefono, ds_mail, cd_categoria, nu_dedinv, cd_carrerainv, cd_organismo, nu_horasinv,	nu_semanasinv, nu_horasspu,	nu_semanasspu, cd_facultad, cd_cargo, cd_deddoc, nu_horasdoc1c, nu_semanasdoc1c, nu_horasdoc2c, nu_semanasdoc2c, cd_universidad, cd_titulo, cd_titulopost, ds_titulootro, ds_codigootro, ds_duracionotro, nu_horasotro, cd_unidad, nu_nivelunidad, bl_becario, ds_tipobeca, ds_orgbeca, cd_tipomodificacion, bl_director, dt_cargo) VALUES 
		('$cd_docente', '$nu_ident', '$ds_nombre', '$ds_apellido', '$nu_precuil', '$nu_documento', '$nu_postcuil', '$dt_nacimiento', '$ds_sexo', '$ds_calle', '$nu_nro', '$nu_piso', '$ds_depto', '$ds_localidad', '$cd_provincia',	'$nu_cp', '$nu_telefono', '$ds_mail', '$cd_categoria', '$nu_dedinv', '$cd_carrerainv', '$cd_organismo', '$nu_horasinv', '$nu_semanasinv', '$nu_horasspu',	'$nu_semanasspu', '$cd_facultad', '$cd_cargo', '$cd_deddoc', '$nu_horasdoc1c',	'$nu_semanasdoc1c',	'$nu_horasdoc2c', '$nu_semanasdoc2c', '$cd_universidad', '$cd_titulo', '$cd_titulopost', '$ds_titulootro', '$ds_codigootro', '$ds_duracionotro', '$nu_horasotro', '$cd_unidad', '$nu_nivelunidad', '$bl_becario', '$ds_tipobeca', '$ds_orgbeca', '$cd_tipomodificacion', '$bl_director', '$dt_cargo') ";
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;
	}

	function eliminarDocente(Docente $obj){
		$db = Db::conectar ();
		$cd_docente = $obj->getCd_docente ();
		$sql = "DELETE FROM docente WHERE cd_docente = $cd_docente";
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;
	}

	function modificarDocente(Docente $obj){
		$db = Db::conectar ();
		$cd_docente = $obj->getCd_docente();
		$nu_ident= $obj->getNu_ident();
		$ds_nombre= $obj->getDs_nombre();
		$ds_apellido= $obj->getDs_apellido();
		$nu_precuil= $obj->getNu_precuil();
		$nu_documento= $obj->getNu_documento();
		$nu_postcuil= $obj->getNu_postcuil();
		$dt_nacimiento= $obj->getDt_nacimiento();
		$ds_sexo= $obj->getDs_sexo();
		$ds_calle= $obj->getDs_calle();
		$nu_nro= $obj->getNu_nro();
		$nu_piso= $obj->getNu_piso();
		$ds_depto= $obj->getDs_depto();
		$cd_provincia= $obj->getCd_provincia();
		$ds_localidad= $obj->getDs_localidad();
		$nu_cp= $obj->getNu_cp();
		$nu_telefono= $obj->getNu_telefono();
		$ds_mail= $obj->getDs_mail();
		$cd_categoria= ($obj->getCd_categoria())?$obj->getCd_categoria():1;
		$nu_dedinv= $obj->getNu_dedinv();
		$cd_carrerainv= (($obj->getCd_carrerainv())&&($obj->getCd_carrerainv()!=12))?$obj->getCd_carrerainv():11;
		$cd_organismo= ($obj->getCd_organismo())?$obj->getCd_organismo():7;
		$nu_horasinv= $obj->getNu_horasinv();
		$nu_semanasinv= $obj->getNu_semanasinv();
		$nu_horasspu= $obj->getNu_horasspu();
		$nu_semanasspu= $obj->getNu_semanasspu();
		$cd_facultad= ($obj->getCd_facultad())?$obj->getCd_facultad():574;
		$cd_cargo= ($obj->getCd_cargo())?$obj->getCd_cargo():6;
		$cd_deddoc= ($obj->getCd_deddoc())?$obj->getCd_deddoc():4;
		$nu_horasdoc1c= $obj->getNu_horasdoc1c();
		$nu_semanasdoc1c= $obj->getNu_semanasdoc1c();
		$nu_horasdoc2c= $obj->getNu_horasdoc2c();
		$nu_semanasdoc2c= $obj->getNu_semanasdoc2c();
		$cd_universidad= $obj->getCd_universidad();
		$cd_titulo= ($obj->getCd_titulo())?$obj->getCd_titulo():9999;
		$cd_titulopost= ($obj->getCd_titulopost())?$obj->getCd_titulopost():9999;
		$ds_titulootro= $obj->getDs_titulootro();
		$ds_codigootro= $obj->getDs_codigootro();
		$ds_duracionotro= $obj->getDs_duracionotro();
		$nu_horasotro= $obj->getNu_horasotro();
		$cd_unidad= $obj->getCd_unidad();
		$nu_nivelunidad= $obj->getNu_nivelunidad();
		$bl_becario= $obj->getBl_becario();
		$ds_tipobeca= $obj->getDs_tipobeca();
		$ds_orgbeca= $obj->getDs_orgbeca();
		$cd_tipomodificacion= $obj->getCd_tipomodificacion();
		$bl_director= $obj->getBl_director();
		$dt_cargo= $obj->getDt_cargo();
		$sql = "UPDATE docente SET cd_docente='$cd_docente', nu_ident='$nu_ident', ds_nombre='$ds_nombre', ds_apellido='$ds_apellido', nu_precuil='$nu_precuil', nu_documento='$nu_documento', nu_postcuil='$nu_postcuil', dt_nacimiento='$dt_nacimiento', ds_sexo='$ds_sexo', ds_calle='$ds_calle', nu_nro='$nu_nro', nu_piso= '$nu_piso', ds_depto='$ds_depto', ds_localidad='$ds_localidad', cd_provincia='$cd_provincia', nu_cp='$nu_cp', nu_telefono='$nu_telefono', ds_mail='$ds_mail', cd_categoria='$cd_categoria', nu_dedinv='$nu_dedinv', cd_carrerainv='$cd_carrerainv', cd_organismo='$cd_organismo', nu_horasinv='$nu_horasinv', nu_semanasinv='$nu_semanasinv', nu_horasspu='$nu_horasspu', nu_semanasspu='$nu_semanasspu', cd_facultad='$cd_facultad', cd_cargo='$cd_cargo', cd_deddoc='$cd_deddoc', nu_horasdoc1c='$nu_horasdoc1c',	nu_semanasdoc1c='$nu_semanasdoc1c',	nu_horasdoc2c='$nu_horasdoc2c', nu_semanasdoc2c='$nu_semanasdoc2c', cd_universidad='$cd_universidad', cd_titulo='$cd_titulo', cd_titulopost='$cd_titulopost', ds_titulootro='$ds_titulootro', ds_codigootro='$ds_codigootro', ds_duracionotro='$ds_duracionotro', nu_horasotro='$nu_horasotro', cd_unidad='$cd_unidad', nu_nivelunidad='$nu_nivelunidad', bl_becario='$bl_becario', ds_tipobeca='$ds_tipobeca', ds_orgbeca='$ds_orgbeca', cd_tipomodificacion='$cd_tipomodificacion', bl_director='$bl_director', dt_cargo='$dt_cargo'";
		$sql .= " WHERE cd_docente = $cd_docente";
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;
	}

	function insert_id($db) {
		$sql = "SELECT MAX(cd_docente) FROM docente ";
		$result = $db->sql_query ( $sql );
		$id = $db->sql_fetchrow ( $result, 0 );
		return ($id [0]);
	}

	function insertarAux(Docente $obj) {
		$db = Db::conectar ();

		$apellido = $obj->getDs_apellido();
		$nombre =$obj->getDs_nombre();
		$cuil = $obj->getNu_documento();
		$cat = $obj->getDs_categoria();

		$sql = "INSERT INTO auxiliar (apellido, nombre, cuil, cat) VALUES ('$apellido', '$nombre', '$cuil', '$cat') ";
		$result = $db->sql_query ( $sql );


		$db->sql_close;
		return $result;
	}

	function getModificados($cd_tipoacreditacion){

		$year = $_SESSION ["nu_yearSession"];
		$sql = "SELECT DISTINCT ds_nombre,ds_apellido,nu_ident,nu_precuil,nu_documento,nu_postcuil,dt_nacimiento,ds_sexo,ds_calle,nu_nro,nu_piso,ds_depto,ds_localidad,cd_provincia,nu_cp,nu_telefono,D.ds_mail,cd_categoria,nu_dedinv,cd_carrerainv,cd_organismo,D.cd_facultad,C.cd_cargosipi As cd_cargo,cd_deddoc,cd_titulo,cd_titulopost, U.ds_codigo, TM.ds_tipomodificacion, I.cd_tipoinvestigador, D.cd_universidad, P.ds_codigo as ds_proyecto FROM docente as D LEFT JOIN cargo AS C ON D.cd_cargo = C.cd_cargo LEFT JOIN unidad AS U ON D.cd_unidad = U.cd_unidad";
		$sql .= " INNER JOIN integrante AS I ON D.cd_docente = I.cd_docente LEFT JOIN tipomodificacion AS TM ON D.cd_tipomodificacion = TM.cd_tipomodificacion INNER JOIN proyecto P ON I.cd_proyecto = P.cd_proyecto";
		$sql .= " WHERE P.cd_estado = 5 AND P.dt_ini = '".$year."-01-01' AND P.cd_tipoacreditacion = $cd_tipoacreditacion";

		$db = Db::conectar ();
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('ds_nombre' => $usr ['ds_nombre'], 'ds_apellido' => $usr ['ds_apellido'], 'nu_precuil' => $usr ['nu_precuil'], 'nu_documento' => $usr ['nu_documento'], 'nu_postcuil' => $usr ['nu_postcuil'], 'dt_nacimiento' => $usr ['dt_nacimiento'], 'ds_sexo' => $usr ['ds_sexo'],'ds_calle'=> $usr ['ds_calle'],'nu_nro'=> intval($usr ['nu_nro']),'nu_piso'=> intval($usr ['nu_piso']),'ds_depto'=> $usr ['ds_depto'],'ds_localidad'=> $usr ['ds_localidad'],'cd_provincia'=> $usr ['cd_provincia'],'nu_cp'=> $usr ['nu_cp'],'nu_telefono'=> $usr ['nu_telefono'],'ds_mail'=> $usr ['ds_mail'],'cd_categoria'=> $usr ['cd_categoria'],'nu_dedinv'=> $usr ['nu_dedinv'],'cd_carrerainv'=> $usr ['cd_carrerainv'],'cd_organismo'=> $usr ['cd_organismo'],'cd_facultad'=> $usr ['cd_facultad'],'cd_cargo'=> $usr ['cd_cargo'],'cd_deddoc'=> $usr ['cd_deddoc'],'cd_titulo'=> $usr ['cd_titulo'],'cd_titulopost'=> $usr ['cd_titulopost'], 'ds_codigo'=> $usr ['ds_codigo'], 'ds_tipomodificacion'=> $usr ['ds_tipomodificacion'], 'cd_tipoinvestigador'=> $usr ['cd_tipoinvestigador'], 'cd_universidad'=> $usr ['cd_universidad'], 'nu_ident' => $usr ['nu_ident'], 'ds_proyecto' => $usr ['ds_proyecto']);
				$i ++;
			}
		}
		$db->sql_close;
		return ($res);
	}



}
?>