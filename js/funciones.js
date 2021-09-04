/*Las funciones dentro del script est?n ordenadas alfab?ticamente*/
/********************  A  **************************/

Array.prototype.in_array=function(){
    for(var j in this){
        if(this[j]==arguments[0]){
            return true;
        }
    }
    return false;    
} 

function activar(elem, elemOp)
	{
		// Obtengo la opcion que el usuario selecciono
		var oChk = document.getElementById(elem);
		var activar = (oChk.checked)?1:0;
		var ajax=nuevoAjax();
		t = new Date();
		
		ajax.open("GET", "../includes/select_dependientes_proceso.php?random="+t.getTime()+"&select=activarUsuario&activar="+activar+"&elem="+oChk.value+"&elemOp="+elemOp, true);
		ajax.onreadystatechange=function() 
		{ 
			
			if (ajax.readyState==4)
			{
				//alert(ajax.responseText);
				if(ajax.responseText!=''){
					oChk.checked=true;
					window.parent.mensajeError(ajax.responseText);
				}
			} 
		}
		ajax.send(null);
		
	}

/********************  B  **************************/

/********************  C  **************************/

function cargarUnidad(formname, nivel, proyecto){
	var i=parseInt(nivel)+1;
	var ok=1;
	while (ok==1)
	{
		var unidad = document.getElementById('unidad'+i);
		
		if (unidad != null)
		{
			unidad.innerHTML = '';
		}
		else ok=0;
		i++;
	}
	var miAjax = new Ajax('Ajax_cargarUnidades.php?nivel='+nivel+'&formname='+formname+'&proyecto='+proyecto,
	{
		method: 'get',
		data:$(formname),
		update:'unidad'+nivel,
		onComplete: function()
		{
			if (nivel == 0)
			{
				$('cd_unidad0').className="fValidate['required']";
				exValidatorA.initialize(formname, exValidatorA.options);
			}
			
		}
	});
	miAjax.request();
	if(proyecto){
		var miAjax1 = new Ajax('Ajax_cargarDirecciones.php?nivel='+nivel+'&formname='+formname,
		{
			method: 'get',
			data:$(formname),
			update:'direccion',
			onComplete: function()
			{
				if($('ds_mail')!=null){
					$('ds_mail').className="fValidate['email']";
					exValidatorA.initialize(formname, exValidatorA.options);
				}
				
			}
		});
		miAjax1.request();
	}

}

function confirmaElim(nom,a, href){
	var preg=confirm("¿Confirma que desea eliminar "+nom+"?");
	if (preg==true)
		a.href=href;
	else
		return false;
	return true;
}

function confirmaDesa(nom,a, href){
	var preg=confirm("\xBFConfirma que desea desasignarlo "+nom+"?");
	if (preg==true)
		a.href=href;
	else
		return false;
	return true;
}

function confirmaConfir(a, href){
	var preg=confirm("¿Está seguro de admitir?");
	if (preg==true)
		a.href=href;
	else
		return false;
	return true;
}

function confirmaAcred(a, href){
	var preg=confirm("¿Está seguro de acreditar?");
	if (preg==true)
		a.href=href;
	else
		return false;
	return true;
}

function confirmaRechazo(a, href){
	var preg=confirm("¿Está seguro de NO ACREDITAR?");
	if (preg==true)
		a.href=href;
	else
		return false;
	return true;
}

function confirmaEnviar(a, href){
	var preg=confirm("Luego de enviar el proyecto no podrá realizar modificaciones ¿Confirma?");
	if (preg==true)
		a.href=href;
	else
		return false;
	return true;
}

function confirmaEnviarE(a, href){
	var preg=confirm("\xBFEnviar el proyecto a los evaluadores?");
	if (preg==true)
		a.href=href;
	else
		return false;
	return true;
}

function confirmaEnviarEv(a, href){
	var preg=confirm("\xBFEnviar la evaluacion?");
	if (preg==true)
		a.href=href;
	else
		return false;
	return true;
}

