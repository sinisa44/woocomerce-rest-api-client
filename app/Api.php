<?php

namespace App;


use Automattic\WooCommerce\HttpClient\HttpClientException;
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
                    try {
                        $res = $woocomerce->{$method}( $endpoint, $data );
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

    public static function generate_product_data( $data ) {

        return [
            'name'              => $data->name,
            'type'              => $data->type,
            'regural_price'     => $data->regular_price,
            'description'       => $data->description,
            'short_description' => $data->short_description,
            'categories' => [
                [
                    'id'   => $data->category_1
                ]
            ],
            'images' => [
                [
                    'position' => 0,
                    'alt' => 'images',
                    'src'  => $data->image_1
                ]
            ],
            'meta_data' => [
                [
                    'key'   => $data->m_key,
                    'value' => $data->m_value
                ]
            ]
        ];
    }

    public static function generate_customer_data( $data ) {

        return [
            'email'      => $data->email,
            'first_name' => $data->first_name,
            'last_name'  => $data->last_name,
            'username'   => $data->username,
            'billing'    => [
                'first_name' => $data->b_first_name,
                'last_name'  => $data->b_last_name,
                'company'    => $data->b_company,
                'address_1'  => $data->b_address_1,
                'address_2'  => $data->b_address_2,
                'city'       => $data->b_city,
                'state'      => $data->b_state,
                'postcode'   => $data->b_postcode,
                'country'    => $data->b_country,
                'email'      => $data->b_email,
                'phone'      => $data->b_phone
            ]
        ];
    }
}
