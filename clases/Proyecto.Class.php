<?php

class Proyecto {
	private $cd_proyecto;
	private $ds_titulo;
	private $ds_codigo;
	private $dt_ini;
	private $dt_fin;
	private $dt_inc;
	private $cd_facultad;
	private $ds_facultad;
	private $ds_director;
	private $nu_duracion;
	private $cd_unidad;
	private $ds_unidad;
	private $nu_nivelunidad;
	private $cd_campo;
	private $ds_campo;
	private $ds_codigocampo;
	private $cd_especialidad;
	private $ds_especialidad;
	private $ds_codigoespecialidad;
	private $cd_disciplina;
	private $ds_disciplina;
	private $ds_codigodisciplina;
	private $cd_entidad;
	private $ds_entidad;
	private $ds_linea;
	private $ds_tipo;
	private $bl_altapendiente;
	private $bl_bajapendiente;
	private $cd_estado;
	private $ds_estado;
	private $ds_abstract1;
	private $ds_abstracteng;
	private $ds_abstract2;
	private $ds_clave1;
	private $ds_clave2;
	private $ds_clave3;
	private $ds_clave4;
	private $ds_clave5;
	private $ds_clave6;
	private $ds_claveeng1;
	private $ds_claveeng2;
	private $ds_claveeng3;
	private $ds_claveeng4;
	private $ds_claveeng5;
	private $ds_claveeng6;
	private $bl_transferencia;
	private $ds_marco;
	private $bl_publicar;
	private $bl_notificacion;
	private $ds_cronograma;
	private $ds_aporte;
	private $ds_objectivos;
	private $ds_metodologia;
	private $ds_metas;
	private $ds_antecedentes;
	private $ds_avance;
	private $ds_formacion;
	private $ds_transferencia;
	private $ds_plan;
	private $ds_disponible;
	private $ds_necesario;
	private $ds_fuentes;
	private $nu_ano1;
	private $nu_ano2;
	private $nu_ano3;
	private $nu_ano4;
	private $ds_factibilidad;
	private $nu_consumo1;
	private $nu_consumo2;
	private $nu_consumo3;
	private $nu_consumo4;
	private $nu_servicios1;
	private $nu_servicios2;
	private $nu_servicios3;
	private $nu_servicios4;
	private $nu_bibliografia1;
	private $nu_bibliografia2;
	private $nu_bibliografia3;
	private $nu_bibliografia4;
	private $nu_cientifico1;
	private $nu_cientifico2;
	private $nu_cientifico3;
	private $nu_cientifico4;
	private $nu_computacion1;
	private $nu_computacion2;
	private $nu_computacion3;
	private $nu_computacion4;
	private $nu_otros1;
	private $nu_otros2;
	private $nu_otros3;
	private $nu_otros4;
	private $ds_fondotramite;
	private $fondos;
	private $cd_tipoacredtacion;
	private $ds_tipoacredtacion;
	private $evaluadores;
	//Método constructor


