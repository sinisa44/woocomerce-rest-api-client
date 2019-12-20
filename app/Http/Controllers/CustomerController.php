<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\API;

class CustomerController extends Controller {

    public function index(){
        $customers = API::call( 'GET', 'customers' );

        return response()->json( $customers );
    }

    public function show( $id ) {
        $customer = API::call( 'GET', 'customers/'.$id );

        if( ! $customer ) {
            abort( 404, 'no customer found' );
        }

        return response()->json( $customer );
    }

    public function store( Request $request ) {
       $customer = API::call( 'POST', 'customers', API::generate_customer_data( $request ) );

       return response()->json( $customer );
    }

}
