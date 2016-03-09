function cuentaTitulo(){
	
	caracteres = document.getElementById('tex_ti').value.length;
	document.getElementById('car_ti').value = caracteres;

	textoArea = document.getElementById('tex_ti').value;

	inicioBlanco = /^ / // El ^ indica principio de cadena
	finBlanco = / $/ // El $ indica final de cadena
	variosBlancos = /[ ]+/g // El global (g) es para obtener todas las posibles combinaciones 
	coma = /,+/g
	enter = /\n/g
	
	textoArea = textoArea.replace(enter," ");
	textoArea = textoArea.replace(coma," ");
	textoArea = textoArea.replace(variosBlancos," ");
	textoArea = textoArea.replace(inicioBlanco,"");
	textoArea = textoArea.replace(finBlanco,"");
	

	textoAreaDividido = textoArea.split(" ");
	numeroPalabras = textoAreaDividido.length;

	if(caracteres==0){
		document.getElementById("pal_ti").value = 0;
	}else{
		document.getElementById("pal_ti").value = numeroPalabras;
		setTimeout("cuentaTitulo();",300);
	}


} 

function cuentaPosicionamiento(){
	
	caracteres = document.getElementById('tex_posi').value.length;
	document.getElementById('car_posi').value = caracteres;

	textoArea = document.getElementById('tex_posi').value;

	inicioBlanco = /^ / // El ^ indica principio de cadena
	finBlanco = / $/ // El $ indica final de cadena
	variosBlancos = /[ ]+/g // El global (g) es para obtener todas las posibles combinaciones 
	coma = /,+/g
	enter = /\n/g
	
	textoArea = textoArea.replace(enter," ");
	textoArea = textoArea.replace(coma," ");
	textoArea = textoArea.replace(variosBlancos," ");
	textoArea = textoArea.replace(inicioBlanco,"");
	textoArea = textoArea.replace(finBlanco,"");
	

	textoAreaDividido = textoArea.split(" ");
	numeroPalabras = textoAreaDividido.length;

	if(caracteres==0){
		document.getElementById("pal_posi").value = 0;
	}else{
		document.getElementById("pal_posi").value = numeroPalabras;
		setTimeout("cuentaPosicionamiento();",300);
	}
}

function cuentaDescripcion(){
	
	caracteres = document.getElementById('tex_des').value.length;
	document.getElementById('car_des').value = caracteres;

	textoArea = document.getElementById('tex_des').value;

	inicioBlanco = /^ / // El ^ indica principio de cadena
	finBlanco = / $/ // El $ indica final de cadena
	variosBlancos = /[ ]+/g // El global (g) es para obtener todas las posibles combinaciones 
	coma = /,+/g
	enter = /\n/g
	
	textoArea = textoArea.replace(enter," ");
	textoArea = textoArea.replace(coma," ");
	textoArea = textoArea.replace(variosBlancos," ");
	textoArea = textoArea.replace(inicioBlanco,"");
	textoArea = textoArea.replace(finBlanco,"");
	

	textoAreaDividido = textoArea.split(" ");
	numeroPalabras = textoAreaDividido.length;

	if(caracteres==0){
		document.getElementById("pal_des").value = 0;
	}else{
		document.getElementById("pal_des").value = numeroPalabras;
		setTimeout("cuentaDescripcion();",300);
	}
}

function cuentaKeyword(){
	
	caracteres = document.getElementById('tex_key').value.length;
	document.getElementById('car_key').value = caracteres;

	textoArea = document.getElementById('tex_key').value;

	inicioBlanco = /^ / // El ^ indica principio de cadena
	finBlanco = / $/ // El $ indica final de cadena
	variosBlancos = /[ ]+/g // El global (g) es para obtener todas las posibles combinaciones 
	coma = /,+/g
	enter = /\n/g
	
	textoArea = textoArea.replace(enter," ");
	//textoArea = textoArea.replace(coma," ");
	textoArea = textoArea.replace(variosBlancos," ");
	textoArea = textoArea.replace(inicioBlanco,"");
	textoArea = textoArea.replace(finBlanco,"");
	

	textoAreaDividido = textoArea.split(",");
	numeroPalabras = textoAreaDividido.length;

	if(caracteres==0){
		document.getElementById("pal_key").value = 0;
	}else{
		document.getElementById("pal_key").value = numeroPalabras;
		setTimeout("cuentaKeyword();",300);
	}
}

function toggle(className){
    var $input = $(this);
    if($(this).prop('checked'))
        $(className).show();
    else
        $(className).hide();
    }
        
//xxxx aparecer y desaparecer con checkbox x
function imaPrincipal(){
	if($('#ima_def').prop('checked')) {
	//if($('ima_def').attr('checked')) {
    $("#n_ima").hide();
} else {
    $("#n_ima").show();
}

}
//aparecer o desaparecer como un combotext
function tipoIma(idPagina){
	var id = idPagina;
	var index = document.forms.formulario.tip_coleccion.selectedIndex;

	if (index==0) {
		//document.forms.formulario.nom.style.display="inline-block";
		//alert(index);
		//document.getElementById("nuevo").style.display="inline-block";
		document.getElementById("guardar").style.display="none";
		nuevaColeccion(id);
	} else{
		//document.forms.formulario.nom.style.display="none";
		document.getElementById("guardar").style.display="inline-block";
		//document.getElementById("nuevo").style.display="none";
		editarColeccion(id);
	};

}

