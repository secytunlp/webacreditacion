<?php

class Disciplina {
	private $cd_disciplina;
	private $ds_disciplina;
	private $ds_codigo;
	//Método constructor


	function Disciplina() {

		$this->cd_disciplina = 0;
		$this->ds_disciplina = '';
		$this->ds_codigo = '';
	}

	//Métodos Get


	function getCd_disciplina() {
		return $this->cd_disciplina;
	}

	function getDs_disciplina() {
		return $this->ds_disciplina;
	}

	function getDs_codigo() {
		return $this->ds_codigo;
	}

	//Métodos Set


	function setCd_disciplina($value) {
		$this->cd_disciplina = $value;
	}

	function setDs_disciplina($value) {
		$this->ds_disciplina = $value;
	}

	function setDs_codigo($value) {
		$this->ds_codigo = $value;
	}

}

