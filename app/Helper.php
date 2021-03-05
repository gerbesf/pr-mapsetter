<?php

namespace App;

class Helper {

    /**
     * Replace Image Key Name
     * @param $slug
     * @return string
     */
    public static function getImageKeyName( $slug ){
        if($slug=='routee106'){
            return 'routee-106';
        }elseif($slug=='musaqalabeta'){
            return 'musaqala-beta';
        }elseif($slug=='adakbeta'){
            return 'adak-beta';
        }elseif($slug=='operationthunderbeta'){
            return 'operationthunder-beta';
        }elseif($slug=='masirahbeta'){
            return 'masirah-beta';
        }elseif($slug=='hibernaseasonal'){
            return 'hiberna-seasonal';
        }elseif($slug=='iceboundseasonal'){
            return 'icebound-seasonal';
        }else{
            return $slug;
        }
    }

}
