<?php

class Docente {
	private $cd_docente;
	private $nu_ident;
	private $ds_nombre;
	private $ds_apellido;
	private $nu_precuil;
	private $nu_documento;
	private $nu_postcuil;
	private $dt_nacimiento;
	private $ds_sexo;
	private $ds_calle;
	private $nu_nro;
	private $nu_piso;
	private $ds_depto;
	private $ds_localidad;
	private $cd_provincia;
	private $ds_provincia;
	private $nu_cp;
	private $nu_telefono;
	private $ds_mail;
	private $cd_categoria;
	private $ds_categoria;
	private $nu_dedinv;
	private $cd_carrerainv;
	private $ds_carrerainv;
	private $cd_organismo;
	private $ds_organismo;
	private $nu_horasinv;
	private $nu_semanasinv;
	private $nu_horasspu;
	private $nu_semanasspu;
	private $cd_facultad;
	private $ds_facultad;
	private $cd_cargo;
	private $ds_cargo;
	private $cd_deddoc;
	private $ds_deddoc;
	private $nu_horasdoc1c;
	private $nu_semanasdoc1c;
	private $nu_horasdoc2c;
	private $nu_semanasdoc2c;
	private $cd_universidad;
	private $ds_universidad;
	private $cd_titulo;
	private $ds_titulo;
	private $cd_titulopost;
	private $ds_codigootro;
	private $ds_titulootro;
	private $ds_duracionotro;
	private $nu_horasotro;
	private $cd_unidad;
	private $ds_unidad;
	private $nu_nilvelunidad;
	private $bl_becario;
	private $ds_tipobeca;
	private $ds_orgbeca;
	private $cd_tipomodificacion;
	private $bl_director;
	private $dt_cargo;
	//Método constructor


	function Docente() {
			
		$this->cd_docente = 0;
		$this->nu_ident = 0;
		$this->ds_nombre = '';
		$this->ds_apellido = '';
		$this->nu_precuil = 0;
		$this->nu_documento = 0;
		$this->nu_postcuil = 0;
		$this->dt_nacimiento = '';
		$this->ds_sexo = '';
		$this->ds_calle = '';
		$this->nu_nro = '';
		$this->nu_piso = '';
		$this->ds_depto = '';
		$this->ds_localidad = '';
		$this->cd_provincia = '';
		$this->ds_provincia = '';
		$this->nu_cp = '';
		$this->nu_telefono = '';
		$this->ds_mail = '';
		$this->cd_categoria = '';
		$this->ds_categoria = '';
		$this->nu_dedinv = 0;
		$this->cd_carrerainv = '';
		$this->ds_carrerainv = '';
		$this->cd_organismo = '';
		$this->ds_organismo = '';
		$this->nu_horasinv = 0;
		$this->nu_semanasinv = 0;
		$this->nu_horasspu = 0;
		$this->nu_semanasspu = 0;
		$this->cd_facultad = '';
		$this->ds_facultad = '';
		$this->cd_cargo = '';
		$this->ds_cargo = '';
		$this->cd_deddoc = '';
		$this->ds_deddoc = '';
		$this->nu_horasdoc1c = 0;
		$this->nu_semanasdoc1c = 0;
		$this->nu_horasdoc2c = 0;
		$this->nu_semanasdoc2c = 0;
		$this->cd_universidad = 0;
		$this->ds_universidad = '';
		$this->cd_titulo = 0;
		$this->cd_titulopost = 0;
		$this->ds_titulo = '';
		$this->ds_codigootro = '';
		$this->ds_titulootro = '';
		$this->ds_duracionotro = '';
		$this->nu_horasotro = 0;
		$this->cd_unidad = 0;
		$this->ds_unidad = '';
		$this->nu_nilvelunidad = 0;
		$this->cd_tipomodificacion = 0;
		$this->bl_becario = 0;
		$this->ds_tipobeca = '';
		$this->ds_orgbeca = '';
		$this->bl_director = 0;
		$this->dt_cargo = '';
	}

	//Métodos Get


	function getCd_docente() {
		return $this->cd_docente;
	}

	function getNu_ident() {
		return $this->nu_ident;
	}

	function getDs_nombre() {
		return $this->ds_nombre;
	}

	function getDs_apellido() {
		return $this->ds_apellido;
	}

	function getNu_precuil() {
		return $this->nu_precuil;
	}

	function getNu_documento() {
		return $this->nu_documento;
	}

