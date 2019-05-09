<?php

namespace App\Http\Controllers;
use nusoap_client;


class WsdlController extends Controller
{
  
    public function index()
    {
        $url = "http://tap-ldapdev.tap-agri.com/data-sap/uom";
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url);

        echo $response->getBody(); # '{"id": 1420053, "name": "guzzle", ...}'
  	}
 }