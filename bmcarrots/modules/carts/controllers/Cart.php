<?php
	import ('modules.carts.models.Cart');
	import('modules.carts.views.Cart');

	
	class CartController extends AppController{ 


		public function add($product_id){
	
			if(isset($_SESSION['carrito'][$product_id]))
				{
					$_SESSION['carrito'][$product_id]++;
											
				}

			else{
				 $_SESSION['carrito'][$product_id]=1;
				 }
			
				$this->creatCart(); 
	
		}

		public function creatCart(){
		if(isset($_SESSION['carrito'])){
			$datos=array(); 
				foreach($_SESSION['carrito'] as $product_id =>$x){
				
						$this->model->product_id= $product_id;
						$itemcart=$this->model->get();
						$this->model->quanty=$x;
						$this->model->cost=$x*$itemcart['PRICE_P']; 
						$this->model->accum=$this->model->accum+$x;
						$this->model->total=$this->model->total+$this->model->cost;
						$Dict=array('{PRODUCT_ID}'=>$this->model->product_id, 
						'{PRICE_P}'=>$itemcart['PRICE_P'],
						'{QUANTY}'=>$this->model->quanty,
						'{COST}'=>$this->model->cost, 
						'{NAME_P}'=>$itemcart['NAME_P'],
						'{PICTURE_P}'=> $itemcart['PICTURE_P']);
						array_push($datos, $Dict);
				}
				
				$_SESSION['accum']=$this->model->accum;
				$_SESSION['total']=$this->model->total;
				$_SESSION['completcar']=$datos; 
			
				$this->view->index($datos);
			}

			else {
				HttpHelper::redirect(WEB_DIR.'/galleries/gallery/index');
			 	
				}
			
		} 	

		public function reduce($product_id){

			if(isset($_SESSION['carrito'][$product_id]) && $_SESSION['carrito'][$product_id]>1 )
			{
				$_SESSION['carrito'][$product_id]--;
				HttpHelper::redirect(WEB_DIR.'/carts/cart/creatcart');
			}
			
			else
				{
				unset($_SESSION['carrito'][$product_id]);
				HttpHelper::redirect(WEB_DIR.'/galleries/gallery/index');
				}
		}
	
		public function remove(){
			unset($_SESSION['carrito']);
			unset($datos);
			unset($Dict);
			$_SESSION['total']=0;
			$_SESSION['accum']=0;
			HttpHelper::redirect(WEB_DIR.'/galleries/gallery/index');

		}





}
?>