	function Proyecto() {
			
		$this->cd_proyecto = 0;
		$this->ds_titulo = '';
		$this->ds_codigo = '';
		$this->dt_fin = '';
		$this->dt_inc = '';
		$this->dt_ini = '';
		$this->cd_facultad = '0';
		$this->ds_facultad = '';
		$this->ds_director = '';
		$this->nu_duracion = '';
		$this->cd_unidad = '0';
		$this->ds_unidad = '';
		$this->nu_nivelunidad = '';
		$this->cd_campo = '0';
		$this->ds_campo = '';
		$this->ds_codigocampo = '';
		$this->cd_especialidad = '0';
		$this->ds_especialidad = '';
		$this->ds_codigoespecialidad = '';
		$this->cd_disciplina = '0';
		$this->ds_disciplina = '';
		$this->ds_codigodisciplina = '';
		$this->cd_entidad = '0';
		$this->ds_entidad = '';
		$this->ds_linea = '';
		$this->ds_tipo = '';
		$this->bl_altapendiente = 0;
		$this->bl_bajapendiente = 0;
		$this->cd_estado = 0;
		$this->ds_estado = '';
		$this->ds_abstract1 = '';
		$this->ds_abstract2 = '';
		$this->ds_abstracteng = '';
		$this->ds_clave1 = '';
		$this->ds_clave2 = '';
		$this->ds_clave3 = '';
		$this->ds_clave4 = '';
		$this->ds_clave5 = '';
		$this->ds_clave6 = '';
		$this->ds_claveeng1 = '';
		$this->ds_claveeng2 = '';
		$this->ds_claveeng3 = '';
		$this->ds_claveeng4 = '';
		$this->ds_claveeng5 = '';
		$this->ds_claveeng6 = '';
		$this->bl_transferencia = -1;
		$this->ds_marco = '';
		$this->bl_publicar = 1;
		$this->bl_notificacion = 1;
		$this->ds_cronograma = '';
		$this->ds_aporte = '';
		$this->ds_objectivos = '';
		$this->ds_metodologia = '';
		$this->ds_metas = '';
		$this->ds_antecedentes = '';
		$this->ds_avance = '';
		$this->ds_formacion = '';
		$this->ds_transferencia = '';
		$this->ds_plan = '';
		$this->ds_disponible = '';
		$this->ds_necesario = '';
		$this->ds_fuentes = '';
		$this->nu_ano1= '0';
		$this->nu_ano2= '0';
		$this->nu_ano3= '0';
		$this->nu_ano4= '0';
		$this->ds_factibilidad= '';
		$this->nu_consumo1= '0';
		$this->nu_consumo2= '0';
		$this->nu_consumo3= '0';
		$this->nu_consumo4= '0';
		$this->nu_servicios1= '0';
		$this->nu_servicios2= '0';
		$this->nu_servicios3= '0';
		$this->nu_servicios4= '0';
		$this->nu_bibliografia1= '0';
		$this->nu_bibliografia2= '0';
		$this->nu_bibliografia3= '0';
		$this->nu_bibliografia4= '0';
		$this->nu_cientifico1= '0';
		$this->nu_cientifico2= '0';
		$this->nu_cientifico3= '0';
		$this->nu_cientifico4= '0';
		$this->nu_computacion1= '0';
		$this->nu_computacion2= '0';
		$this->nu_computacion3= '0';
		$this->nu_computacion4= '0';
		$this->nu_otros1= '0';
		$this->nu_otros2= '0';
		$this->nu_otros3= '0';
		$this->nu_otros4= '0';
		$this->ds_fondotramite= '';
		$this->fondos= array();
		$this->cd_tipoacredtacion = 0;
		$this->ds_tipoacredtacion = '';
		$this->evaluadores= array();
			
	}

	//Métodos Get


	function getCd_proyecto() {
		return $this->cd_proyecto;
	}

	function getDs_titulo() {
		return $this->ds_titulo;
	}

	function getDs_codigo() {
		return $this->ds_codigo;
	}

	function getDs_facultad() {
		return $this->ds_facultad;
	}

	function getCd_facultad() {
		return $this->cd_facultad;
	}

	function getDt_ini() {
		return $this->dt_ini;
	}

	function getDt_fin() {
		return $this->dt_fin;
	}

	function getDt_inc() {
		return $this->dt_inc;
	}

	function getDs_director() {
		return $this->ds_director;
	}

	function getNu_duracion() {
		return $this->nu_duracion;
	}

	function getCd_unidad() {
		return $this->cd_unidad;
	}

	function getDs_unidad() {
		return $this->ds_unidad;
	}


	function getNu_nivelunidad() {
		return $this->nu_nivelunidad;
	}

	function getCd_campo() {
		return $this->cd_campo;
	}

	function getDs_campo() {
		return $this->ds_campo;
	}

	function getDs_codigocampo() {
		return $this->ds_codigocampo;
	}

	function getCd_especialidad() {
		return $this->cd_especialidad;
	}

	function getDs_especialidad() {
		return $this->ds_especialidad;
	}

	function getDs_codigoespecialidad() {
		return $this->ds_codigoespecialidad;
	}

	function getCd_disciplina() {
		return $this->cd_disciplina;
	}

	function getDs_disciplina() {
		return $this->ds_disciplina;
	}

	function getDs_codigodisciplina() {
		return $this->ds_codigodisciplina;
	}

	function getCd_entidad() {
		return $this->cd_entidad;
	}

	function getDs_entidad() {
		return $this->ds_entidad;
	}

	function getDs_linea() {
		return $this->ds_linea;
	}

	function getDs_tipo() {
		return $this->ds_tipo;
	}

	function getBl_altapendiente() {
		return $this->bl_altapendiente;
	}

	function getBl_bajapendiente() {
		return $this->bl_bajapendiente;
	}

	function getCd_estado() {
		return $this->cd_estado;
	}

	function getDs_estado() {
		return $this->ds_estado;
	}

	function getDs_abstract1() {
		return $this->ds_abstract1;
	}