//insertar codigo html con ajax
function editarColeccion(idPagina)
{
	var nombre = document.forms.formulario.tip_coleccion.value;
	var id = idPagina;
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("coleccion").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/coleccion_edit.php?id="+id+"&nom="+nombre,true);
	xmlhttp.send();
}

function nuevaColeccion(idPagina)
{
	var id = idPagina;
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("coleccion").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/coleccion.php?id="+id,true);
	xmlhttp.send();
}

function selectOpcion()
{
	selectTour();
	var id_opc = document.forms.tour.opcion.value;
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("opcion").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/opcion.php?id="+id_opc,true);
	xmlhttp.send();
}

function quitarOpcion()
{	
	quitarTour('opcion');
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("opcion").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/opcion.php?id=Ninguna",true);
	xmlhttp.send();
}

function selectDuracion()
{
	selectTour();
	var dur= document.forms.tour.duracion.value;
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("duracion").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/duracion.php?dur="+dur,true);
	xmlhttp.send();
}

function quitarDuracion()
{
	quitarTour('duracion');
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("duracion").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/duracion.php?dur=Ninguna",true);
	xmlhttp.send();
}

function selectDesde()
{
	selectTour();
	var des= document.forms.tour.desde.value;
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("desde").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/desde.php?des="+des,true);
	xmlhttp.send();
}

function quitarDesde()
{
	quitarTour('desde');
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("desde").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/desde.php?des=Ninguna",true);
	xmlhttp.send();
}


function selectHasta()
{
	selectTour();
	var has= document.forms.tour.hasta.value;
	var des= document.forms.tour.desde.value;

	// if (parseFloat(has)<parseFloat(des)) { alert("Debe ser Mayor que Desde");};
	// if (parseFloat(has)>parseFloat(des)) { alert("Holas");};

	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("hasta").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/hasta.php?has="+has,true);
	xmlhttp.send();
}

function quitarHasta()
{
	quitarTour('hasta');
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("hasta").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/hasta.php?has=Ninguna",true);
	xmlhttp.send();
}

function selectDestino()
{
	// var region = document.getElementById("region").value;
	// var pais = document.getElementById("pais").value;
	// var ciudad = document.getElementById("ciudad").value;
	// var interior = document.getElementById("interior").value;

	selectTour();
	var region = document.forms.tour.region.value;
	var pais = document.forms.tour.pais.value;
	var ciudad = document.forms.tour.ciudad.value;
	var interior = document.forms.tour.interior.value;
	 // alert(region+pais+ciudad+interior);

	if (region!='Ninguna') {
		selectRegion(region);
		selectPais(region);
		selectCiudad(region);
		selectInterior(region);
	};
	if (pais!='Ninguna') {
		selectRegion(pais);
		selectPais(pais);
		selectCiudad(pais);
		selectInterior(pais);
	};
	if (ciudad!='Ninguna') {
		selectRegion(ciudad);
		selectPais(ciudad);
		selectCiudad(ciudad);
		selectInterior(ciudad);
	};	
	if (interior!='Ninguna') {
		selectRegion(interior);
		selectPais(interior);
		selectCiudad(interior);
		selectInterior(interior);
	};
	
}

function quitarDestino(tipoDestino)
{
	var tipo = tipoDestino;

	var region = document.forms.tour.region.value;
	var pais = document.forms.tour.pais.value;
	var ciudad = document.forms.tour.ciudad.value;
	var interior = document.forms.tour.interior.value;	

	if (tipo=='region') {
		selectRegion('Ninguna');
		selectPais('Ninguna');
		selectCiudad('Ninguna');
		selectInterior('Ninguna');
		quitarTour('region');

	};
	if (tipo=='pais') {
		selectRegion(region);
		selectPais(region);
		selectCiudad(region);
		selectInterior(region);
		quitarTour('pais');

	};
	if (tipo=='ciudad') {
		selectRegion(pais);
		selectPais(pais);
		selectCiudad(pais);
		selectInterior(pais);
		quitarTour('ciudad');

	};	
	if (tipo=='interior') {
		selectRegion(ciudad);
		selectPais(ciudad);
		selectCiudad(ciudad);
		selectInterior(ciudad);
		quitarTour('interior');

	};
}
 
function selectRegion(idPagina)
{
	var id = idPagina;
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("region").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/destino_region.php?id="+id,true);
	xmlhttp.send();
}

function selectPais(idPagina)
{
	var id = idPagina;
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("pais").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/destino_pais.php?id="+id,true);
	xmlhttp.send();
}

function selectCiudad(idPagina)
{
	var id = idPagina;
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("ciudad").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/destino_ciudad.php?id="+id,true);
	xmlhttp.send();
}

function selectInterior(idPagina)
{
	var id = idPagina;
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("interior").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/destino_interior.php?id="+id,true);
	xmlhttp.send();
}


