// JavaScript Document

//FUNCION AJAX CARGA EL CONTENIDO DE UNA PAGINA X EN UN DIV Y
function change(pg,div)
{
  pagina=pg;
  content="#"+div;
  
  var x=$(content);
  //x.ajaxStart(function(){inicioEnvio(content)});
  x.html('<center class="loading"><br /><br /><img src="img/giphy.gif" style="width:40px;height:40px;"><br /></center>');
  x.load(pagina); 
  //return false;
}