function copiarRadio(radio){
	var radioTXT = document.getElementById(radio);
	radioTXT.value = 1;
	
}	

function consultarSalida(){
	/*var preg=confirm("Perder? los cambios de esta pantalla ?Continuar?");
	if (preg==true)
		location.href='altaproyecto5-action.php';
	else
		return false;
	return true;*/
	location.href='index.php';
}
/********************  D  **************************/

function formatDec(valor, decimales) {
	var parts = String(valor).split(".");
	parts[1] = String(parts[1]).substring(0, decimales);
	// parts[1] = Number(parts[1]) * Math.pow(10, -(decimales - 1)); //POTENCIA
	// parts[1] = String(Math.floor(parts[1])); //REDODEA HACIA ABAJO
	return parseFloat(parts.join("."));
}
/*function deshabilitarInput(id){
	inp = document.getElementById('nu_matricula');
	check = document.getElementById('todos').checked;
	if(check == true)
	{
		inp.disabled = false;
		inp.className = "fValidate['required']";
		inp.value = "";
	}
	else
	{
		inp.disabled = true;
		inp.className = "";
		inp.style['border-color'] = "FFFFFF";
		inp.style['background-color'] = "FFFFFF";
		inp.value = "";
		//borro el p que contiene el nro de matricula
		$('ds_apynom').innerHTML = "";
	
		//Borro el div con el msj del validador
		if($('nu_matricularequired_msg')!= null)
		{
			div = $('nu_matricularequired_msg');
			div.innerHTML = "";
		}
	}
	
}*/


/********************  G  **************************/
function getHTTPObject() {
    var xmlhttp;
    /*@cc_on
    @if (@_jscript_version >= 5)
       try {
          xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
       } catch (e) {
          try {
             xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
          } catch (E) { xmlhttp = false; }
       }
    @else
    xmlhttp = false;
    @end @*/
    if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
       try {
          xmlhttp = new XMLHttpRequest();
       } catch (e) { xmlhttp = false; }
    }
    return xmlhttp;
}

var enProceso = false; // lo usamos para ver si hay un proceso activo
var http = getHTTPObject(); // Creamos el objeto XMLHttpRequest

function abrirVentanita(pagina){
	derecha=(screen.width-500)/2;
	arriba=(screen.height-500)/2;
	stringComun="toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=500,height=350, left="+derecha+", top="+arriba+"";
	mw = window.open(pagina, '', stringComun);
	
}



