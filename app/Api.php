<?php

namespace App;

use Automattic\WooCommerce\Client;
use Automattic\WooCommerce\HttpClient\HttpClientException;

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
                    try {
                        $res = $woocomerce->{$method}( $endpoint, self::generate_data( $data ) );
                   }catch( HttpClientException $e ) {
                       return response()->json(
                           [
                             $e->getMessage()
                           ]
                       );
                   }
                }elseif( ! isset( $data ) ) {
                   try {
                        $res = $woocomerce->{$method}( $endpoint );
                   }catch( HttpClientException $e ) {
                       return response()->json(
                           [
                             $e->getMessage()
                           ]
                       );
                   }
                }
            }
            return $res;
    }

    public static function generate_data( $data ) {
   // return $data->image_1;
    $array = [
                'name'              => $data->name,
                'type'              => $data->type,
                'regural_price'     => $data->regular_price,
                'description'       => $data->description,
                'short_description' => $data->short_description,
            ];


        if( isset( $data->image_1 ) && isset( $data->image_2 ) ) {
            array_push( $array, [['src' => $data->image_1 ]] );

            $array['images'] = $array['0'];
            unset( $array[0] );

            array_push( $array['images'], ['src'=> $data->image_2] );

        }elseif( isset( $data->image_1 ) ) {
            array_push( $array, [['src' => $data->image_1]] );

            $array['images'] = $array['0'];
            unset( $array[0] );
        }

        if( isset( $data->category_1) && isset( $data->category_2 ) ) {
            array_push( $array, [['id' => $data->category_1]]) ;

            if( ! isset( $data->image_1) && ! isset( $data->image_2 ) ) {
                $array['category'] = $array['0'];
                unset( $array[0] );
            }else{
                $array['category'] = $array['1'];
                unset( $array[1] );
            }

            array_push( $array['category'], ['id' => $data->category_2] );
        }elseif( isset( $data->category_1 ) ) {
            array_push( $array, [['id' => $data->category_id]] );

            if( ! isset( $data->image_1) && ! isset( $data->image_2 ) ) {
                $array['category'] = $array['0'];
                unset( $array[0] );
            }else{
                $array['category'] = $array['1'];
                unset( $array[1] );
            }

        }
        return $array;
    }
}
