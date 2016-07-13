<?php
if($_POST) {	
	$keys_post = array_keys($_POST);
	foreach ($keys_post as $key_post)
		$$key_post = $_POST[$key_post];
}
if($_GET){	
	$keys_get = array_keys($_GET);
	foreach ($keys_get as $key_get)
		$$key_get = $_GET[$key_get];
} 
try{
	$mongo = new Mongo();
	$coleccion_busquedas = $mongo->KMetrics->busquedas;
	$coleccion_tweets = $mongo->KMetrics->tweets;
}  catch (MongoConectionException $e){
	die("No se pudo conectar a la base de datos". $e->getMessage());
	}

	if(($searchId <> '')&&($initialDate <>'')){
			$x =new MongoId($searchId);	
			$start = new MongoDate(strtotime($initialDate." 00:00:00"));
			$end = new MongoDate(strtotime($finalDate." 00:00:00"));
			$cursor = $coleccion_busquedas->find(array("_id" => $x ,"inicio" => array('$gt' => $start), "termino" => array('$lte' => $end)),array('_id'));
			$item2  = array();
			foreach($cursor as $item) {
			$item2[] = sprintf("%s", $item["_id"],  PHP_EOL); 
			}
		//	print_r($item2);
		}
		else if($searchId == ''){
		//Hace la consulta en Base a las fechas
		$start = new MongoDate(strtotime($initialDate." 00:00:00"));
		$end = new MongoDate(strtotime($finalDate." 00:00:00"));
		$cursor = $coleccion_busquedas->find(array("inicio" => array('$gt' => $start), "termino" => array('$lte' => $end)),array('_id'));
		$item2  = array();
		foreach($cursor as $item) {
		$item2[] = sprintf("%s", $item["_id"],  PHP_EOL); 
		//print_r($item2);
		}
	}
	else {
		$x =new MongoId($searchId);
		$cursor = $coleccion_busquedas->findOne(array("_id" =>$x ),array('_id'));
		$item2[] = sprintf("%s", $cursor["_id"],  PHP_EOL); 
		//$item2[] = $cursor['_id'];
		//print_r($item2);
		//print_r($item2);
		}

	
	$cursor2 = $coleccion_tweets->find(array('busquedaId' => array('$in' =>  $item2  ))); 
	$Usuarios = $coleccion_tweets->distinct("usuario.preferredUsername", array('busquedaId' => array('$in' =>  $item2  )));
	$Menciones = $coleccion_tweets->distinct("menciones", array('busquedaId' => array('$in' =>  $item2  )));
	$Hashtags = $coleccion_tweets->distinct("hashtags", array('busquedaId' => array('$in' =>  $item2  )));
	$tweets = $cursor2->count();
	
	$cursor2->sort(array('hashtags' => -1))->limit('10'); 
	
	$usuarios =  count($Usuarios);
	$menciones =  count($Menciones);
	$hashtags =  count($Hashtags);
 	
 	$porcentaje = $coleccion_tweets->find(array("busquedaId" => array('$in' =>  $item2), 'verb' => 'post')); 
	$post = $porcentaje->count();
	$shares = $coleccion_tweets->find(array("busquedaId" => array('$in' =>  $item2), 'verb' => 'share')); 
	$share = $shares->count();
	
	
	
	
//Arma el arreglo para la consulta del top10
$Topten = array(
			array(
			'$match' => array('busquedaId' => array('$in' =>  $item2))
            ),
		 	array(
			'$unwind' => '$hashtags'
            ),
			array(
				'$group' => array('_id' => '$hashtags','count' => array('$sum' => 1))),
			array(
				'$sort' => array('count' => -1)
			),
			 array(
				'$limit' => 10));

$Hashtags = $coleccion_tweets->aggregate($Topten);
// Hacer el calculo para el porcentaje de participacion
$Total_post = ($post+$share);
$indice_post = ($post * 100)/$Total_post;
$indice_share = ($share * 100)/$Total_post;

echo ' 
	<div class="row">
		<div  class="col-xs-12  col-sm-4">
    		<div class="panel panel-info">
        		<div class="panel-heading">#tweets</div>
       		<div class="panel-body">
        		<ul class="list-group">
					<li class="list-group-item"><span class="badge">'.$tweets.'</span> #Tweets Totales</li>
					<li class="list-group-item"><span class="badge">'.$usuarios.'</span> #Usuarios Unicos</li> 
					<li class="list-group-item"><span class="badge">'.$menciones.'</span> #Menciones Unicas</li>
					<li class="list-group-item"><span class="badge">'.$hashtags.'</span> #Hashtags Unicos</li> 
				</ul>
        	</div>
    	</div>
	</div>
	<div  class="col-xs-12  col-sm-4">
		<div class="panel panel-info">
        	<div class="panel-heading">Top 10 hashtags</div>
        <div class="panel-body">
        	<ul class="list-group">';		
				foreach($Hashtags['result'] as $top10) {
		echo '<li class="list-group-item"><span class="badge">'.$top10['count'].'</span> #'.$top10['_id'].'</li>';
				}
		echo'</ul>
        </div>
    	</div>
	</div>
	<div  class="col-xs-12  col-sm-4">
   		 	<div class="panel panel-info">
        		<div class="panel-heading">% Tweets</div>
        	<div class="panel-body">
  				<div class="progress">
					<div class="progress-bar progress-bar-success" style="width:'.round($indice_post).'%">'.round($indice_post).'% Post </div>
					<div class="progress-bar progress-bar-info progress-bar-striped" style="width:'.round($indice_share).'%">'.round($indice_share).'% Share </div>
				</div>
       		</div>
   		 </div>
	 </div>';	
?>
  


 