function selectTour()
{	
	var opcion = document.forms.tour.opcion.value;
	var region = document.forms.tour.region.value;
	var pais = document.forms.tour.pais.value;
	var ciudad = document.forms.tour.ciudad.value;
	var interior = document.forms.tour.interior.value;	
	var duracion = document.forms.tour.duracion.value;
	var desde = document.forms.tour.desde.value;
	var hasta = document.forms.tour.hasta.value;
	// alert("opcion="+opcion+"&region="+region+"&pais="+pais+"&ciudad="+ciudad+"&interior="+interior+"&duracion="+duracion+"&desde="+desde+"&hasta="+hasta);

	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("tour").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/filtro_tour.php?opcion="+opcion+"&region="+region+"&pais="+pais+"&ciudad="+ciudad+"&interior="+interior+"&duracion="+duracion+"&desde="+desde+"&hasta="+hasta,true);
	xmlhttp.send();	
}

function quitarTour(TipoVar)
{	
	var tipo = TipoVar;
	var opcion = document.forms.tour.opcion.value;
	var region = document.forms.tour.region.value;
	var pais = document.forms.tour.pais.value;
	var ciudad = document.forms.tour.ciudad.value;
	var interior = document.forms.tour.interior.value;	
	var duracion = document.forms.tour.duracion.value;
	var desde = document.forms.tour.desde.value;
	var hasta = document.forms.tour.hasta.value;

	if (tipo=="opcion") { opcion = "Ninguna";}
	if (tipo=="region") { region = "Ninguna"; pais = "Ninguna"; ciudad = "Ninguna"; interior = "Ninguna";}
	if (tipo=="pais") { pais = "Ninguna"; ciudad = "Ninguna"; interior = "Ninguna";}
	if (tipo=="ciudad") { ciudad = "Ninguna"; interior = "Ninguna";}
	if (tipo=="interior") { interior = "Ninguna";}
	if (tipo=="duracion") { duracion = "Ninguna";}
	if (tipo=="desde") { desde = "Ninguna";}
	if (tipo=="hasta") { hasta = "Ninguna";}

	// alert("opcion="+opcion+"&region="+region+"&pais="+pais+"&ciudad="+ciudad+"&interior="+interior+"&duracion="+duracion+"&desde="+desde+"&hasta="+hasta);

	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("tour").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/filtro_tour.php?opcion="+opcion+"&region="+region+"&pais="+pais+"&ciudad="+ciudad+"&interior="+interior+"&duracion="+duracion+"&desde="+desde+"&hasta="+hasta,true);
	xmlhttp.send();	
}





// Buscar destino
function selectDest()
{
	selectDestDestino();
	var region = document.forms.destino.region.value;
	var pais = document.forms.destino.pais.value;
	var ciudad = document.forms.destino.ciudad.value;

	// alert(region+pais+ciudad);

	if (region!='Ninguna') {
		selectReg(region);
		selectPai(region);
		selectCiu(region);

	};

	if (pais!='Ninguna') {
		selectReg(pais);
		selectPai(pais);
		selectCiu(pais);

	};

	if (ciudad!='Ninguna') {
		selectReg(ciudad);
		selectPai(ciudad);
		selectCiu(ciudad);

	};	

}

function quitarDest(tipoDestino)
{
	var tipo = tipoDestino;

	var region = document.forms.destino.region.value;
	var pais = document.forms.destino.pais.value;
	var ciudad = document.forms.destino.ciudad.value;

	if (tipo=='region') {
		selectReg('Ninguna');
		selectPai('Ninguna');
		selectCiu('Ninguna');
		quitarDestDestino('region');
	};

	if (tipo=='pais') {
		selectReg(region);
		selectPai(region);
		selectCiu(region);
		quitarDestDestino('pais');
	};

	if (tipo=='ciudad') {
		selectReg(pais);
		selectPai(pais);
		selectCiu(pais);
		quitarDestDestino('ciudad');
	};

}
 
function selectReg(idPagina)
{
	var id = idPagina;
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("reg_des").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/dest_region.php?id="+id,true);
	xmlhttp.send();
}

function selectPai(idPagina)
{
	var id = idPagina;
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("pai_des").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/dest_pais.php?id="+id,true);
	xmlhttp.send();
}

function selectCiu(idPagina)
{
	var id = idPagina;
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("ciu_des").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/dest_ciudad.php?id="+id,true);
	xmlhttp.send();
}

function selectDestDestino()
{	
	var region = document.forms.destino.region.value;
	var pais = document.forms.destino.pais.value;
	var ciudad = document.forms.destino.ciudad.value;
	// alert("opcion="+opcion+"&region="+region+"&pais="+pais+"&ciudad="+ciudad+"&interior="+interior+"&duracion="+duracion+"&desde="+desde+"&hasta="+hasta);

	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("total_des").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/filtro_destino.php?region="+region+"&pais="+pais+"&ciudad="+ciudad,true);
	xmlhttp.send();	
}

function quitarDestDestino(TipoVar)
{	
	var tipo = TipoVar;
	var region = document.forms.destino.region.value;
	var pais = document.forms.destino.pais.value;
	var ciudad = document.forms.destino.ciudad.value;

	if (tipo=="region") { region = "Ninguna"; pais = "Ninguna"; ciudad = "Ninguna";}
	if (tipo=="pais") { pais = "Ninguna"; ciudad = "Ninguna";}
	if (tipo=="ciudad") { ciudad = "Ninguna";}

	// alert("region="+region+"&pais="+pais+"&ciudad="+ciudad);

	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("total_des").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/filtro_destino.php?region="+region+"&pais="+pais+"&ciudad="+ciudad,true);
	xmlhttp.send();	
}



