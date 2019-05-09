<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;
use GuzzleHttp\Client;
use Redirect;
use Alert;

class Guz extends Model
{
	protected $public_key = 'B8C1FB623AA3CE4FCBAABC2CBCD18';
	protected $secret_key = 'B4B18358EEF2E9AEDE1FACE2E8A8A';
	protected $header = array(
		'Content-Type' => 'application/json',
		'AccessToken' => 'key',
		'Authorization' => 'Bearer e8NDkyjDgqvapG5XnIH6nVgq3QJTkwcTg6MpRlYVRpn3oOojoSmZaV54bYug6XfUfTQzmX37XzLoMEHLSNYqV53NuT2PcHFblFFi'
	);
	protected $url_base = "http://149.129.224.117:8080/api/";
	public $result;

	public function __construct($method, $url, $param=null)
	{
		$url = $this->url_base . $url;;
		$client = new Client();
		switch ($method)
		{
			case 'GET':
				$params = array(
					'headers' => $this->header
				);
				
				$client->request('GET', $url, $params);
			break;

			case 'POST':
				$params = [
					'json' => $param,
					'headers' => $this->header
				];
                // dd($params);

				// $params['form_params']['public_key'] = $this->public_key;
				// $params['form_params']['secret_key'] = $this->secret_key;

				//$string = '?token=' . $token;
				$res = $client->request('POST', $url, $params);
                // $res = $client->request('POST', $url.$string);
                // dd($url.$string);
			break;
		}

		$this->result = json_decode($res->getBody(), true);
		// dd($this->result);
		// return $this->result->error;
		if(array_has($this->result, 'response.message') && $this->test['response']['message'] == 'Token Invalid')
		{
			Session::flush();
			Alert::error('Your session has expired');
			return Redirect::to('');
		}elseif(array_has($this->result, 'error') && $this->test['response']['error'] == 'user_not_found')
		{
			Session::flush();
			Alert::error('Your session has expired');
			return Redirect::to('');
		}elseif(array_has($this->result, 'error') && $this->test['response']['error'] == 'token_expired')
		{
			Session::flush();
			Alert::error('Your session has expired');
			return Redirect::to('');
		}elseif(array_has($this->result, 'error') && $this->result->error == 'token_expired'){
			Session::flush();
			Alert::error('Your session has expired');
			return Redirect::to('');
		}

		return $this;
	}
}
