<?php
class Financiamientoanterior {
	

	private $cd_financiamientoanterior;
	private $cd_proyecto;
	
	private $nu_year;
	private $nu_unlp;
	private $nu_nacionales;
	private $nu_extranjeras;
	
	//Método constructor


	function Financiamientoanterior() {

		$this->cd_financiamientoanterior=0;
		$this->cd_proyecto=0;
		
		$this->nu_unlp='0';
		$this->nu_nacionales='0';
		$this->nu_year=0;
		$this->nu_extranjeras='0';
		
	}

	


	

	

	public function getCd_financiamientoanterior()
	{
	    return $this->cd_financiamientoanterior;
	}

	public function setCd_financiamientoanterior($cd_financiamientoanterior)
	{
	    $this->cd_financiamientoanterior = $cd_financiamientoanterior;
	}

	public function getCd_proyecto()
	{
	    return $this->cd_proyecto;
	}

	public function setCd_proyecto($cd_proyecto)
	{
	    $this->cd_proyecto = $cd_proyecto;
	}

	public function getNu_year()
	{
	    return $this->nu_year;
	}

	public function setNu_year($nu_year)
	{
	    $this->nu_year = $nu_year;
	}

	public function getNu_unlp()
	{
	    return $this->nu_unlp;
	}

	public function setNu_unlp($nu_unlp)
	{
	    $this->nu_unlp = $nu_unlp;
	}

	public function getNu_nacionales()
	{
	    return $this->nu_nacionales;
	}

	public function setNu_nacionales($nu_nacionales)
	{
	    $this->nu_nacionales = $nu_nacionales;
	}

	public function getNu_extranjeras()
	{
	    return $this->nu_extranjeras;
	}

	public function setNu_extranjeras($nu_extranjeras)
	{
	    $this->nu_extranjeras = $nu_extranjeras;
	}
}