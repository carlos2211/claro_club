/* 

patron = /\d/; // Solo acepta n�meros
patron = /\w/; // Acepta n�meros y letras
patron = /\D/; // No acepta n�meros
patron =/[A-Za-z��\s]/; // igual que el ejemplo, pero acepta tambi�n las letras � y �

patron = /[ajt69]/;   //acepte a, j, t, 6 y 9:

*/

function solocar_num2(e){
	//onkeypress="return solocar_num2(event)"
	 tecla = (document.all) ? e.keyCode : e.which; // 2
    if (tecla==8) return true; // 3
	patron = /\d/;
    te = String.fromCharCode(tecla); // 5
    return patron.test(te); // 6

}
function solocar_num(x,y){
//onKeyPress="solocar_num(event.keyCode,String.fromCharCode(event.keyCode));"
  var txt="01234567890";
  if (txt.indexOf(y)!=-1)
    event.returnValue = true;
  else
    event.returnValue = false;
}
function carac_rut(x,y){
//onKeyPress="solocar_num(event.keyCode,String.fromCharCode(event.keyCode));"
  var txt="01234567890Kk";
  if (txt.indexOf(y)!=-1)
    event.returnValue = true;
  else
    event.returnValue = false;
}
function solocar_real(x,y,z,a){
//onKeyPress="solocar_real(event.keyCode,String.fromCharCode(event.keyCode));"
var txt="01234567890.";
  if (txt.indexOf(y)!=-1){
	if ((z.indexOf('.')!=-1)&&(y=='.'))
		event.returnValue = false;
	else
	if(z.lastIndexOf(".")!=-1){
	  if((z.length-z.lastIndexOf("."))!=a+1)	
	  	event.returnValue = true;
	  else
	    event.returnValue = false;
	}
	else
	    event.returnValue = true;
  }
  else
      event.returnValue = false;
}

function esnumero(valor){
      //intento convertir a entero.
     //si era un entero no le afecta, si no lo era lo intenta convertir
     valor = parseInt(valor)

      //Compruebo si es un valor num�rico
      if (isNaN(valor)) {
            //entonces (no es numero) devuelvo el valor cadena vacia
			alert("DEBE INGRESAR UN VALOR NUMERICO");
            return false
      }else{
            //En caso contrario (Si era un n�mero) devuelvo el valor
            return true
      }
} 