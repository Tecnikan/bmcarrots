<?php


class Gallery extends AppModel{ 

    
    public function index(){

        $sql = "SELECT product_id, name_p, desc_p, price_p, picture_p FROM product WHERE product_id >?";
        $data = array("i", 0);
        $fields = array(
                'PRODUCT_ID' => '',
                'NAME_P' => '',
                'DESC_P' => '',
                'PRICE_P' => '', 
                'PICTURE_P'=>'');

        DBModel::execute($sql, $data, $fields);
        return DBModel::$results; 
   }


    public function get(){
            $sql = "SELECT product_id, name_p, desc_p, price_p, picture_p FROM products WHERE product_id=?";
            $data = array("i", "{$this->product_id}");
            $fields = array(
                'PRODUCT_ID' => '',
                'NAME_P' => '',
                'DESC_P' => '',
                'PRICE_P' => '', 
                'PICTURE_P'=>'');

            DBModel::execute($sql, $data, $fields);
            $this->product_id = $fields['PRODUCT_ID'];
            $this->name_p = $fields['NAME_P'];
            $this->desc_P = $fields['DESC_P'];        
            $this->price_p = $fields['PRICE_P'];        
       
    }

}
?>