<?php
	import ('modules.galleries.models.Gallery');
	import('modules.galleries.views.Gallery');
	
	class GalleryController extends AppController{ 


		public function index(){

			$products=$this->model->index();
			$this->view->gallery($products); 



		}

		
}
?>