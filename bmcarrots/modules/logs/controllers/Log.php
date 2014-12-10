<?php

	import ('modules.logs.models.Log');
	import('modules.logs.views.Log');

	
	class LogController extends AppController{ 

		public function index(){
			$this->view->index();
		}
		public function datos(){
			$this->model->mail_u=$_POST['em'];
			$this->model->pass_u=$_POST['ps'];

			$dataUser=$this->model->get();
			$row = count($dataUser);
			
			
			if($row==1 && $this->model->profile_id==2)
				{
				$_SESSION['user']=$this->model->name_c;
				$_SESSION['mail']=$this->model->mail; 
				$_SESSION['customer_id']=$this->model->customer_id;
				HttpHelper::redirect(WEB_DIR.'payments/payment/index');
				
				}
				
			else {
					$this->view->notFound();
				}
			}


			public function signOut(){
				unset($_SESSION['user']);
				unset($_SESSION['mail']);
				unset($_SESSION['customer_id']);
				unset($_SESSION['carrito']);
				unset($_SESSION['total']) ; 
				unset($_SESSION['accum']); 
				HttpHelper::redirect(WEB_DIR.'galleries/gallery/index');
			}

}
?>