//Buscar Alojamiento
function selectTipoAloja()
{
	selectAlojamiento();
	var tipoaloja = document.forms.alojamiento.tipoaloja.value;
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("tipoaloja").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/tipo_aloja.php?tipoaloja="+tipoaloja,true);
	xmlhttp.send();
}

function quitarTipoAloja()
{	
	quitarAlojamiento('tipoaloja');
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("tipoaloja").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/tipo_aloja.php?tipoaloja=Ninguna",true);
	xmlhttp.send();
}

function selectCateAloja()
{
	selectAlojamiento();
	var catealoja= document.forms.alojamiento.catealoja.value;
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("catealoja").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/cate_aloja.php?catealoja="+catealoja,true);
	xmlhttp.send();
}

function quitarCateAloja()
{
	quitarAlojamiento('catealoja');
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("catealoja").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/cate_aloja.php?catealoja=Ninguna",true);
	xmlhttp.send();
}

function selectTipHab()
{
	selectAlojamiento();
	var tiphab= document.forms.alojamiento.tiphab.value;
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("tiphab").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/tip_hab.php?tiphab="+tiphab,true);
	xmlhttp.send();
}

function quitarTipHab()
{
	quitarAlojamiento('tiphab');
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("tiphab").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/tip_hab.php?tiphab=Ninguna",true);
	xmlhttp.send();
}

function selectDesdeHab()
{
	selectAlojamiento();
	var desdehab= document.forms.alojamiento.desdehab.value;
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("desdehab").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/desde_hab.php?desdehab="+desdehab,true);
	xmlhttp.send();
}

function quitarDesdeHab()
{
	quitarAlojamiento('desdehab');
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("desdehab").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/desde_hab.php?desdehab=Ninguna",true);
	xmlhttp.send();
}

function selectHastaHab()
{
	selectAlojamiento();
	var hastahab= document.forms.alojamiento.hastahab.value;
	var desdehab= document.forms.alojamiento.desdehab.value;

	// if (parseFloat(hastahab)<parseFloat(desdehab)) { alert("Debe ser Mayor que Desde");};
	// if (parseFloat(hastahab)>parseFloat(desdehab)) { alert("Holas");};

	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("hastahab").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/hasta_hab.php?hastahab="+hastahab,true);
	xmlhttp.send();
}

function quitarHastaHab()
{
	quitarAlojamiento('hastahab');
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("hastahab").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/hasta_hab.php?hastahab=Ninguna",true);
	xmlhttp.send();
}

//------//

function selectDestAloja()
{

	selectAlojamiento();
	var regaloja = document.forms.alojamiento.regaloja.value;
	var paialoja = document.forms.alojamiento.paialoja.value;
	var ciualoja = document.forms.alojamiento.ciualoja.value;
	var intaloja = document.forms.alojamiento.intaloja.value;
	// alert(regaloja+paialoja+ciualoja+intaloja);

	if (regaloja!='Ninguna') {
		selectRegAlo(regaloja);
		selectPaiAlo(regaloja);
		selectCiuAlo(regaloja);
		selectIntAlo(regaloja);
	}
	if (paialoja!='Ninguna') {
		selectRegAlo(paialoja);
		selectPaiAlo(paialoja);
		selectCiuAlo(paialoja);
		selectIntAlo(paialoja);
	}
	if (ciualoja!='Ninguna') {
		selectRegAlo(ciualoja);
		selectPaiAlo(ciualoja);
		selectCiuAlo(ciualoja);
		selectIntAlo(ciualoja);
	}
	if (intaloja!='Ninguna') {
		selectRegAlo(intaloja);
		selectPaiAlo(intaloja);
		selectCiuAlo(intaloja);
		selectIntAlo(intaloja);
	}
}

function quitarDestAloja(tipoDestino)
{
	var tipo = tipoDestino;

	var regaloja = document.forms.alojamiento.regaloja.value;
	var paialoja = document.forms.alojamiento.paialoja.value;
	var ciualoja = document.forms.alojamiento.ciualoja.value;
	var intaloja = document.forms.alojamiento.intaloja.value;	

	if (tipo=='regaloja') {
		selectRegAlo('Ninguna');
		selectPaiAlo('Ninguna');
		selectCiuAlo('Ninguna');
		selectIntAlo('Ninguna');
		quitarAlojamiento('regaloja');
	}
	if (tipo=='paialoja') {
		selectRegAlo(regaloja);
		selectPaiAlo(regaloja);
		selectCiuAlo(regaloja);
		selectIntAlo(regaloja);
		quitarAlojamiento('paialoja');
	}
	if (tipo=='ciualoja') {
		selectRegAlo(paialoja);
		selectPaiAlo(paialoja);
		selectCiuAlo(paialoja);
		selectIntAlo(paialoja);
		quitarAlojamiento('ciualoja');
	}	
	if (tipo=='intaloja') {
		selectRegAlo(ciualoja);
		selectPaiAlo(ciualoja);
		selectCiuAlo(ciualoja);
		selectIntAlo(ciualoja);
		quitarAlojamiento('intaloja');
	}
}

function selectRegAlo(idPagina)
{
	var id = idPagina;
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("regaloja").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/dest_alo_reg.php?id="+id,true);
	xmlhttp.send();
}

