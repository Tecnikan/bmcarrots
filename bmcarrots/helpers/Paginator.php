<?php
abstract class Paginator {
    
    public static function getPaginator($elemens, $current, $url, $show=30){
        $bisec=5;
        $pages = array();
        $center = ceil($bisec/2) - 1 ;
        $num_pages = $elemens <= $show ? 1 : ceil($elemens/$show);
        if($num_pages > 1){
            if($current == 1 || $current < $bisec){
                for($i=1;$i<=($current+$center);$i++){
                    if($i<$num_pages)
                        array_push($pages,array('{LINK}' => $i,'{TEXT}' => $i,'{PAGE}' => true));                    
                }
                if(($current+$center) < $num_pages)
                    array_push($pages,array('{LINK}' => '#', '{TEXT}' => '...', '{PAGE}' => false));
                array_push($pages,array('{LINK}' => $num_pages, '{TEXT}' => $num_pages, '{PAGE}' => true));
            }elseif($current == $num_pages || $current >= ($num_pages-$bisec)){
                array_push($pages,array('{LINK}' => 1, '{TEXT}' => 1, '{PAGE}' => true));
                array_push($pages,array('{LINK}' => '#', '{TEXT}' => '...', '{PAGE}' => false));
                for($i=($current-$center);$i<=$num_pages;$i++){
                    array_push($pages,array('{LINK}' => $i,'{TEXT}' => $i,'{PAGE}' => true));
                }
            }else{
                array_push($pages,array('{LINK}' => 1, '{TEXT}' => 1, '{PAGE}' => true));
                array_push($pages,array('{LINK}' => '#', '{TEXT}' => '...', '{PAGE}' => false));
                for($i=$current-$center;$i<=($current+$center);$i++){
                     array_push($pages,array('{LINK}' => $i,'{TEXT}' => $i,'{PAGE}' => true));
                }
                array_push($pages,array('{LINK}' => '#', '{TEXT}' => '...', '{PAGE}' => false));
                array_push($pages,array('{LINK}' => $num_pages, '{TEXT}' => $num_pages, '{PAGE}' => true));
            }
        }
        else{
            array_push($pages,array('{LINK}' => 1, '{TEXT}' => 1, '{PAGE}' => true));
        }
        return self::getHtml($pages, $current, $url);
    }
    
    private static function getHtml($pages, $current, $url){
        $html = '';
        foreach ($pages as $page){
            if($page['{PAGE}'] == true){
                $html .= '<li class="'.($page['{TEXT}'] == $current? 'active' :'').'"><a href="'.$url.'/'.$page['{LINK}'].'">'.$page['{TEXT}'].'</a></li>';
            }else{
                $html .= '<li><a href="'.$page['{LINK}'].'">'.$page['{TEXT}'].'</a></li>';
            }                    
        }
        return $html;
    }
        
}
?>