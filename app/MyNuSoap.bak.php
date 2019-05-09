<?php

namespace App;

class MyNuSoap 
{

    private static $_instance = 'null';
    public $proxyhost;
    public $proxyport;
    public $usernae;
    public $password;
    public $url;
    public $method;
    public $property;
    public $client;
    public $client_error;
    public $reqeust;
    public $result;
    public $response;
    public $debut_str;

    public function init() {
        require_once('Libraries/nusoap/lib/nusoap.php');
        $proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
        $proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
        $proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
        $proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';
        $client = new nusoap_client($this->url,'wsdl',
            $this->proxyhost,
            $this->proxyport,
            $this->proxyusername,
            $this->proxypassword
        );
        $this->client_error = $client->getError();
        if ($this->client_error) {
            return '<h2>Constructor error</h2><pre>' . $this->client_error  . '</pre>';
        }
// Doc/lit parameters get wrapped
        $param = array('Symbol' => 'it_group');
        $this->result = $client->call($this->result, array('parameters' => $param), '', '', false, true);
// Check for a fault
        if (!$client->fault) {
            $err = $client->getError();
            if ($err) {
		// Display the error
                return '<h2>Error</h2><pre>' . $err . '</pre>';
            }
        }
    } 

    public function result() {
        $this->init();
        return $this->result;
    }

    public function request() {
        return $this->request;
    }
   
    public function response() {
        return $this->repnse;
    }

    public function debug_str() {
        return $this->debug_str;
    }
}

?>