function selectPaiAlo(idPagina)
{
	var id = idPagina;
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("paialoja").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/dest_alo_pai.php?id="+id,true);
	xmlhttp.send();
}

function selectCiuAlo(idPagina)
{
	var id = idPagina;
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("ciualoja").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/dest_alo_ciu.php?id="+id,true);
	xmlhttp.send();
}

function selectIntAlo(idPagina)
{
	var id = idPagina;
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("intaloja").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/dest_alo_int.php?id="+id,true);
	xmlhttp.send();
}

function selectAlojamiento()
{	
	var regaloja = document.forms.alojamiento.regaloja.value;
	var paialoja = document.forms.alojamiento.paialoja.value;
	var ciualoja = document.forms.alojamiento.ciualoja.value;
	var intaloja = document.forms.alojamiento.intaloja.value;

	var tipoaloja = document.forms.alojamiento.tipoaloja.value;
	var catealoja = document.forms.alojamiento.catealoja.value;
	var tiphab = document.forms.alojamiento.tiphab.value;
	var desdehab = document.forms.alojamiento.desdehab.value;
	var hastahab = document.forms.alojamiento.hastahab.value;
	// alert("opcion="+opcion+"&regaloja="+regaloja+"&paialoja="+paialoja+"&ciualoja="+ciualoja+"&intaloja="+intaloja+"&duracion="+duracion+"&desde="+desde+"&hasta="+hasta);

	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("total_aloja").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/filtro_alojamiento.php?regaloja="+regaloja+"&paialoja="+paialoja+"&ciualoja="+ciualoja+"&intaloja="+intaloja+"&tipoaloja="+tipoaloja+"&catealoja="+catealoja+"&tiphab="+tiphab+"&desdehab="+desdehab+"&hastahab="+hastahab,true);
	xmlhttp.send();	
}

function quitarAlojamiento(TipoVar)
{	
	var tipo = TipoVar;
	var regaloja = document.forms.alojamiento.regaloja.value;
	var paialoja = document.forms.alojamiento.paialoja.value;
	var ciualoja = document.forms.alojamiento.ciualoja.value;
	var intaloja = document.forms.alojamiento.intaloja.value;
		
	var tipoaloja = document.forms.alojamiento.tipoaloja.value;
	var catealoja = document.forms.alojamiento.catealoja.value;
	var tiphab = document.forms.alojamiento.tiphab.value;
	var desdehab = document.forms.alojamiento.desdehab.value;
	var hastahab = document.forms.alojamiento.hastahab.value;

	if (tipo=="regaloja") { regaloja = "Ninguna"; paialoja = "Ninguna"; ciualoja = "Ninguna"; intaloja = "Ninguna";}
	if (tipo=="paialoja") { paialoja = "Ninguna"; ciualoja = "Ninguna"; intaloja = "Ninguna";}
	if (tipo=="ciualoja") { ciualoja = "Ninguna"; intaloja = "Ninguna";}
	if (tipo=="intaloja") { intaloja = "Ninguna";}
	if (tipo=="tipoaloja") { tipoaloja = "Ninguna";}
	if (tipo=="catealoja") { catealoja = "Ninguna";}
	if (tipo=="tiphab") { tiphab = "Ninguna";}
	if (tipo=="desdehab") { desdehab = "Ninguna";}
	if (tipo=="hastahab") { hastahab = "Ninguna";}

	// alert("opcion="+opcion+"&regaloja="+regaloja+"&paialoja="+paialoja+"&ciualoja="+ciualoja+"&intaloja="+intaloja+"&duracion="+duracion+"&desde="+desde+"&hasta="+hasta);

	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("total_aloja").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/filtro_alojamiento.php?regaloja="+regaloja+"&paialoja="+paialoja+"&ciualoja="+ciualoja+"&intaloja="+intaloja+"&tipoaloja="+tipoaloja+"&catealoja="+catealoja+"&tiphab="+tiphab+"&desdehab="+desdehab+"&hastahab="+hastahab,true);
	xmlhttp.send();	
}









//Buscar Restaurante
function selectEspRest()
{
	selectRestaurante();
	var esprest = document.forms.restaurante.esprest.value;
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("esprest").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/esp_rest.php?esprest="+esprest,true);
	xmlhttp.send();
}

function quitarEspRest()
{	
	quitarRestaurante('tiporest');
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("esprest").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/esp_rest.php?esprest=Ninguna",true);
	xmlhttp.send();
}

function selectTipRest()
{
	selectRestaurante();
	var tiprest= document.forms.restaurante.tiprest.value;
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("tiprest").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/tip_rest.php?tiprest="+tiprest,true);
	xmlhttp.send();
}

function quitarTipRest()
{
	quitarRestaurante('tiprest');
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("tiprest").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/tip_rest.php?tiprest=Ninguna",true);
	xmlhttp.send();
}

function selectOcaRest()
{
	selectRestaurante();
	var ocarest= document.forms.restaurante.ocarest.value;
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("ocarest").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/oca_rest.php?ocarest="+ocarest,true);
	xmlhttp.send();
}

function quitarOcaRest()
{
	quitarRestaurante('ocarest');
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("ocarest").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/oca_rest.php?ocarest=Ninguna",true);
	xmlhttp.send();
}

