<?php

class GalleryView extends AppView{


	public function gallery($products){
	//file gets content trata a la  pagina como una cadena
		$pagina=file_get_contents(WEB_ROOT."Gallery.html"); 
		//saca una posicion  strpos
		$pos1 = strpos($pagina,'<!--GALLERY-->');
		//de atras para a delante
        $pos2 = strrpos($pagina,'<!--GALLERY-->');
       //resta para sacar la posicion 
        $length = $pos2-$pos1;
        //sustrae la cadena 
        $match = substr($pagina,$pos1,$length);
		$render='';

		foreach($products as $key=>$producto){
			$dict = array();
			foreach($producto as $indice=>$valor){
				$dict["{".$indice."}"] = $valor; 
			}

			$render.=str_replace(array_keys($dict),array_values($dict), $match);
		}
		$paginafinal=str_replace($match, $render, $pagina); 
		//pr($dict);

		if(isset($_SESSION['accum'])&& isset($_SESSION['total'])){
			$paginafinal=str_replace('{TOTAL}', "$ ".$_SESSION['total'].".00", $paginafinal);

		}
		else
		{$paginafinal=str_replace('{TOTAL}', "Add products", $paginafinal);}
		
		$paginafinal = str_replace('{WEB_DIR}', WEB_DIR, $paginafinal);
		print($paginafinal); 
		
	}

}
?>