<?php

namespace App\Http\Controllers;

use App\API;

class AttributeController extends Controller {

    public function index() {
        return response()->json( API::call( 'GET', 'products/attributes') );
    }
}