function selectDesdeRest()
{
	selectRestaurante();
	var desdepla= document.forms.restaurante.desdepla.value;
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("desdepla").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/desde_pla.php?desdepla="+desdepla,true);
	xmlhttp.send();
}

function quitarDesdeRest()
{
	quitarRestaurante('desdepla');
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("desdepla").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/desde_pla.php?desdepla=Ninguna",true);
	xmlhttp.send();
}

function selectHastaRest()
{
	selectRestaurante();
	var hastapla= document.forms.restaurante.hastapla.value;
	var desdepla= document.forms.restaurante.desdepla.value;

	// if (parseFloat(hastahab)<parseFloat(desdehab)) { alert("Debe ser Mayor que Desde");};
	// if (parseFloat(hastahab)>parseFloat(desdehab)) { alert("Holas");};

	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("hastapla").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/hasta_pla.php?hastapla="+hastapla,true);
	xmlhttp.send();
}

function quitarHastaRest()
{
	quitarRestaurante('hastapla');
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("hastapla").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/hasta_pla.php?hastapla=Ninguna",true);
	xmlhttp.send();
}

//------//

function selectDestRest()
{

	selectRestaurante();
	var regrest = document.forms.restaurante.regrest.value;
	var pairest = document.forms.restaurante.pairest.value;
	var ciurest = document.forms.restaurante.ciurest.value;
	var intrest = document.forms.restaurante.intrest.value;
	

	if (regrest!='Ninguna') {
		selectRegRest(regrest);
		selectPaiRest(regrest);
		selectCiuRest(regrest);
		selectIntRest(regrest);
	}
	if (pairest!='Ninguna') {
		selectRegRest(pairest);
		selectPaiRest(pairest);
		selectCiuRest(pairest);
		selectIntRest(pairest);
	}
	if (ciurest!='Ninguna') {
		selectRegRest(ciurest);
		selectPaiRest(ciurest);
		selectCiuRest(ciurest);
		selectIntRest(ciurest);
	}
	if (intrest!='Ninguna') {
		selectRegRest(intrest);
		selectPaiRest(intrest);
		selectCiuRest(intrest);
		selectIntRest(intrest);
	}
}

function quitarDestRest(tipoDestino)
{
	var tipo = tipoDestino;

	var regrest = document.forms.restaurante.regrest.value;
	var pairest = document.forms.restaurante.pairest.value;
	var ciurest = document.forms.restaurante.ciurest.value;
	var intrest = document.forms.restaurante.intrest.value;	

	if (tipo=='regrest') {
		selectRegRest('Ninguna');
		selectPaiRest('Ninguna');
		selectCiuRest('Ninguna');
		selectIntRest('Ninguna');
		quitarRestaurante('regrest');
	}
	if (tipo=='pairest') {
		selectRegRest(regrest);
		selectPaiRest(regrest);
		selectCiuRest(regrest);
		selectIntRest(regrest);
		quitarRestaurante('pairest');
	}
	if (tipo=='ciurest') {
		selectRegRest(pairest);
		selectPaiRest(pairest);
		selectCiuRest(pairest);
		selectIntRest(pairest);
		quitarRestaurante('ciurest');
	}	
	if (tipo=='intrest') {
		selectRegRest(ciurest);
		selectPaiRest(ciurest);
		selectCiuRest(ciurest);
		selectIntRest(ciurest);
		quitarRestaurante('intrest');
	}
}

function selectRegRest(idPagina)
{
	var id = idPagina;
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("regrest").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/dest_rest_reg.php?id="+id,true);
	xmlhttp.send();
}

function selectPaiRest(idPagina)
{
	var id = idPagina;
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("pairest").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/dest_rest_pai.php?id="+id,true);
	xmlhttp.send();
}

function selectCiuRest(idPagina)
{
	var id = idPagina;
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("ciurest").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/dest_rest_ciu.php?id="+id,true);
	xmlhttp.send();
}

function selectIntRest(idPagina)
{
	var id = idPagina;
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("intrest").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/dest_rest_int.php?id="+id,true);
	xmlhttp.send();
}

function selectRestaurante()
{	
	var regrest = document.forms.restaurante.regrest.value;
	var pairest = document.forms.restaurante.pairest.value;
	var ciurest = document.forms.restaurante.ciurest.value;
	var intrest = document.forms.restaurante.intrest.value;

	var esprest = document.forms.restaurante.esprest.value;
	var tiprest = document.forms.restaurante.tiprest.value;
	var ocarest = document.forms.restaurante.ocarest.value;
	var desdepla = document.forms.restaurante.desdepla.value;
	var hastapla = document.forms.restaurante.hastapla.value;
	

	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("total_rest").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/filtro_restaurante.php?regrest="+regrest+"&pairest="+pairest+"&ciurest="+ciurest+"&intrest="+intrest+"&esprest="+esprest+"&tiprest="+tiprest+"&ocarest="+ocarest+"&desdepla="+desdepla+"&hastapla="+hastapla,true);
	xmlhttp.send();	
}

