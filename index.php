<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <link rel="shortcut icon" href="img/favicon.ico">
    <title>KMetrics</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/ie-emulation-modes-warning.js"></script>
    <script src="js/funciones.js" type="text/javascript"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
     	 
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src=js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
</head>	
  
<body>
    <div class="container">
    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Buscar..</h4>
          </div>
          <div class="modal-body">
          <form>
            <div class="row">
                <div class="col-xs-12  col-sm-12">
                        <label>Id:</label>    
                        <input class="form-control input-sm" type="text" id="searchId" name="searchId" placeholder="Id">
                        </div>
                        <div class="col-xs-12  col-sm-12">
                        <label>Fecha Inicio:</label>    
                        <input class="form-control input-sm" type="text" id="initialDate" name="initialDate" placeholder="AAAA-MM-DD">
                        </div>
                        <div class="col-xs-12  col-sm-12">
                        <label>Fecha Fin:</label>     
                        <input class="form-control input-sm" type="text" id="finalDate" name="finalDate" placeholder="AAAA-MM-DD">
                        </div>
                         <div class="col-xs-12  col-sm-12">
                        <br>    
                         <input class="btn btn-default" type="button" name="Buscar" onClick="serch();" value="Buscar" data-dismiss="modal" align="center"/> 
                        </div>
            </div>  
          </form>
          </div> 
        </div>
      </div>
    </div>

    <div class="page-header">
    	<h1>Módulo de seguimiento de <small>Tweets</small></h1>
    </div>
            
    <div align="center">        
        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Buscar</button>
        <?php 
        $hoy = date("Y-m-d");
        ?>
        <input type="hidden" id="hoy" name="hoy" value="<?=$hoy?>"/>
    </div>
    <br>
    <div id="list_tweets"></div>
    </div>
         <script>
         
        $(document).ready(function(){	 
        $('#myModal').modal('show')
        }
        );
        function serch(){		  
            var  searchId = $('#searchId').val();
            var  initialDate = $('#initialDate').val();
            var  finalDate = $('#finalDate').val();
            var  hoy = $('#hoy').val();
            
            if((searchId == '')&&(initialDate == '')){
                alert('Por favor llena ID o Fecha Inicio y Fecha Fin para parametros de búsqueda!');
                }
                
            else {
                
                if(hoy < initialDate ){
                    
                    alert('Fecha de inicio no es valida!');
                    
                    }
                    else {
                        change('tweets.php?initialDate='+initialDate+'&finalDate='+finalDate+'&searchId='+searchId, 'list_tweets');
                    }
            }
        }
        </script>
	</body>
</html>