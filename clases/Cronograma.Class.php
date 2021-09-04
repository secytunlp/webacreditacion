<?php
class Cronograma {
	

	private $cd_cronograma;
	private $cd_proyecto;
	private $ds_actividad;
	private $nu_year;
	private $bl_mes1;
	private $bl_mes2;
	private $bl_mes3;
	private $bl_mes4;
	private $bl_mes5;
	private $bl_mes6;
	private $bl_mes7;
	private $bl_mes8;
	private $bl_mes9;
	private $bl_mes10;
	private $bl_mes11;
	private $bl_mes12;
	
	//Método constructor


	function Cronograma() {

		$this->cd_cronograma=0;
		$this->cd_proyecto=0;
		$this->ds_actividad='';
		$this->nu_year=0;
		$this->bl_mes1=0;
		$this->bl_mes2=0;
		$this->bl_mes3=0;
		$this->bl_mes4=0;
		$this->bl_mes5=0;
		$this->bl_mes6=0;
		$this->bl_mes7=0;
		$this->bl_mes8=0;
		$this->bl_mes9=0;
		$this->bl_mes10=0;
		$this->bl_mes11=0;
		$this->bl_mes12=0;
		
	}

	


	

	public function getCd_cronograma()
	{
	    return $this->cd_cronograma;
	}

	public function setCd_cronograma($cd_cronograma)
	{
	    $this->cd_cronograma = $cd_cronograma;
	}

	public function getCd_proyecto()
	{
	    return $this->cd_proyecto;
	}

	public function setCd_proyecto($cd_proyecto)
	{
	    $this->cd_proyecto = $cd_proyecto;
	}

	public function getDs_actividad()
	{
	    return $this->ds_actividad;
	}

	public function setDs_actividad($ds_actividad)
	{
	    $this->ds_actividad = $ds_actividad;
	}

	public function getNu_year()
	{
	    return $this->nu_year;
	}

	public function setNu_year($nu_year)
	{
	    $this->nu_year = $nu_year;
	}

	public function getBl_mes1()
	{
	    return $this->bl_mes1;
	}

	public function setBl_mes1($bl_mes1)
	{
	    $this->bl_mes1 = $bl_mes1;
	}

	public function getBl_mes2()
	{
	    return $this->bl_mes2;
	}

	public function setBl_mes2($bl_mes2)
	{
	    $this->bl_mes2 = $bl_mes2;
	}

	public function getBl_mes3()
	{
	    return $this->bl_mes3;
	}

	public function setBl_mes3($bl_mes3)
	{
	    $this->bl_mes3 = $bl_mes3;
	}

	public function getBl_mes4()
	{
	    return $this->bl_mes4;
	}

	public function setBl_mes4($bl_mes4)
	{
	    $this->bl_mes4 = $bl_mes4;
	}

	public function getBl_mes5()
	{
	    return $this->bl_mes5;
	}

	public function setBl_mes5($bl_mes5)
	{
	    $this->bl_mes5 = $bl_mes5;
	}

	public function getBl_mes6()
	{
	    return $this->bl_mes6;
	}

	public function setBl_mes6($bl_mes6)
	{
	    $this->bl_mes6 = $bl_mes6;
	}

	public function getBl_mes7()
	{
	    return $this->bl_mes7;
	}

	public function setBl_mes7($bl_mes7)
	{
	    $this->bl_mes7 = $bl_mes7;
	}

	public function getBl_mes8()
	{
	    return $this->bl_mes8;
	}

	public function setBl_mes8($bl_mes8)
	{
	    $this->bl_mes8 = $bl_mes8;
	}

	public function getBl_mes9()
	{
	    return $this->bl_mes9;
	}

	public function setBl_mes9($bl_mes9)
	{
	    $this->bl_mes9 = $bl_mes9;
	}

	public function getBl_mes10()
	{
	    return $this->bl_mes10;
	}

	public function setBl_mes10($bl_mes10)
	{
	    $this->bl_mes10 = $bl_mes10;
	}

	public function getBl_mes11()
	{
	    return $this->bl_mes11;
	}

	public function setBl_mes11($bl_mes11)
	{
	    $this->bl_mes11 = $bl_mes11;
	}

	public function getBl_mes12()
	{
	    return $this->bl_mes12;
	}

	public function setBl_mes12($bl_mes12)
	{
	    $this->bl_mes12 = $bl_mes12;
	}
}