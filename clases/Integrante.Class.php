<?php

class Integrante {
	private $cd_proyecto;
	private $dt_alta;
	private $dt_baja;
	private $cd_tipoinvestigador;
	private $ds_tipoinvestigador;
	private $cd_docente;
	private $ds_investigador;
	private $ds_categoria;
	private $nu_dedinv;
	private $ds_deddoc;
	private $ds_facultad;
	private $nu_horasinv;
	private $dt_altapendiente;
	private $dt_bajapendiente;
	private $ds_curriculum;
	private $ds_curriculumT;
	private $ds_antecedentes;
	private $ds_antecedentesPPIDDIR;
	//Método constructor


	function Integrante() {
			
		$this->cd_proyecto = 0;
		$this->dt_baja = '';
		$this->cd_tipoinvestigador = '';
		$this->ds_tipoinvestigador = '';
		$this->dt_alta = '';
		$this->cd_docente = '';
		$this->ds_investigador= '';
		$this->ds_categoria= '';
		$this->nu_dedinv= '';
		$this->ds_deddoc= '';
		$this->ds_facultad= '';
		$this->dt_altapendiente = '';
		$this->dt_bajapendiente = '';
		$this->nu_horasinv = '';
		$this->ds_curriculum= '';
		$this->ds_curriculumT= '';
		$this->ds_antecedentesPPIDDIR= '';
	}

	//Métodos Get


	function getCd_proyecto() {
		return $this->cd_proyecto;
	}

	function getCd_docente() {
		return $this->cd_docente;
	}

	function getDt_alta() {
		return $this->dt_alta;
	}

	function getDt_baja() {
		return $this->dt_baja;
	}

	function getCd_tipoinvestigador() {
		return $this->cd_tipoinvestigador;
	}

	function getDs_tipoinvestigador() {
		return $this->ds_tipoinvestigador;
	}

	function getDs_investigador() {
		return $this->ds_investigador;
	}

	function getDs_categoria() {
		return $this->ds_categoria;
	}

	function getNu_dedinv() {
		return $this->nu_dedinv;
	}

	function getDs_deddoc() {
		return $this->ds_deddoc;
	}

	function getDs_facultad() {
		return $this->ds_facultad;
	}

	function getDt_altapendiente() {
		return $this->dt_altapendiente;
	}

	function getDt_bajapendiente() {
		return $this->dt_bajapendiente;
	}

	function getNu_horasinv() {
		return $this->nu_horasinv;
	}

	function getDs_curriculum() {
		return $this->ds_curriculum;
	}

	function getDs_curriculumT() {
		return $this->ds_curriculumT;
	}

	function getDs_antecedentes() {
		return $this->ds_antecedentes;
	}


	//Métodos Set


	function setCd_proyecto($value) {
		$this->cd_proyecto = $value;
	}

	function setCd_docente($value) {
		$this->cd_docente = $value;
	}

	function setDt_alta($value) {
		$this->dt_alta = $value;
	}

	function setDt_baja($value) {
		$this->dt_baja = $value;
	}

	function setCd_tipoinvestigador($value) {
		$this->cd_tipoinvestigador = $value;
	}

	function setDs_tipoinvestigador($value) {
		$this->ds_tipoinvestigador = $value;
	}

	function setDs_investigador($value) {
		$this->ds_investigador = $value;
	}

	function setDs_categoria($value) {
		$this->ds_categoria = $value;
	}

	function setNu_dedinv($value) {
		$this->nu_dedinv = $value;
	}

	function setDs_deddoc($value) {
		$this->ds_deddoc = $value;
	}

	function setDs_facultad($value) {
		$this->ds_facultad = $value;
	}

	function setDt_altapendiente($value) {
		$this->dt_altapendiente = $value;
	}

	function setDt_bajapendiente($value) {
		$this->dt_bajapendiente = $value;
	}

	function setNu_horasinv($value) {
		$this->nu_horasinv = $value;
	}

	function setDs_curriculum($value) {
		$this->ds_curriculum = $value;
	}

	function setDs_curriculumT($value) {
		$this->ds_curriculumT = $value;
	}

	function setDs_antecedentes($value) {
		$this->ds_antecedentes = $value;
	}


	public function getDs_antecedentesPPIDDIR()
	{
	    return $this->ds_antecedentesPPIDDIR;
	}

	public function setDs_antecedentesPPIDDIR($ds_antecedentesPPIDDIR)
	{
	    $this->ds_antecedentesPPIDDIR = $ds_antecedentesPPIDDIR;
	}
}

