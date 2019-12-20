<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Api;


class ProductController extends Controller
{
    public function store( Request $request ) {

     $product = API::call( 'POST', 'products', API::generate_product_data( $request ) );

     if( $product){
       // $variation = API::call( 'POST', 'products/'.$product->id.'/variations', API::generate_variation_data());
       // $attribute = API::call( 'POST', 'products/attributes', API::generate_product_atributes ());
     }
      return response()->json(
          [
            'product'    => $product,
            //'variation'  => $variation,
            //'attributes' => $attribute
          ]
        );

    }

    public function index() {

        $products = API::call( 'GET', 'products' );

        return response()->json( $products );
    }

    public function show( $id ) {

        $product = API::call( 'GET', 'products/'.$id );

        if( ! $product ) {
            abort( 404, 'No product found' );
        }

        return response()->json( $product );
    }

    public function categories() {
        $categories = API::call( 'GET', 'products/categories' );

        return response()->json( $categories );
    }



}