	function getNu_postcuil() {
		return $this->nu_postcuil;
	}

	function getDs_sexo() {
		return $this->ds_sexo;
	}

	function getDs_calle() {
		return $this->ds_calle;
	}

	function getNu_nro() {
		return $this->nu_nro;
	}

	function getNu_piso() {
		return $this->nu_piso;
	}

	function getDs_depto() {
		return $this->ds_depto;
	}

	function getDs_localidad() {
		return $this->ds_localidad;
	}

	function getCd_provincia() {
		return $this->cd_provincia;
	}

	function getDs_provincia() {
		return $this->ds_provincia;
	}

	function getNu_cp() {
		return $this->nu_cp;
	}

	function getNu_telefono() {
		return $this->nu_telefono;
	}

	function getDs_mail() {
		return $this->ds_mail;
	}

	function getDs_categoria() {
		return $this->ds_categoria;
	}

	function getCd_categoria() {
		return $this->cd_categoria;
	}

	function getDt_nacimiento() {
		return $this->dt_nacimiento;
	}

	function getNu_dedinv() {
		return $this->nu_dedinv;
	}

	function getDs_carrerainv() {
		return $this->ds_carrerainv;
	}

	function getCd_carrerainv() {
		return $this->cd_carrerainv;
	}

	function getDs_organismo() {
		return $this->ds_organismo;
	}

	function getCd_organismo() {
		return $this->cd_organismo;
	}

	function getNu_horasinv() {
		return $this->nu_horasinv;
	}

	function getNu_semanasinv() {
		return $this->nu_semanasinv;
	}

	function getNu_horasspu() {
		return $this->nu_horasspu;
	}

	function getNu_semanasspu() {
		return $this->nu_semanasspu;
	}

	function getDs_facultad() {
		return $this->ds_facultad;
	}

	function getCd_facultad() {
		return $this->cd_facultad;
	}
	function getDs_cargo() {
		return $this->ds_cargo;
	}

	function getCd_cargo() {
		return $this->cd_cargo;
	}

	function getDs_deddoc() {
		return $this->ds_deddoc;
	}

	function getCd_deddoc() {
		return $this->cd_deddoc;
	}

	function getNu_horasdoc1c() {
		return $this->nu_horasdoc1c;
	}

	function getNu_semanasdoc1c() {
		return $this->nu_semanasdoc1c;
	}

	function getNu_horasdoc2c() {
		return $this->nu_horasdoc2c;
	}

	function getNu_semanasdoc2c() {
		return $this->nu_semanasdoc2c;
	}

	function getDs_universidad() {
		return $this->ds_universidad;
	}

	function getCd_universidad() {
		return $this->cd_universidad;
	}

	function getDs_titulo() {
		return $this->ds_titulo;
	}

	function getCd_titulo() {
		return $this->cd_titulo;
	}

	function getCd_titulopost() {
		return $this->cd_titulopost;
	}

	function getDs_titulootro() {
		return $this->ds_titulootro;
	}

	function getDs_codigootro() {
		return $this->ds_codigootro;
	}

	function getDs_duracionotro() {
		return $this->ds_duracionotro;
	}

	function getNu_horasotro() {
		return $this->nu_horasotro;
	}

	function getDs_unidad() {
		return $this->ds_unidad;
	}

	function getCd_unidad() {
		return $this->cd_unidad;
	}

	function getNu_nivelunidad() {
		return $this->nu_nilvelunidad;
	}

	function getBl_becario() {
		return $this->bl_becario;
	}

	function getDs_tipobeca() {
		return $this->ds_tipobeca;
	}

	function getDs_orgbeca() {
		return $this->ds_orgbeca;
	}

	function getCd_tipomodificacion() {
		return $this->cd_tipomodificacion;
	}

	function getBl_director() {
		return $this->bl_director;
	}


	//Métodos Set


	function setCd_docente($value) {
		$this->cd_docente = $value;
	}

	function setNu_ident($value) {
		$this->nu_ident = $value;
	}

	function setDs_nombre($value) {
		$this->ds_nombre = $value;
	}

	function setDs_apellido($value) {
		$this->ds_apellido = $value;
	}

	function setNu_precuil($value) {
		$this->nu_precuil = $value;
	}

	function setNu_documento($value) {
		$this->nu_documento = $value;
	}

	function setNu_postcuil($value) {
		$this->nu_postcuil = $value;
	}