/********************  H  **************************/
function handleHttpResponse() {
	
	if (http.readyState == 4) {
       if (http.status == 200) {
          if (http.responseText.indexOf('invalid') == -1) {
             // Armamos un array, usando la coma para separar elementos
             results = http.responseText.split(";");
			//alert(results[0]);	
			 
			 switch(results[0])
				{
				case "1": 
					 if (results[1]!='')
					 {
						 
						 document.getElementById('contenido').innerHTML =results[1];
					 }
			 
				break;
				case "2": 
					 if (results[7]!='')
					 {	
						
						document.getElementById('navi').innerHTML='';
						document.getElementById('navi').className='capa_fotocentro'+results[7];
						div='';
						for (i = 0; i < results[7]; i++)
						{
							div =div+'<div class="capa_fotito"><div id=DivFoto'+i+'></div></div>';
							
						}
							
						document.getElementById('navi').innerHTML=div;
						
						
						autom="'"+results[5]+"'";
						document.getElementById('img1').innerHTML='';
						if (results[7]!='')
						{
							document.getElementById('img1').innerHTML='<a href="#" onClick="abrirVentanita(\'admin/imagenespublicaciones/imagenes/'+results[8]+'\')"><IMG SRC="admin/imagenespublicaciones/imagenes/'+results[8]+'" WIDTH=200 HEIGHT=200 ALT="" ></a>'
						}
						
						for (i = 0; i < results[7]; i++)
						{
							foto="'"+results[i+8]+"'";
							
							
							
							
							img='<img class="center" src="admin/imagenespublicaciones/thumbnail/'+results[i+8]+'" width="40" height="30" alt="" >';
							document.getElementById('DivFoto'+i).innerHTML ='<a href="cambiar" onClick="cambiarImg('+foto+');return false;">'+img+'</a>';
						}
						id="'"+results[1]+"'";
						ant="'"+results[2]+"'";
						sig="'"+results[3]+"'";
						
						pag = parseInt(results[4]) ;
						var ultimo=0;
						 ultimo=(pag-1)*5;
						ultimo="'"+ultimo+"'";
						document.getElementById('siguiente').innerHTML='<a href="cambiar" onClick="paginar('+id+', '+sig+', '+autom+');return false;"><img class="sinBorde" src="imagenes/irsiguiente.jpg" width="18" height="18" alt="Siguiente"></a>';
						document.getElementById('anterior').innerHTML='<a href="cambiar" onClick="paginar('+id+', '+ant+', '+autom+');return false;"><img class="sinBorde" src="imagenes/iranterior.jpg" width="18" height="18" alt="Anterior"></a>';
						document.getElementById('ultimo').innerHTML='<a href="cambiar" onClick="paginar('+id+', '+ultimo+', '+autom+');return false;"><img class="sinBorde" src="imagenes/irultimo.jpg" width="18" height="18" alt="Ultimo"></a>';
						
					 }
					automatic = parseInt(results[5]) ;
					
					if (automatic)
					 {
						for (i = 0; i < results[7]; i++)
							{
							
							setTimeout("cambiarImg('"+results[i+8]+"')",i*5000);
							}
						
						if (results[6]!=1){
							setTimeout("paginar("+id+", "+sig+", '1')",results[7]*5000);
						}
						

					 }
				break;
				
			}
			 
			 
             enProceso = false;
			 
          }
       }
	   
    }
	
}

function habilitar(f){
	for (var iterador = 0; iterador < f.elements.length; iterador++) {
		elem = f.elements[iterador];
		elem.removeAttribute('disabled');
	}
}

function habilitarInput(id){
	document.getElementById(id).readonly = false;
	todos = document.getElementsByTagName('input');
	i=0;
	while(i<todos.length){
		if ((todos[i].type != 'submit')||(todos[i].type != 'button')){
			if(todos[i].id != id){
				todos[i].readonly = true;
			}
		}
				i++;
	}
}

/********************  L  **************************/

function listartodos(){
 	formu = document.getElementById('validar').value="false";
 	document.getElementById('filtro').selectedIndex = 0;
 	document.getElementById('filtro').value="";
}



/********************  M  **************************/
function mayusculas(input){
 	
	input.value = input.value.toUpperCase(); 
}

function mensajeError(error) {
	var lightbox = document.getElementById('lightbox');
	var overlay = document.getElementById('overlay');
	var mensajeErrorText = document.getElementById('mensajeErrorText');
	if(error != null) {
		mensajeErrorText.innerHTML = error;
		lightbox.style.visibility = 'visible';
		overlay.style.visibility = 'visible';
	} else {
		lightbox.style.visibility = 'hidden';
		overlay.style.visibility = 'hidden';	
	}
}

