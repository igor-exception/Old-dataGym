<?php

namespace App\Utils;

class Utils {

    // method to debbug
    public static function print_log($info=null)
    {
        ob_start();
        var_dump("\n\n\n***************************\n\n\n");
        var_dump( print_r($info, 1));
        var_dump("\n\n\n==============\n\n\n");


        $contents = ob_get_contents();
        ob_end_clean();
        error_log( $contents );
    }
}