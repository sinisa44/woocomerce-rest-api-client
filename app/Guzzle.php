<?php

namespace App;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class Guzzle {

    public static function call( $method, $url) {
        $client = new Client();

        $methods = ['POST', 'GET' ];

        if( in_array( $method, $methods ) ) {
            try {
                $response = $client->request( $method, $url );

                $result = json_decode( $response->getBody() );
            }catch( GuzzleException $e ) {
                return response()->json(
                    [
                        'error' => $e->getMessage()
                    ]
                );
            }

            return $result;
        }

    }
}
