<?php
class Financiamientoitem {
	

	private $cd_financiamientoitem;
	private $cd_proyecto;
	
	private $nu_year;
	private $nu_monto;
	private $cd_tipo;
	private $ds_concepto;
	
	//Método constructor


	function Financiamientoitem() {

		$this->cd_financiamientoitem=0;
		$this->cd_proyecto=0;
		
		$this->nu_monto='0';
		$this->cd_tipo='0';
		$this->nu_year=0;
		$this->ds_concepto='';
		
	}

	


	

	

	

	public function getCd_financiamientoitem()
	{
	    return $this->cd_financiamientoitem;
	}

	public function setCd_financiamientoitem($cd_financiamientoitem)
	{
	    $this->cd_financiamientoitem = $cd_financiamientoitem;
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

	public function getNu_monto()
	{
	    return $this->nu_monto;
	}

	public function setNu_monto($nu_monto)
	{
	    $this->nu_monto = $nu_monto;
	}

	public function getCd_tipo()
	{
	    return $this->cd_tipo;
	}

	public function setCd_tipo($cd_tipo)
	{
	    $this->cd_tipo = $cd_tipo;
	}

	public function getDs_concepto()
	{
	    return $this->ds_concepto;
	}

	public function setDs_concepto($ds_concepto)
	{
	    $this->ds_concepto = $ds_concepto;
	}
}