	function setDs_sexo($value) {
		$this->ds_sexo = $value;
	}

	function setDs_calle($value) {
		$this->ds_calle = $value;
	}

	function setNu_nro($value) {
		$this->nu_nro = $value;
	}

	function setNu_piso($value) {
		$this->nu_piso = $value;
	}

	function setDs_depto($value) {
		$this->ds_depto = $value;
	}

	function setDs_localidad($value) {
		$this->ds_localidad = $value;
	}

	function setCd_provincia($value) {
		$this->cd_provincia = $value;
	}

	function setDs_provincia($value) {
		$this->ds_provincia = $value;
	}

	function setNu_cp($value) {
		$this->nu_cp = $value;
	}

	function setNu_telefono($value) {
		$this->nu_telefono = $value;
	}

	function setDs_mail($value) {
		$this->ds_mail = $value;
	}

	function setDs_categoria($value) {
		$this->ds_categoria = $value;
	}

	function setCd_categoria($value) {
		$this->cd_categoria = $value;
	}

	function setDt_nacimiento($value) {
		$this->dt_nacimiento = $value;
	}

	function setNu_dedinv($value) {
		$this->nu_dedinv = $value;
	}

	function setDs_carrerainv($value) {
		$this->ds_carrerainv = $value;
	}

	function setCd_carrerainv($value) {
		$this->cd_carrerainv = $value;
	}

	function setDs_organismo($value) {
		$this->ds_organismo = $value;
	}

	function setCd_organismo($value) {
		$this->cd_organismo = $value;
	}

	function setNu_horasinv($value) {
		$this->nu_horasinv = $value;
	}

	function setNu_semanasinv($value) {
		$this->nu_semanasinv = $value;
	}

	function setNu_horasspu($value) {
		$this->nu_horasspu = $value;
	}

	function setNu_semanasspu($value) {
		$this->nu_semanasspu = $value;
	}

	function setDs_facultad($value) {
		$this->ds_facultad = $value;
	}

	function setCd_facultad($value) {
		$this->cd_facultad = $value;
	}

	function setDs_cargo($value) {
		$this->ds_cargo = $value;
	}

	function setCd_cargo($value) {
		$this->cd_cargo = $value;
	}

	function setDs_deddoc($value) {
		$this->ds_deddoc = $value;
	}

	function setCd_deddoc($value) {
		$this->cd_deddoc = $value;
	}

	function setNu_horasdoc1c($value) {
		$this->nu_horasdoc1c = $value;
	}

	function setNu_semanasdoc1c($value) {
		$this->nu_semanasdoc1c = $value;
	}

	function setNu_horasdoc2c($value) {
		$this->nu_horasdoc2c = $value;
	}

	function setNu_semanasdoc2c($value) {
		$this->nu_semanasdoc2c = $value;
	}

	function setDs_universidad($value) {
		$this->ds_universidad = $value;
	}

	function setCd_universidad($value) {
		$this->cd_universidad = $value;
	}

	function setDs_titulo($value) {
		$this->ds_titulo = $value;
	}

	function setCd_titulo($value) {
		$this->cd_titulo = $value;
	}

	function setCd_titulopost($value) {
		$this->cd_titulopost = $value;
	}

	function setDs_titulootro($value) {
		$this->ds_titulootro = $value;
	}

	function setDs_codigootro($value) {
		$this->ds_codigootro = $value;
	}

	function setDs_duracionotro($value) {
		$this->ds_duracionotro = $value;
	}

	function setNu_horasotro($value) {
		$this->nu_horasotro = $value;
	}

	function setDs_unidad($value) {
		$this->ds_unidad = $value;
	}

	function setCd_unidad($value) {
		$this->cd_unidad = $value;
	}

	function setNu_nivelunidad($value) {
		$this->nu_nilvelunidad = $value;
	}

	function setBl_becario($value) {
		$this->bl_becario = $value;
	}

	function setDs_tipobeca($value) {
		$this->ds_tipobeca = $value;
	}

	function setDs_orgbeca($value) {
		$this->ds_orgbeca = $value;
	}

	function setCd_tipomodificacion($value) {
		$this->cd_tipomodificacion = $value;
	}

	function setBl_director($value) {
		$this->bl_director = $value;
	}


	public function getDt_cargo()
	{
	    return $this->dt_cargo;
	}

	public function setDt_cargo($dt_cargo)
	{
	    $this->dt_cargo = $dt_cargo;
	}
}

