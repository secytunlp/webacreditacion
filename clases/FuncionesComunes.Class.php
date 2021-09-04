<?php
class FuncionesComunes {

	/********************************************************
	 *	Convierte una fecha con formato "20/06/2008
	 *   al formato con el que se almacena en la BD 20080620
	 *********************************************************/
	function fechaPHPaMysql($fechaPHP) {
		$nuevaFecha = explode ( "/", $fechaPHP );
		//invierto los campos
		$fechaMySql [0] = $nuevaFecha [2];
		$fechaMySql [1] = $nuevaFecha [1];
		$fechaMySql [2] = $nuevaFecha [0];
		$fechaMySql = implode ( "-", $fechaMySql );
		return ($fechaMySql);
	}

	function fechaPHPaMysql1($fechaPHP) {
		$nuevaFecha = explode ( "/", $fechaPHP );
		//invierto los campos
		$fechaMySql [0] = $nuevaFecha [2];
		$fechaMySql [1] = $nuevaFecha [1];
		$fechaMySql [2] = $nuevaFecha [0];
		$fechaMySql = implode ( "", $fechaMySql );
		return ($fechaMySql);
	}

	function fechaMysqlaPHP($fechaMysql) {
		//2008-06-18
		$nuevaFecha = explode ( "-", $fechaMysql );
		$arrayFecha [0] = $nuevaFecha [2];
		$arrayFecha [1] = $nuevaFecha [1];
		$arrayFecha [2] = $nuevaFecha [0];
		$fechaPHP = implode ( "/", $arrayFecha );
		return $fechaPHP;
	}

	function fechaMysqlaPHP1($fechaMysql) {
		//20080618
		$arrayFecha [0] = substr ( $fechaMysql, - 2 );
		$arrayFecha [1] = substr ( $fechaMysql, 4, 2 );
		$arrayFecha [2] = substr ( $fechaMysql, 0, 4 );
		$fechaPHP = implode ( "/", $arrayFecha );
		return $fechaPHP;
	}

	function fechaHoraMysqlaPHP($fechaMysql) {
		//20080618
		$arrayHora [0] = substr ( $fechaMysql, 8, 2 );
		$arrayHora [1] = substr ( $fechaMysql, 10, 2 );
		$arrayHora [2] = substr ( $fechaMysql, - 2 );
		$horaPHP = implode ( ":", $arrayHora );
		$arrayFecha [0] = substr ( $fechaMysql, 6, 2 );
		$arrayFecha [1] = substr ( $fechaMysql, 4, 2 );
		$arrayFecha [2] = substr ( $fechaMysql, 0, 4 );
		$fechaPHP = implode ( "/", $arrayFecha );
		return $fechaPHP.' '.$horaPHP;
	}

	function horaMySQLaPHP($horaMySQL) {
		$arrayHora [0] = substr ( $horaMySQL, 0, 2 );
		$arrayHora [1] = substr ( $horaMySQL, 2, 2 );
		$horaPHP = implode ( ":", $arrayHora );
		return $horaPHP;
	}

	function horaPHPaMySQL($horaPHP) {
		$horaMySQL = implode ( "", explode ( ":", $horaPHP ) );
		return $horaMySQL;
	}

	function _log($str, $_Log) {
		$dt = date('Y-m-d H:i:s');
		fputs($_Log, $dt." --> ".$str."\n");
	}

	function generar_clave($cantidad)
	{
		$clave = "";
		srand((double)microtime()*date("YmdGis"));


		for($cnt = 0; $cnt < $cantidad; $cnt++)
		{
			$clave .= rand(0,9);
		}
		return $clave;
	}

	function array_envia($array) {

		$tmp = serialize($array);
		$tmp = urlencode($tmp);

		return $tmp;
	}


	function array_recibe($url_array) {
		$tmp = stripslashes($url_array);
		$tmp = urldecode($tmp);
		$tmp = unserialize($tmp);

		return $tmp;
	}

	function leef ($fichero) {
		$texto = file($fichero);
		$tamleef = sizeof($texto);
		for ($n=0;$n<$tamleef;$n++) {$todo= $todo.$texto[$n];}
		return $todo;
	}


