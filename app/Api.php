<?php

namespace App;

use Automattic\WooCommerce\Client;

class Api {

    private static $woocomerce;

    private static function connect() {

        self::$woocomerce = new Client(
            config( 'woocomerce.woo_host' ),
            config( 'woocomerce.woo_ck' ),
            config( 'woocomerce.woo_cs'),
            [
                'wp_api'  => true,
                'version' => config( 'woo_version' )
            ]
            );

        return self::$woocomerce;
    }

    public static function call( $method,  $endpoint, $data=null ) {

            $woocomerce = self::connect();

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