function quitarRestaurante(TipoVar)
{	
	var tipo = TipoVar;
	var regrest = document.forms.restaurante.regrest.value;
	var pairest = document.forms.restaurante.pairest.value;
	var ciurest = document.forms.restaurante.ciurest.value;
	var intrest = document.forms.restaurante.intrest.value;

	var esprest = document.forms.restaurante.esprest.value;
	var tiprest = document.forms.restaurante.tiprest.value;
	var ocarest = document.forms.restaurante.ocarest.value;
	var desdepla = document.forms.restaurante.desdepla.value;
	var hastapla = document.forms.restaurante.hastapla.value;

	if (tipo=="regrest") { regrest = "Ninguna"; pairest = "Ninguna"; ciurest = "Ninguna"; intrest = "Ninguna";}
	if (tipo=="pairest") { pairest = "Ninguna"; ciurest = "Ninguna"; intrest = "Ninguna";}
	if (tipo=="ciurest") { ciurest = "Ninguna"; intrest = "Ninguna";}
	if (tipo=="intrest") { intrest = "Ninguna";}

	if (tipo=="esprest") { esprest = "Ninguna";}
	if (tipo=="tiprest") { tiprest = "Ninguna";}
	if (tipo=="ocarest") { ocarest = "Ninguna";}
	if (tipo=="desdepla") { desdepla = "Ninguna";}
	if (tipo=="hastapla") { hastapla = "Ninguna";}

	// alert("opcion="+opcion+"&regaloja="+regaloja+"&paialoja="+paialoja+"&ciualoja="+ciualoja+"&intaloja="+intaloja+"&duracion="+duracion+"&desde="+desde+"&hasta="+hasta);

	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("total_rest").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/filtro_restaurante.php?regrest="+regrest+"&pairest="+pairest+"&ciurest="+ciurest+"&intrest="+intrest+"&esprest="+esprest+"&tiprest="+tiprest+"&ocarest="+ocarest+"&desdepla="+desdepla+"&hastapla="+hastapla,true);
	xmlhttp.send();	
}














//Buscar Tienda
function selectCatTien()
{
	selectTienda();
	var cattien = document.forms.tienda.cattien.value;
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("cattien").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/cat_tien.php?cattien="+cattien,true);
	xmlhttp.send();
}

function quitarCatTien()
{	
	quitarTienda('cattien');
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("cattien").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/cat_tien.php?cattien=Ninguna",true);
	xmlhttp.send();
}

function selectDesdeTien()
{
	selectTienda();
	var desdetien= document.forms.tienda.desdetien.value;
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("desdetien").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/desde_tien.php?desdetien="+desdetien,true);
	xmlhttp.send();
}

function quitarDesdeTien()
{
	quitarTienda('desdetien');
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("desdetien").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/desde_tien.php?desdetien=Ninguna",true);
	xmlhttp.send();
}

function selectHastaTien()
{
	selectTienda();
	var hastatien= document.forms.tienda.hastatien.value;
	var desdetien= document.forms.tienda.desdetien.value;

	// if (parseFloat(hastahab)<parseFloat(desdehab)) { alert("Debe ser Mayor que Desde");};
	// if (parseFloat(hastahab)>parseFloat(desdehab)) { alert("Holas");};

	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("hastatien").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/hasta_tien.php?hastatien="+hastatien,true);
	xmlhttp.send();
}

function quitarHastaTien()
{
	quitarTienda('hastatien');
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("hastatien").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/hasta_tien.php?hastatien=Ninguna",true);
	xmlhttp.send();
}

//------//

function selectDestTien()
{

	selectTienda();
	var regtien = document.forms.tienda.regtien.value;
	var paitien = document.forms.tienda.paitien.value;
	var ciutien = document.forms.tienda.ciutien.value;
	var inttien = document.forms.tienda.inttien.value;
	

	if (regtien!='Ninguna') {
		selectRegTien(regtien);
		selectPaiTien(regtien);
		selectCiuTien(regtien);
		selectIntTien(regtien);
	}
	if (paitien!='Ninguna') {
		selectRegTien(paitien);
		selectPaiTien(paitien);
		selectCiuTien(paitien);
		selectIntTien(paitien);
	}
	if (ciutien!='Ninguna') {
		selectRegTien(ciutien);
		selectPaiTien(ciutien);
		selectCiuTien(ciutien);
		selectIntTien(ciutien);
	}
	if (inttien!='Ninguna') {
		selectRegTien(inttien);
		selectPaiTien(inttien);
		selectCiuTien(inttien);
		selectIntTien(inttien);
	}
}

function quitarDestTien(tipoDestino)
{
	var tipo = tipoDestino;

	var regtien = document.forms.tienda.regtien.value;
	var paitien = document.forms.tienda.paitien.value;
	var ciutien = document.forms.tienda.ciutien.value;
	var inttien = document.forms.tienda.inttien.value;	

	if (tipo=='regtien') {
		selectRegTien('Ninguna');
		selectPaiTien('Ninguna');
		selectCiuTien('Ninguna');
		selectIntTien('Ninguna');
		quitarTienda('regtien');
	}
	if (tipo=='paitien') {
		selectRegTien(regtien);
		selectPaiTien(regtien);
		selectCiuTien(regtien);
		selectIntTien(regtien);
		quitarTienda('paitien');
	}
	if (tipo=='ciutien') {
		selectRegTien(paitien);
		selectPaiTien(paitien);
		selectCiuTien(paitien);
		selectIntTien(paitien);
		quitarTienda('ciutien');
	}	
	if (tipo=='inttien') {
		selectRegTien(ciutien);
		selectPaiTien(ciutien);
		selectCiuTien(ciutien);
		selectIntTien(ciutien);
		quitarTienda('inttien');
	}
}