	function getDs_abstract2() {
		return $this->ds_abstract2;
	}

	function getDs_abstracteng() {
		return $this->ds_abstracteng;
	}

	function getDs_clave1() {
		return $this->ds_clave1;
	}

	function getDs_clave2() {
		return $this->ds_clave2;
	}

	function getDs_clave3() {
		return $this->ds_clave3;
	}

	function getDs_clave4() {
		return $this->ds_clave4;
	}

	function getDs_clave5() {
		return $this->ds_clave5;
	}

	function getDs_clave6() {
		return $this->ds_clave6;
	}

	function getDs_claveeng1() {
		return $this->ds_claveeng1;
	}

	function getDs_claveeng2() {
		return $this->ds_claveeng2;
	}

	function getDs_claveeng3() {
		return $this->ds_claveeng3;
	}

	function getDs_claveeng4() {
		return $this->ds_claveeng4;
	}

	function getDs_claveeng5() {
		return $this->ds_claveeng5;
	}

	function getDs_claveeng6() {
		return $this->ds_claveeng6;
	}

	function getBl_transferencia() {
		return $this->bl_transferencia;
	}

	function getDs_marco() {
		return $this->ds_marco;
	}

	function getBl_publicar() {
		return $this->bl_publicar;
	}

	function getDs_cronograma() {
		return $this->ds_cronograma;
	}

	function getDs_aporte() {
		return $this->ds_aporte;
	}

	function getDs_objetivos() {
		return $this->ds_objectivos;
	}

	function getDs_metodologia() {
		return $this->ds_metodologia;
	}

	function getDs_metas() {
		return $this->ds_metas;
	}

	function getDs_antecedentes() {
		return $this->ds_antecedentes;
	}

	function getDs_avance() {
		return $this->ds_avance;
	}

	function getDs_formacion() {
		return $this->ds_formacion;
	}

	function getDs_transferencia() {
		return $this->ds_transferencia;
	}

	function getDs_plan() {
		return $this->ds_plan;
	}

	function getDs_disponible() {
		return $this->ds_disponible;
	}

	function getDs_necesario() {
		return $this->ds_necesario;
	}

	function getDs_fuentes() {
		return $this->ds_fuentes;
	}

	function getNu_ano1() {
		return $this->nu_ano1;
	}

	function getNu_ano2() {
		return $this->nu_ano2;
	}

	function getNu_ano3() {
		return $this->nu_ano3;
	}

	function getNu_ano4() {
		return $this->nu_ano4;
	}

	function getDs_factibilidad() {
		return $this->ds_factibilidad;
	}

	function getNu_consumo1() {
		return $this->nu_consumo1;
	}

	function getNu_consumo2() {
		return $this->nu_consumo2;
	}

	function getNu_consumo3() {
		return $this->nu_consumo3;
	}

	function getNu_consumo4() {
		return $this->nu_consumo4;
	}

	function getNu_servicios1() {
		return $this->nu_servicios1;
	}

	function getNu_servicios2() {
		return $this->nu_servicios2;
	}

	function getNu_servicios3() {
		return $this->nu_servicios3;
	}

	function getNu_servicios4() {
		return $this->nu_servicios4;
	}

	function getNu_bibliografia1() {
		return $this->nu_bibliografia1;
	}

	function getNu_bibliografia2() {
		return $this->nu_bibliografia2;
	}

	function getNu_bibliografia3() {
		return $this->nu_bibliografia3;
	}

	function getNu_bibliografia4() {
		return $this->nu_bibliografia4;
	}

	function getNu_cientifico1() {
		return $this->nu_cientifico1;
	}

	function getNu_cientifico2() {
		return $this->nu_cientifico2;
	}

	function getNu_cientifico3() {
		return $this->nu_cientifico3;
	}

	function getNu_cientifico4() {
		return $this->nu_cientifico4;
	}

	function getNu_computacion1() {
		return $this->nu_computacion1;
	}

	function getNu_computacion2() {
		return $this->nu_computacion2;
	}

	function getNu_computacion3() {
		return $this->nu_computacion3;
	}

	function getNu_computacion4() {
		return $this->nu_computacion4;
	}

	function getNu_otros1() {
		return $this->nu_otros1;
	}

	function getNu_otros2() {
		return $this->nu_otros2;
	}

	function getNu_otros3() {
		return $this->nu_otros3;
	}

	function getNu_otros4() {
		return $this->nu_otros4;
	}

