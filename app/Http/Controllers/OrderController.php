<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\API;

class OrderController extends Controller {

    public function order( Request $request  ) {

        // return response()->json( $request->customer_id );
        $customer = API::call( 'GET', 'customers/'.$request->customer_id );
        $product  = API::call( 'GET', 'products/'.$request->product_id );

        $data = [
            'customer' => $customer,
            'product'  => $product
        ];

      $order = API::call( 'POST', 'orders', API::generate_order_data( ( $data ) ) );

      return response()->json( $order );
    }

    public function index() {
        $orders = API::call( 'GET', 'orders' );

        if( ! $orders ) {
            abort( 404, 'no orders to show' );
        }

        return response()->json( $orders );
    }
}
