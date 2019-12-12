<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\API;

class ApiController extends Controller
{
    public function store( Request $request ) {

        $data = [
            'name' => 'sinisa',
            'type' => 'variable',
            'description' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
            'short_description' => 'Pellentesque habitant morbi tristique senect
            us et netus et malesuada fames ac turpis egestas.',
            'categories' => [
                [
                    'id' => 9
                ],
                [
                    'id' => 14
                ]
            ],
            'images' => [
                [
                    'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_4_front.jpg'
                ],
                [
                    'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_4_back.jpg'
                ],
                [
                    'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_3_front.jpg'
                ],
                [
                    'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_6_back.jpg'
                ]
            ],
            'attributes' => [
                [
                    'id' => 6,
                    'position' => 0,
                    'visible' => false,
                    'variation' => true,
                    'options' => [
                        'Black',
                        'Green'
                    ]
                ],
                [
                    'name' => 'Size',
                    'position' => 0,
                    'visible' => true,
                    'variation' => true,
                    'options' => [
                        'S',
                        'M'
                    ]
                ]
            ],
            'default_attributes' => [
                [
                    'id' => 6,
                    'option' => 'Black'
                ],
                [
                    'name' => 'Size',
                    'option' => 'S'
                ]
            ]
        ];

      print_r( API::call( 'POST', 'products', $data ) );
    }
}
