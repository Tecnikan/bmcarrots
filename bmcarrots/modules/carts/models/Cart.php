<?php


class Cart extends AppModel{ 
    public $product_id;
    public $name_p;
    public $price_p;
    public $picture_p;

    public $quanty; 
    public $cost; 
    public $total; 
    public $accum;
    public $detail_sale_id;

    function __construct() {
        $this->product_id = 0;
        $this->name_p = '';
        $this->price_p = 0;
        $this->picture_p = '';
        $this->quanty=0; 
        $this->cost=0; 
        $this->total=0; 
        $this->accum=0;
        $this->detail_sale_id=0;
    }
 
      
    public function get(){

        $sql = "SELECT product_id, name_p,  price_p, picture_p FROM product 
        WHERE product_id =?";
        $data = array("i", "{$this->product_id}");
        $fields = array(
                'PRODUCT_ID' => '',
                'NAME_P' => '',
                'PRICE_P' => '', 
                'PICTURE_P'=>'');

        DBModel::execute($sql, $data, $fields);
        return $fields; 
   }


  

}
?>