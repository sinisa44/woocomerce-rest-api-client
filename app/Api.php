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

    public static function call( $method,  $endpoint, $data = null ) {

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
            'price'             => $data->price,
            'regular_price'     => $data->price,
            'manage_stock'      => true,
            'stock_status'      => 'instock',
            'stock_quantity'    => 1,

            'categories' => [
                [
                    'id'   => $data->category_1
                ]
            ],
            'images' => [
                [
                    'position' => 1,
                    'alt' => 'image',
                    'src'  => $data->image_1
                ]
            ],
            'meta_data' => [
                [
                    'key'   => 'fktsc_ticket_game_id', //custom field
                    'value' => '2'
                ]
            ],

            ];
    }

    public static function generate_customer_data( $data ) {

        return [
            'email'      => $data->email,
            'first_name' => $data->first_name,
            'last_name'  => $data->last_name,
            'role'       => 'customer',

            'billing'    => [
                'first_name' => $data->b_first_name,
                'last_name'  => $data->b_last_name,
                'address_1'  => $data->b_address,
                'city'       => $data->b_city,
                'state'      => $data->b_state,
                'postcode'   => $data->b_postcode,
                'country'    => $data->b_country,
                'email'      => $data->b_email,
                'phone'      => $data->b_phone
            ],

            'shipping'  => [
                'first_name' => $data->s_first_name,
                'lastname'   => $data->s_last_name,
                'address_1'  => $data->s_address,
                'city'       => $data->s_city,
                'postcode'   => $data->s_postcode,
                'country'    => $data->s_country,
                'state'      => $data->s_state
            ]
        ];
    }

 



}
