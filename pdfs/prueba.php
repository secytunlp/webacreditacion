<?php
 
header('Content-type: application/msword');
header('Content-Disposition: inline; filename=cert.rtf');


$filename="acred_2010_sol.rtf";
$output=file_get_contents($filename);

//Sustituimos los marcadores de posición en la plantilla por los datos


$output=str_replace('<<nombre>>','Marcos',$output);
$output=str_replace('<<apellido>>','Piñero',$output);


//Enviamos el documento generado al navegador
echo $output; 
?>