function selectRegTien(idPagina)
{
	var id = idPagina;
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("regtien").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/dest_tien_reg.php?id="+id,true);
	xmlhttp.send();
}

function selectPaiTien(idPagina)
{
	var id = idPagina;
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("paitien").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/dest_tien_pai.php?id="+id,true);
	xmlhttp.send();
}

function selectCiuTien(idPagina)
{
	var id = idPagina;
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("ciutien").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/dest_tien_ciu.php?id="+id,true);
	xmlhttp.send();
}

function selectIntTien(idPagina)
{
	var id = idPagina;
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("inttien").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/dest_tien_int.php?id="+id,true);
	xmlhttp.send();
}

function selectTienda()
{	
	var regtien = document.forms.tienda.regtien.value;
	var paitien = document.forms.tienda.paitien.value;
	var ciutien = document.forms.tienda.ciutien.value;
	var inttien = document.forms.tienda.inttien.value;

	var cattien = document.forms.tienda.cattien.value;
	var desdetien = document.forms.tienda.desdetien.value;
	var hastatien = document.forms.tienda.hastatien.value;	

	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("total_tien").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/filtro_tienda.php?regtien="+regtien+"&paitien="+paitien+"&ciutien="+ciutien+"&inttien="+inttien+"&cattien="+cattien+"&desdetien="+desdetien+"&hastatien="+hastatien,true);
	xmlhttp.send();	
}

function quitarTienda(TipoVar)
{	
	var tipo = TipoVar;
	var regtien = document.forms.tienda.regtien.value;
	var paitien = document.forms.tienda.paitien.value;
	var ciutien = document.forms.tienda.ciutien.value;
	var inttien = document.forms.tienda.inttien.value;

	var cattien = document.forms.tienda.cattien.value;
	var desdetien = document.forms.tienda.desdetien.value;
	var hastatien = document.forms.tienda.hastatien.value;

	if (tipo=="regtien") { regtien = "Ninguna"; paitien = "Ninguna"; ciutien = "Ninguna"; inttien = "Ninguna";}
	if (tipo=="paitien") { paitien = "Ninguna"; ciutien = "Ninguna"; inttien = "Ninguna";}
	if (tipo=="ciutien") { ciutien = "Ninguna"; inttien = "Ninguna";}
	if (tipo=="inttien") { inttien = "Ninguna";}

	if (tipo=="cattien") { cattien = "Ninguna";}
	if (tipo=="desdetien") { desdetien = "Ninguna";}
	if (tipo=="hastatien") { hastatien = "Ninguna";}

	// alert("opcion="+opcion+"&regaloja="+regaloja+"&paialoja="+paialoja+"&ciualoja="+ciualoja+"&intaloja="+intaloja+"&duracion="+duracion+"&desde="+desde+"&hasta="+hasta);

	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("total_tien").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/filtro_tienda.php?regtien="+regtien+"&paitien="+paitien+"&ciutien="+ciutien+"&inttien="+inttien+"&cattien="+cattien+"&desdetien="+desdetien+"&hastatien="+hastatien,true);
	xmlhttp.send();	
}















//aparecer o desaparecer como un combotext
function Visto(idPagina){
	var id = idPagina;

	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("res_vito_"+id).innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/dise_tic_leido.php?id="+id,true);
	xmlhttp.send();
}

//aparecer o desaparecer como un combotext
function Favorito(idPagina){
	var id = idPagina;

	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("res_fav_"+id).innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/dise_tic_favorito.php?id="+id,true);
	xmlhttp.send();
}


//comentarios de las paginas del mismo sitio tours
function Coment(idPertenece,idPagina){
	var per = idPertenece;
	var pag = idPagina;
	var nick = document.getElementById("nick_"+per).value;
	var mail = document.getElementById("mail_"+per).value;
	var des = document.getElementById("des_"+per).value;
	var ok = document.getElementById("like_"+per).checked;

	if (ok==0) {
		var like=0;
	}else {
		var like=1;
	}
	// alert(per+pag+nick+mail+des+like+ok);

	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("coment_"+per).innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/dise_tic_coment.php?per="+per+"&pag="+pag+"&nick="+nick+"&mail="+mail+"&des="+des+"&like="+like,true);
	xmlhttp.send();
}

//Votar
function Votar(idPagina,voto){
	var id = idPagina;
	var voto = voto;

	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("voto").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/voto.php?id="+id+"&voto="+voto,true);
	xmlhttp.send();
}

function Consulta(){


	var pag = document.forms.consulta.pag.value;
	var mail = document.forms.consulta.mail.value;
	var mensaje = document.forms.consulta.mensaje.value;
	// alert("hola");

	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("consulta").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/consulta.php?mail="+mail+"&id="+pag+"&mensaje="+mensaje,true);
	xmlhttp.send();
}

//Votar Comentario
function VotarComentario(idComentario,voto){
	var id = idComentario;
	var voto = voto;

	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("voto-comentario-"+id).innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","/voto_comentario.php?id="+id+"&voto="+voto,true);
	xmlhttp.send();
}