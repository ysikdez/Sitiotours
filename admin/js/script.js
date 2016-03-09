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
	xmlhttp.open("GET","coleccion_edit.php?id="+id+"&nom="+nombre,true);
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
	xmlhttp.open("GET","coleccion.php?id="+id,true);
	xmlhttp.send();
}

function selectDestino()
{
	// var region = document.getElementById("region").value;
	// var pais = document.getElementById("pais").value;
	// var ciudad = document.getElementById("ciudad").value;
	// var interior = document.getElementById("interior").value;

	var region = document.forms.formulario.region.value;
	var pais = document.forms.formulario.pais.value;
	var ciudad = document.forms.formulario.ciudad.value;
	var interior = document.forms.formulario.interior.value;
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

	var region = document.forms.formulario.region.value;
	var pais = document.forms.formulario.pais.value;
	var ciudad = document.forms.formulario.ciudad.value;
	var interior = document.forms.formulario.interior.value;	

	if (tipo=='region') {
		selectRegion('Ninguna');
		selectPais('Ninguna');
		selectCiudad('Ninguna');
		selectInterior('Ninguna');
	};
	if (tipo=='pais') {
		selectRegion(region);
		selectPais(region);
		selectCiudad(region);
		selectInterior(region);

	};
	if (tipo=='ciudad') {
		selectRegion(pais);
		selectPais(pais);
		selectCiudad(pais);
		selectInterior(pais);

	};	
	if (tipo=='interior') {
		selectRegion(ciudad);
		selectPais(ciudad);
		selectCiudad(ciudad);
		selectInterior(ciudad);
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
	xmlhttp.open("GET","destino_region.php?id="+id,true);
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
	xmlhttp.open("GET","destino_pais.php?id="+id,true);
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
	xmlhttp.open("GET","destino_ciudad.php?id="+id,true);
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
	xmlhttp.open("GET","destino_interior.php?id="+id,true);
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
	xmlhttp.open("GET","dise_tic_leido.php?id="+id,true);
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
	xmlhttp.open("GET","dise_tic_favorito.php?id="+id,true);
	xmlhttp.send();
}

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
	xmlhttp.open("GET","dise_tic_coment.php?per="+per+"&pag="+pag+"&nick="+nick+"&mail="+mail+"&des="+des+"&like="+like,true);
	xmlhttp.send();
}