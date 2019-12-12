<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\API;


class ApiController extends Controller
{
    public function store( Request $request ) {

      $products = API::call( 'POST', 'products', $request );

      return response()->json( $products );
    }

    public function index() {

        $products = API::call( 'GET', 'products');

        return response()->json( $products );
    }

    public function show( $id ) {

        $product = API::call( 'GET', 'products/'.$id );

        if( ! $product ) {
            abort( 404, 'No product found' );
        }

        return response()->json( $product );
    }

    public static function generate( $data) {
        echo $data;
    }



}