	function getDs_fondotramite() {
		return $this->ds_fondotramite;
	}

	function getFondos() {
		return $this->fondos;
	}

	function getCd_tipoacreditacion() {
		return $this->cd_tipoacredtacion;
	}

	function getDs_tipoacreditacion() {
		return $this->ds_tipoacredtacion;
	}

	function getEvaluadores() {
		return $this->evaluadores;
	}



	//Métodos Set


	function setCd_proyecto($value) {
		$this->cd_proyecto = $value;
	}

	function setDs_titulo($value) {
		$this->ds_titulo = $value;
	}

	function setDs_codigo($value) {
		$this->ds_codigo = $value;
	}

	function setDs_facultad($value) {
		$this->ds_facultad = $value;
	}

	function setCd_facultad($value) {
		$this->cd_facultad = $value;
	}

	function setDt_ini($value) {
		$this->dt_ini = $value;
	}

	function setDt_fin($value) {
		$this->dt_fin = $value;
	}

	function setDt_inc($value) {
		$this->dt_inc = $value;
	}

	function setDs_director($value) {
		$this->ds_director = $value;
	}

	function setNu_duracion($value) {
		$this->nu_duracion = $value;
	}

	function setCd_unidad($value) {
		$this->cd_unidad = $value;
	}

	function setDs_unidad($value) {
		$this->ds_unidad = $value;
	}

	function setNu_nivelunidad($value) {
		$this->nu_nivelunidad = $value;
	}

	function setCd_campo($value) {
		$this->cd_campo = $value;
	}

	function setDs_campo($value) {
		$this->ds_campo = $value;
	}

	function setDs_codigocampo($value) {
		$this->ds_codigocampo = $value;
	}

	function setCd_especialidad($value) {
		$this->cd_especialidad = $value;
	}

	function setDs_especialidad($value) {
		$this->ds_especialidad = $value;
	}

	function setDs_codigoespecialidad($value) {
		$this->ds_codigoespecialidad = $value;
	}

	function setCd_disciplina($value) {
		$this->cd_disciplina = $value;
	}

	function setDs_disciplina($value) {
		$this->ds_disciplina = $value;
	}

	function setDs_codigodisciplina($value) {
		$this->ds_codigodisciplina = $value;
	}

	function setCd_entidad($value) {
		$this->cd_entidad = $value;
	}

	function setDs_entidad($value) {
		$this->ds_entidad = $value;
	}

	function setDs_linea($value) {
		$this->ds_linea = $value;
	}

	function setDs_tipo($value) {
		$this->ds_tipo = $value;
	}
		
	function setBl_altapendiente($value) {
		$this->bl_altapendiente = $value;
	}

	function setBl_bajapendiente($value) {
		$this->bl_bajapendiente = $value;
	}

	function setCd_estado($value) {
		$this->cd_estado = $value;
	}

	function setDs_estado($value) {
		$this->ds_estado = $value;
	}

	function setDs_abstract1($value) {
		$this->ds_abstract1 = $value;
	}

	function setDs_abstract2($value) {
		$this->ds_abstract2 = $value;
	}

	function setDs_abstracteng($value) {
		$this->ds_abstracteng = $value;
	}

	function setDs_clave1($value) {
		$this->ds_clave1 = $value;
	}

	function setDs_clave2($value) {
		$this->ds_clave2 = $value;
	}

	function setDs_clave3($value) {
		$this->ds_clave3 = $value;
	}

	function setDs_clave4($value) {
		$this->ds_clave4 = $value;
	}

	function setDs_clave5($value) {
		$this->ds_clave5 = $value;
	}

	function setDs_clave6($value) {
		$this->ds_clave6 = $value;
	}

	function setDs_claveeng1($value) {
		$this->ds_claveeng1 = $value;
	}

	function setDs_claveeng2($value) {
		$this->ds_claveeng2 = $value;
	}

	function setDs_claveeng3($value) {
		$this->ds_claveeng3 = $value;
	}

	function setDs_claveeng4($value) {
		$this->ds_claveeng4 = $value;
	}

	function setDs_claveeng5($value) {
		$this->ds_claveeng5 = $value;
	}

	function setDs_claveeng6($value) {
		$this->ds_claveeng6 = $value;
	}

	function setBl_transferencia($value) {
		$this->bl_transferencia = $value;
	}

	function setDs_marco($value) {
		$this->ds_marco = $value;
	}

	function setBl_publicar($value) {
		$this->bl_publicar = $value;
	}

