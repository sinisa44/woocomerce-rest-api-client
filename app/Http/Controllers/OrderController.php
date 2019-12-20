<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Guzzle;
use App\API;

class OrderController extends Controller {

    public function order( Request $request  ) {

    $game_id     = $request->game_id;
    $barcode     = $request->barcode;
    $customer_id = $request->customer_id;
    $user_id     = $request->user_id;
    $woo_ck      = config( 'woocomerce.woo_ck' );
    $woo_cs      = config( 'woocomerce.woo_cs' );

    $url = 'fktsc.com/wp-json/fktsctickets/v1/game_id='.$game_id.'/barcodes='.$barcode.'/customer='.$customer_id.'/user_id='.$user_id.'/ck='.$woo_ck.'/cs='.$woo_cs;

    $order = Guzzle::call( 'GET', $url );

    if( $order ) {
        $result = API::call( 'GET', 'orders/'.$order->shop_order_id );
    }
    return response()->json( $result );
    }

    public function index() {
        $orders = API::call( 'GET', 'orders' );

        if( ! $orders ) {
            abort( 404, 'no orders to show' );
        }

        return response()->json( $orders );
    }

    public function show ( $id ) {
        $order = API::call( 'GET', 'orders/'.$id );

        if( ! $order )
            abort( 404, 'no order found' );

        return response()->json( $order );
    }
}