	//funcion que genera un rtf
	function rtf($plantilla, $cd_proyecto){

		$txtplantilla = FuncionesComunes::leef($plantilla);
		//Paso no.2 Saca cabecera, el cuerpo y el final
		$matriz=explode('<meta http-equiv="Content-Language" content="en" />', $txtplantilla);

		$matriz[0] .= "<link rel=File-List href='".WEB_PATH."pdfs/".$cd_proyecto."/filelist.xml'>";
		$txtplantilla = $matriz[0].$matriz[1];

		$matriz=explode('#contenedor {margin-left:-40px;', $txtplantilla);

		$matriz[0] .= "/* Page Definitions */ @page	{mso-footnote-separator:url('".WEB_PATH."pdfs/".$cd_proyecto."/header.htm') fs;	mso-footnote-continuation-separator:url('".WEB_PATH."pdfs/".$cd_proyecto."/header.htm') fcs;	mso-endnote-separator:url('".WEB_PATH."pdfs/".$cd_proyecto."/header.htm') es;	mso-endnote-continuation-separator:url('".WEB_PATH."pdfs/".$cd_proyecto."/header.htm') ecs;}@page Section1	{size:595.3pt 841.9pt;	margin:70.85pt 3.0cm 70.85pt 3.0cm;	mso-header-margin:35.4pt;	mso-footer-margin:35.4pt;	mso-even-header:url('".WEB_PATH."pdfs/".$cd_proyecto."/header.htm') eh1;	mso-header:url('".WEB_PATH."pdfs/".$cd_proyecto."/header.htm') h1;	mso-even-footer:url('".WEB_PATH."pdfs/".$cd_proyecto."/header.htm') ef1;	mso-footer:url('".WEB_PATH."pdfs/".$cd_proyecto."/header.htm') f1;	mso-first-header:url('".WEB_PATH."pdfs/".$cd_proyecto."/header.htm') fh1;	mso-first-footer:url('".WEB_PATH."pdfs/".$cd_proyecto."/header.htm') ff1;	mso-paper-source:0;}";
		$txtplantilla = $matriz[0].$matriz[1];
		/*$inicio=strlen($cabecera);
		 $final=strrpos($txtplantilla,"}");
		 $largo=$final-$inicio;
		 $cuerpo=substr($txtplantilla, $inicio, $largo);*/
		//Paso no.3 Escribo el fichero
		$punt = fopen($plantilla, "w");
		fputs($punt,$txtplantilla);


		fclose ($punt);
		return $plantilla;
	}

	function Format_toMoney( $pNum ){

		return( trim( '$'. FuncionesComunes::Format_toDecimal($pNum) ) );

	}

	function Format_toDecimal( $pNum ){
		if ( is_null($pNum) ) {
			return( '0,00' );
		}else{
			return( trim( number_format($pNum, 2, ',', '.') ) );
		}
	}

	function edad($edad){
		list($anio,$mes,$dia) = explode("-",$edad);
		$anio_dif = date("Y") - $anio;
		$mes_dif = date("m") - $mes;
		$dia_dif = date("d") - $dia;
		if ($dia_dif < 0 || $mes_dif < 0)
		$anio_dif--;
		return $anio_dif;
	}

	Function stripAccents($String)
	{
		$String = ereg_replace("[äáàâãª]","a",$String);
		$String = ereg_replace("[ÁÀÂÃÄ]","A",$String);
		$String = ereg_replace("[ÍÌÎÏ]","I",$String);
		$String = ereg_replace("[íìîï]","i",$String);
		$String = ereg_replace("[éèêë]","e",$String);
		$String = ereg_replace("[ÉÈÊË]","E",$String);
		$String = ereg_replace("[óòôõöº]","o",$String);
		$String = ereg_replace("[ÓÒÔÕÖ]","O",$String);
		$String = ereg_replace("[úùûü]","u",$String);
		$String = ereg_replace("[ÚÙÛÜ]","U",$String);
		$String = ereg_replace("[´`]","",$String);
		$String = str_replace("ç","c",$String);
		$String = str_replace("Ç","C",$String);
		$String = str_replace("ñ","n",$String);
		$String = str_replace("Ñ","N",$String);
		$String = str_replace("Ý","Y",$String);
		$String = str_replace("ý","y",$String);
		return $String;
	}
	
	public static function formatString( $value ){
		$res = addslashes($value);
		return "'$res'";
	}
	
	public static function formatIfNull( $value, $nullValue = "null"){
		return self::ifEmpty($value, $nullValue);
	}
	
	public static function isEmpty($value){
		return $value==null || $value=='' || $value==0;
	}

	public static function ifNull($value,$show){
		return ($value==null)?$show:$value;
	}
	
	public static function ifEmpty($value,$show){
		return (self::isEmpty($value))?$show:$value; //TODO parse number.
	}
	
	public static function formatEmpty($value){
		return (self::isEmpty($value))?'':$value;
	}
	
	public static function formatDate( $value){
		
		if(empty($value))
			return "null";
		
		
		$res = self::formatString( $value );
		
		
		
		return $res;
	}

}
?>