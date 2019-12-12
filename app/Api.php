<?php

namespace App;

use Automattic\WooCommerce\Client;

class Api {

    public static function call( $method,  $endpoint, $data=null ) {


        $woocomerce = new Client(
            config( 'woocomerce.woo_host' ),
            config( 'woocomerce.woo_ck' ),
            config( 'woocomerce.woo_cs'),
            [
                'version' => config( 'woo_version' )
            ]
            );

            $methods = ['POST','GET'];

            if( in_array( $method, $methods ) ) {

            if( isset ( $data ) ) {
                $res = $woocomerce->{$method}( $endpoint, $data );
            }elseif( ! isset( $data ) ) {
                $res = $woocomerce->{$method}( $endpoint );
            }
        }
            return $res;
    }
}
