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
            'price'             => $data->price,
            'regular_price'     => $data->price,
            'sku'               => $data->sku, //barcode
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
                    'key'   => 'ticket_sales_end', //custom field
                    'value' => '2020-01-02 01:02'
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

    public static function generate_order_data( $data=[] ) {

        return [
            // 'billing' => [
            //     'first_name' => $data['customer']->first_name,
            //     'last_name'  => $data['customer']->last_name,
            //     'address_1'  => $data['customer']->billing->address_1,
            //     'address_2'  => $data['customer']->billing->address_2,
            //     'city'       => $data['customer']->billing->city,
            //     'state'      => $data['customer']->billing->state,
            //     'postcode'   => $data['customer']->billing->postcode,
            //     'country'    => $data['customer']->billing->country,
            //     'email'      => $data['customer']->billing->email,
            //     'phone'      => $data['customer']->billing->phone
            // ],

            'customer_id' => $data['customer']->id,
            'line_items' => [
                [
                    'sku' => $data['product']->sku,
                    'quantity' => 1
                ],
            ],
        ];
    }
}
