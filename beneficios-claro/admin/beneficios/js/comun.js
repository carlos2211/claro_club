/*Validar inserta caracteres*/
function solocar_num(x,y){
//onKeyPress="solocar_num(event.keyCode,String.fromCharCode(event.keyCode));"
  var txt="01234567890";
  if (txt.indexOf(y)!=-1)
    event.returnValue = true;
  else
    event.returnValue = false;
}

function solocar_textnumdir(x,y){
//onKeyPress="solocar_textnumdir(event.keyCode,String.fromCharCode(event.keyCode));"
var txt="01234567890 abcdefghijklmnñopqrstuvwxyz ABCDEFGHIJKLMNÑOPQRSTUVWXYZ áéíóúÁÉÍÓÚÑñ#,.";
  if (txt.indexOf(y)!=-1)
      event.returnValue = true;
  else
      event.returnValue = false;
}

function carac_rut(e) { // 1
  //onkeypress="return carac_rut(event);"
    tecla = (document.all) ? e.keyCode : e.which; // 2
    if (tecla==8) return true; // 3
   if (tecla==9) return true; // 3
   if (tecla==11) return true; // 3
    patron = /[0-9Kk.-]/; // 4
    
 
    te = String.fromCharCode(tecla); // 5
    return patron.test(te); // 6
}
function solocar_nombre(e) { // 1
  // onkeypress="return validar(event);"
    tecla = (document.all) ? e.keyCode : e.which; // 2
    if (tecla==8) return true; // 3
    patron =/[a-zA-Z áéíóúÁÉÍÓÚÑñ\s]/; // 4
    te = String.fromCharCode(tecla); // 5
    return patron.test(te); // 6
}
/*FIN Validar inserta caracteres*/

/*Validar Rut y Formatear*/
/*
javascript:return Rut(document.form1.rut.value) || Rut($rut);
*/

function revisarDigito( dvr )
{ 
  dv = dvr + "" 
  if ( dv != '0' && dv != '1' && dv != '2' && dv != '3' && dv != '4' && dv != '5' && dv != '6' && dv != '7' && dv != '8' && dv != '9' && dv != 'k'  && dv != 'K') 
  {   
    //alert("Debe ingresar un digito verificador valido");    
   // window.document.form1.rut.focus();    
    //window.document.form1.rut.select();   
    return false; 
  } 
  return true;
}

function revisarDigito2( crut )
{ 
  largo = crut.length;  
  if ( largo < 2 )  
  {   
    //alert("Debe ingresar el rut completo")    
    //window.document.form1.rut.focus();    
    //window.document.form1.rut.select();   
    return false; 
  } 
  if ( largo > 2 )    
    rut = crut.substring(0, largo - 1); 
  else    
    rut = crut.charAt(0); 
  dv = crut.charAt(largo-1);  
  revisarDigito( dv );  

  if ( rut == null || dv == null )
    return 0  

  var dvr = '0' 
  suma = 0  
  mul  = 2  

  for (i= rut.length -1 ; i >= 0; i--)  
  { 
    suma = suma + rut.charAt(i) * mul   
    if (mul == 7)     
      mul = 2   
    else          
      mul++ 
  } 
  res = suma % 11 
  if (res==1)   
    dvr = 'k' 
  else if (res==0)    
    dvr = '0' 
  else  
  {   
    dvi = 11-res    
    dvr = dvi + ""  
  }
  if ( dvr != dv.toLowerCase() )  
  {   
    //alert("EL rut es incorrecto")   
    //window.document.form1.rut.focus();    
    //window.document.form1.rut.select();   
    return false  
  }

  return true
}



function Rut(texto)
{ 
  var tmpstr = "";  
  for ( i=0; i < texto.length ; i++ )   
    if ( texto.charAt(i) != ' ' && texto.charAt(i) != '.' && texto.charAt(i) != '-' )
      tmpstr = tmpstr + texto.charAt(i);  
  texto = tmpstr; 
  largo = texto.length; 

  if ( largo < 2 )  
  {   
   // alert("Debe ingresar el rut completo")    
    //window.document.form1.rut.focus();    
    //window.document.form1.rut.select();   
    return false; 
  } 

  for (i=0; i < largo ; i++ ) 
  {     
    if ( texto.charAt(i) !="0" && texto.charAt(i) != "1" && texto.charAt(i) !="2" && texto.charAt(i) != "3" && texto.charAt(i) != "4" && texto.charAt(i) !="5" && texto.charAt(i) != "6" && texto.charAt(i) != "7" && texto.charAt(i) !="8" && texto.charAt(i) != "9" && texto.charAt(i) !="k" && texto.charAt(i) != "K" )
    {     
      //alert("El valor ingresado no corresponde a un R.U.T valido");     
      //window.document.form1.rut.focus();      
      //window.document.form1.rut.select();     
      return false;   
    } 
  } 

  var invertido = ""; 
  for ( i=(largo-1),j=0; i>=0; i--,j++ )    
    invertido = invertido + texto.charAt(i);  
  var dtexto = "";  
  dtexto = dtexto + invertido.charAt(0);  
  dtexto = dtexto + '-';  
  cnt = 0;  

  for ( i=1,j=2; i<largo; i++,j++ ) 
  {   
    //alert("i=[" + i + "] j=[" + j +"]" );   
    if ( cnt == 3 )   
    {     
      dtexto = dtexto + '.';      
      j++;      
      dtexto = dtexto + invertido.charAt(i);      
      cnt = 1;    
    }   
    else    
    {       
      dtexto = dtexto + invertido.charAt(i);      
      cnt++;    
    } 
  } 

  invertido = ""; 
  for ( i=(dtexto.length-1),j=0; i>=0; i--,j++ )    
    invertido = invertido + dtexto.charAt(i); 

  window.document.form1.rut.value = invertido.toUpperCase()   

  if ( revisarDigito2(texto) )    
    return true;  

  return false;
}


function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
/*FIN Validar Rut y Formatear*/