	function setDs_cronograma($value) {
		$this->ds_cronograma = $value;
	}

	function setDs_aporte($value) {
		$this->ds_aporte = $value;
	}

	function setDs_objetivos($value) {
		$this->ds_objectivos = $value;
	}

	function setDs_metodologia($value) {
		$this->ds_metodologia = $value;
	}

	function setDs_metas($value) {
		$this->ds_metas = $value;
	}

	function setDs_antecedentes($value) {
		$this->ds_antecedentes = $value;
	}

	function setDs_avance($value) {
		$this->ds_avance = $value;
	}

	function setDs_formacion($value) {
		$this->ds_formacion = $value;
	}

	function setDs_transferencia($value) {
		$this->ds_transferencia = $value;
	}

	function setDs_plan($value) {
		$this->ds_plan = $value;
	}

	function setDs_disponible($value) {
		$this->ds_disponible = $value;
	}

	function setDs_necesario($value) {
		$this->ds_necesario = $value;
	}

	function setDs_fuentes($value) {
		$this->ds_fuentes = $value;
	}

	function setNu_ano1($value) {
		$this->nu_ano1 = $value;
	}

	function setNu_ano2($value) {
		$this->nu_ano2 = $value;
	}

	function setNu_ano3($value) {
		$this->nu_ano3 = $value;
	}

	function setNu_ano4($value) {
		$this->nu_ano4 = $value;
	}

	function setDs_factibilidad($value) {
		$this->ds_factibilidad = $value;
	}

	function setNu_consumo1($value) {
		$this->nu_consumo1 = $value;
	}

	function setNu_consumo2($value) {
		$this->nu_consumo2 = $value;
	}

	function setNu_consumo3($value) {
		$this->nu_consumo3 = $value;
	}

	function setNu_consumo4($value) {
		$this->nu_consumo4 = $value;
	}

	function setNu_servicios1($value) {
		$this->nu_servicios1 = $value;
	}

	function setNu_servicios2($value) {
		$this->nu_servicios2 = $value;
	}

	function setNu_servicios3($value) {
		$this->nu_servicios3 = $value;
	}

	function setNu_servicios4($value) {
		$this->nu_servicios4 = $value;
	}

	function setNu_bibliografia1($value) {
		$this->nu_bibliografia1 = $value;
	}

	function setNu_bibliografia2($value) {
		$this->nu_bibliografia2 = $value;
	}

	function setNu_bibliografia3($value) {
		$this->nu_bibliografia3 = $value;
	}

	function setNu_bibliografia4($value) {
		$this->nu_bibliografia4 = $value;
	}

	function setNu_cientifico1($value) {
		$this->nu_cientifico1 = $value;
	}

	function setNu_cientifico2($value) {
		$this->nu_cientifico2 = $value;
	}

	function setNu_cientifico3($value) {
		$this->nu_cientifico3 = $value;
	}

	function setNu_cientifico4($value) {
		$this->nu_cientifico4 = $value;
	}

	function setNu_computacion1($value) {
		$this->nu_computacion1 = $value;
	}

	function setNu_computacion2($value) {
		$this->nu_computacion2 = $value;
	}

	function setNu_computacion3($value) {
		$this->nu_computacion3 = $value;
	}

	function setNu_computacion4($value) {
		$this->nu_computacion4 = $value;
	}

	function setNu_otros1($value) {
		$this->nu_otros1 = $value;
	}

	function setNu_otros2($value) {
		$this->nu_otros2 = $value;
	}

	function setNu_otros3($value) {
		$this->nu_otros3 = $value;
	}

	function setNu_otros4($value) {
		$this->nu_otros4 = $value;
	}

	function setFondos($value, $i, $campo) {
		$this->fondos[$i][$campo] = $value;
	}

	function setDs_fondotramite($value) {
		$this->ds_fondotramite = $value;
	}

	function iniFondos() {
		$this->fondos = array();
	}

	function setCd_tipoacreditacion($value) {
		$this->cd_tipoacredtacion = $value;
	}

	function setDs_tipoacreditacion($value) {
		$this->ds_tipoacredtacion = $value;
	}

	function setEvaluadores($value, $i, $campo) {
		$this->evaluadores[$i][$campo] = $value;
	}



	function iniEvaluadores() {
		$this->evaluadores = array();
	}





	public function getBl_notificacion()
	{
		return $this->bl_notificacion;
	}

	public function setBl_notificacion($bl_notificacion)
	{
		$this->bl_notificacion = $bl_notificacion;
	}
}