/********************  N  **************************/
function nuevoAjax()
{ 
	/* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
	lo que se puede copiar tal como esta aqui */
	var xmlhttp=false;
	try
	{
		// Creacion del objeto AJAX para navegadores no IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
	}
	catch(e)
	{
		try
		{
			// Creacion del objet AJAX para IE
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(E)
		{
			if (!xmlhttp && typeof XMLHttpRequest!='undefined') xmlhttp=new XMLHttpRequest();
		}
	}
	return xmlhttp; 
}

/********************  P  **************************/
function popUp(a){
	window.open(a.href, a.target, 'width=900,height=450, ,location=center, scrollbars=YES'); 
	return false;

}

function paginar(id, start, autom) {  
	
	if (!enProceso && http) {
        
	   var url = "admin/imagenespublicaciones/Ajax_imagenes.php?id="+id+"&start="+start+"&auto="+autom;
      	
	   http.open("GET", url, true);
       http.onreadystatechange = handleHttpResponse;
       enProceso = true;
       http.send(null);
    }
}

/********************  T  **************************/


/********************  V  **************************/

function validarHoras(form){
	
	var tipoInv = document.getElementById('cd_tipoinvestigador');
	var cd_proyecto = document.getElementById('cd_proyecto');
	var ded = document.getElementById('cd_deddoc');
	var divDed = document.getElementById('divDed');
	var cargo = document.getElementById('cd_cargo');
	var divCargo = document.getElementById('divCargo');
	if((cargo.value==6)&&(ded.value!=4)){
		divCargo.innerHTML = 'Debe especificar un cargo';
		cargo.style.background = '#FFF4F4';
		cargo.style.borderColor =  "#8E3B1B";
		return false
	}
	else{
		divCargo.innerHTML = '';
		cargo.style.background = '#FFFFFF';
		cargo.style.borderColor = '#FFFFFF';
	}
	if((cargo.value!=6)&&(ded.value==4)){
		divDed.innerHTML = 'Debe especificar una dedicación';
		ded.style.background = '#FFF4F4';
		ded.style.borderColor =  "#8E3B1B";
		return false
	}
	else{
		divDed.innerHTML = '';
		ded.style.background = '#FFFFFF';
		ded.style.borderColor = '#FFFFFF';
	}
	var carr = document.getElementById('cd_carrerainv');
	var divCarrera = document.getElementById('divCarrera');
	var univ = document.getElementById('cd_universidad');
	var becario = document.getElementById('bl_becario');
	var tipo = document.getElementById('ds_tipobeca');
	var divTipo = document.getElementById('divTipobeca');
	var inst = document.getElementById('ds_orgbeca');
	var divOrg = document.getElementById('divOrgbeca');
	var carreras = [1,2,3,4,5,6]; 
	if((cargo.value==6)&&(ded.value==4)){
		if((!carreras.in_array(carr.value))&&(!becario.checked)&&(tipoInv.value!=6)){
			divCarrera.innerHTML = 'Si no posee cargo, debe ser becario o tener un cargo en la carrera de investigación.';
			
			return false
			}
		else{
			divCarrera.innerHTML = '';
			
		}
	}
	else{
			divCarrera.innerHTML = '';
			
	}
	
	if(becario.checked){
		if(tipo.value==''){
			divTipo.innerHTML = 'Este Campo es requerido.';
			tipo.style.background = '#FFF4F4';
			tipo.style.borderColor =  "#8E3B1B";
			return false
			}
		else{
			divTipo.innerHTML = '';
			tipo.style.background = '#FFFFFF';
			tipo.style.borderColor = '#FFFFFF';
		}
		if(inst.value==''){
			divOrg.innerHTML = 'Este Campo es requerido.';
			inst.style.background = '#FFF4F4';
			inst.style.borderColor =  "#8E3B1B";
			return false
			}
		else{
			divOrg.innerHTML = '';
			inst.style.background = '#FFFFFF';
			inst.style.borderColor = '#FFFFFF';
		}

	

	}
	else{
		divTipo.innerHTML = '';
		tipo.style.background = '#FFFFFF';
		tipo.style.borderColor = '#FFFFFF';
		divOrg.innerHTML = '';
		inst.style.background = '#FFFFFF';
		inst.style.borderColor = '#FFFFFF';
	}
	
	var i=0;
	var ok=1;
	var hs=0;
	while (ok==1){
		var p = document.getElementById('p'+i);
		var cd_tipoinvestigador = document.getElementById('pTI'+i);
		if (p==null) ok=0;
			else{
				var div = document.getElementById('div'+i);
				var hsP = document.getElementById('nu_horasinv'+p.value);
				var vp = hsP.value;
		
				vp = (vp=='')?0:vp;
				var hs = parseInt(vp) + parseInt(hs);
				if((tipoInv.value==6)||(cd_tipoinvestigador.value==6)){
					var hsAnt= hs;
					hs = 0;
					if ((p.value == cd_proyecto.value)||(cd_tipoinvestigador.value==6))
					{
						hs = parseInt(vp);
					}
					if(hs > 0){ div.innerHTML = 'No puede aportar horas'; hsP.style.background = '#FFF4F4'; hsP.style.borderColor =  "#8E3B1B";   return false;}
					  else {div.innerHTML = ''; 	
							hsP.style.background = '#FFFFFF';
							hsP.style.borderColor =  "#FFFFFF";
							
							}
					var hs= hsAnt;
					}
					else{
					if(univ.value!=11){
						if((hs > 6)||(hs < 1)){ div.innerHTML = 'Las hs. en el/los proyecto/s deben ser mayor que 1 y no superar 6';  hsP.style.background = '#FFF4F4'; hsP.style.borderColor =  "#8E3B1B";   return false;}
							  else {div.innerHTML = '';		
									hsP.style.background = '#FFFFFF';
									hsP.style.borderColor =  "#FFFFFF";
									}
					}
					else{
						if((carreras.in_array(carr.value))||(becario.checked)){
							if((hs > 35)){ div.innerHTML = 'Las hs. en el/los proyecto/s no deben superar 35';  hsP.style.background = '#FFF4F4'; hsP.style.borderColor =  "#8E3B1B";  return false;}
							  else {div.innerHTML = '';	
									hsP.style.background = '#FFFFFF';
									hsP.style.borderColor =  "#FFFFFF";
									
									}
							if((hsP.value < 10)&&(p.value == cd_proyecto.value)){ div.innerHTML = 'Las hs. en el proyecto deben ser mayor a 9';  hsP.style.background = '#FFF4F4'; hsP.style.borderColor =  "#8E3B1B";  return false;}
							  else {div.innerHTML = '';	
									hsP.style.background = '#FFFFFF';
									hsP.style.borderColor =  "#FFFFFF";
									
									}
						}
						else{
							switch (ded.value) {
								case '1': if(hs > 35){ div.innerHTML = 'Las hs. en el/los proyecto/s no deben superar 35';  hsP.style.background = '#FFF4F4'; hsP.style.borderColor =  "#8E3B1B";  return false;}
										  else {div.innerHTML = '';	
												hsP.style.background = '#FFFFFF';
												hsP.style.borderColor =  "#FFFFFF";
												
												}
										  if((hsP.value < 10)&&(p.value == cd_proyecto.value)){ div.innerHTML = 'Las hs. en el proyecto deben ser mayor a 9';  hsP.style.background = '#FFF4F4'; hsP.style.borderColor =  "#8E3B1B";  return false;}
										  else {div.innerHTML = '';	
												hsP.style.background = '#FFFFFF';
												hsP.style.borderColor =  "#FFFFFF";
												
												}
											break;
								case '2': if((hs > 15)){ div.innerHTML = 'Las hs. en el/los proyecto/s no deben superar 15';  hsP.style.background = '#FFF4F4'; hsP.style.borderColor =  "#8E3B1B";   return false;}
										  else {div.innerHTML = '';	
												hsP.style.background = '#FFFFFF';
												hsP.style.borderColor =  "#FFFFFF";
												
												}
										if((hsP.value < 6)&&(p.value == cd_proyecto.value)){ div.innerHTML = 'Las hs. en el proyecto deben ser mayor a 5';  hsP.style.background = '#FFF4F4'; hsP.style.borderColor =  "#8E3B1B";  return false;}
										  else {div.innerHTML = '';	
												hsP.style.background = '#FFFFFF';
												hsP.style.borderColor =  "#FFFFFF";
												
												}
										break;
								case '3': if((hs != 4)&&(p.value == cd_proyecto.value)){ div.innerHTML = 'Las hs. en el proyecto deben ser 4'; hsP.style.background = '#FFF4F4'; hsP.style.borderColor =  "#8E3B1B";  return false;}
										  else {div.innerHTML = '';	
												hsP.style.background = '#FFFFFF';
												hsP.style.borderColor =  "#FFFFFF";
												
												}
										break;
								case '5': if(hs > 35){ div.innerHTML = 'Las hs. en el/los proyecto/s no deben superar 35';  hsP.style.background = '#FFF4F4'; hsP.style.borderColor =  "#8E3B1B";  return false;}
											  else {div.innerHTML = '';	
												hsP.style.background = '#FFFFFF';
												hsP.style.borderColor =  "#FFFFFF";
												
												}
										  if((hsP.value < 10)&&(p.value == cd_proyecto.value)){ div.innerHTML = 'Las hs. en el proyecto deben ser mayor a 9';  hsP.style.background = '#FFF4F4'; hsP.style.borderColor =  "#8E3B1B";  return false;}
										  else {div.innerHTML = '';	
												hsP.style.background = '#FFFFFF';
												hsP.style.borderColor =  "#FFFFFF";
												
												}
										  break;
								case '6': if(hs > 35){ div.innerHTML = 'Las hs. en el/los proyecto/s no deben superar 35';  hsP.style.background = '#FFF4F4'; hsP.style.borderColor =  "#8E3B1B";  return false;}
											  else {div.innerHTML = '';	
												hsP.style.background = '#FFFFFF';
												hsP.style.borderColor =  "#FFFFFF";
												
												}
										  if((hsP.value < 10)&&(p.value == cd_proyecto.value)){ div.innerHTML = 'Las hs. en el proyecto deben ser mayor a 9';  hsP.style.background = '#FFF4F4'; hsP.style.borderColor =  "#8E3B1B";  return false;}
										  else {div.innerHTML = '';	
												hsP.style.background = '#FFFFFF';
												hsP.style.borderColor =  "#FFFFFF";
												
												}
										  break;
								default: if(hs > 0){ div.innerHTML = 'No puede aportar horas';  hsP.style.background = '#FFF4F4'; hsP.style.borderColor =  "#8E3B1B";  return false;}
										  else {div.innerHTML = ''; 
												hsP.style.background = '#FFFFFF';
												hsP.style.borderColor =  "#FFFFFF";
												
												}
											break;
							}
						}
					}	
					}
			}
		i++;	
		}
		
	
	
	var div = document.getElementById('cv');
	var ds_curriculum = document.getElementById('ds_curriculum');
	var ds_curriculumH = document.getElementById('ds_curriculumH');
	if((ds_curriculum.value=='')&&(ds_curriculumH.value=='')){
		div.innerHTML = 'Este Campo es requerido.';
		ds_curriculum.style.background = '#FFF4F4';
		ds_curriculum.style.borderColor =  "#8E3B1B";
		return false
		}
	else{
		if(ds_curriculum.value!=''){
			var cv = ds_curriculum.value.toUpperCase();
			if (cv.indexOf('PDF', 0) == -1 && cv.indexOf('DOC', 0) == -1 && cv.indexOf('DOCX', 0) == -1 && cv.indexOf('RTF', 0) == -1){
				div.innerHTML = 'Formato de archivo no v&aacute;lido.';
				ds_curriculum.style.background = '#FFF4F4';
				ds_curriculum.style.borderColor =  "#8E3B1B";
				return false
			}
			else{
				div.innerHTML = '';
				ds_curriculum.style.background = '#FFFFFF';
				ds_curriculum.style.borderColor = '#FFFFFF';
				}
		}
		else{
			div.innerHTML = '';
			ds_curriculum.style.background = '#FFFFFF';
			ds_curriculum.style.borderColor = '#FFFFFF';
			}
	}

	//form.submit();
	
	
	
}

function verificarFiltro(){
	if (document.getElementById('filtro').value==""){
		if(document.getElementById('validar').value=="true"){
			alert("Se debe ingresar un criterio de búsqueda");
			return false;
			
		}
	}
	return true;
}

function verificarCampos(){
	if($('nu_porcentaje').value ==""){
		$('nu_porcentaje').value =="";
	}
}

function volver(form, action){
	form.action = action;
	validarArea();
	//form.submit();
}

