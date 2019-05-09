<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;
use GuzzleHttp\Client;
use Redirect;
use Alert;

class Services extends Model
{
	protected $public_key = 'B8C1FB623AA3CE4FCBAABC2CBCD18';
	protected $secret_key = 'B4B18358EEF2E9AEDE1FACE2E8A8A';
	protected $header = array(
		'Content-Type' => 'application/json',
		'AccessToken' => 'key',
		'Authorization' => 'Bearer e8NDkyjDgqvapG5XnIH6nVgq3QJTkwcTg6MpRlYVRpn3oOojoSmZaV54bYug6XfUfTQzmX37XzLoMEHLSNYqV53NuT2PcHFblFFi'
	);
	protected $api = "http://149.129.224.117:8080/api/";
	protected $ldap = "http://tap-ldapdev.tap-agri.com/";
	public $result;

	public function __construct($param=array())
	{
      
        if(!empty($param['host'])) {
			if($param['host'] == 'ldap') {
				$url = $this->ldap . ($param['method'] == 'login' ? $param['method']: 'data-sap/'. $param['method']);
			} else {
				$url = $this->api . $param['method'];
			}
        } else {
          
            $url = $this->api.$param['method'];
        }
     
		$client = new Client();
		switch ($param["request"])
		{
            case 'GET':
                
				$params = array(
					'headers' => $this->header
				);

                $res = $client->request('GET', $url, $params);
			break;

			case 'POST':
				$params = [
					'json' => $param['data'],
					'headers' => $this->header
				];

				$res = $client->request('POST', $url, $params);
			break;
			case 'DELETE':
				$params = [
					'headers' => $this->header
				];
				$res = $client->request('DELETE', $url, $params);
				break;
			case 'PUT':
				$params = [
					'json' => $param['data'],
					'headers' => $this->header,
					'allow_redirects' => false,
					'timeout' => 5
				];

				$res = $client->request('PUT', $url, $params);
			break;
			case 'ACTIVE':
				$params = [
					'json' => $param['data'],
					'headers' => $this->header,
				];

				$res = $client->request('DELETE', $url, $params);
			break;
        }   

        $this->result = json_decode($res->getBody()->getContents());
        return $this->result;
	}
}
