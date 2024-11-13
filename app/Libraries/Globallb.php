<?php

namespace App\Libraries;

class Globallb
{
    public function __construct() {}

    static function pr($mes = 'print some data', $is_die = 0)
    {
        echo "<pre>";
        print_r($mes);
        echo "</pre>";
        if ($is_die == 1) {
            die();
        }
    }
}
