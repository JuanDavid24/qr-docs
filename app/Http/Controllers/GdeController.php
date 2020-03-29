<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\ConnectException;

use Config;

use Illuminate\Http\Response;


class GdeController extends Controller
{
	protected $accessToken = false;
	protected $refreshToken = false;
	protected $securityUrl;
	protected $pdfApiUrl;


	public function __construct() {
		
		$this->securityUrl = Config::get('gde.securityUrl');
		$this->pdfApiUrl = Config::get('gde.pdfApiUrl'); 
	}
    public function auth() {

    	\Log::info(__FUNCTION__);

    	$headers = [
    		'Content-Type' => 'application/json',
    		'Accept' => 'application/json'];

    	$query = [
    		'application' => Config::get('gde.application'),
    		'access_provider' => Config::get('gde.access_provider'),
    		'username' => Config::get('gde.username'),
    		'password' => Config::get('gde.password'),

    	];
        $client = new Client;

		try {

    		\Log::info('POST to ' . $this->securityUrl);

            $r = $client->request('POST',$this->securityUrl, ['headers'=>$headers, 'query' => $query]);
            $response = \GuzzleHttp\json_decode($r->getBody(), true);


            $this->accessToken = $response['accessToken'];
            $this->refreshToken = $response['refreshToken'];

		} catch (Exception | ServerException | ClientException $e) {
			$message = $e->getResponse()->getBody()->getContents() ?? '';
			\Log::info($message);
			dump($message);
			exit();
		}      

		return $this->accessToken;
    }

    public function validateDocument($numeroDocumento_b64 = null) {
    	set_time_limit(0);
		\Log::info(__FUNCTION__);
		\Log::info('Param: ' . $numeroDocumento_b64);
    	// parse param para quitar ultimo b64, pero manteniendo el primer b64 completo
    	// @todo: el parametro tiene que llegar con un urlencode!
    	$params = explode('/',$numeroDocumento_b64);
    	if(sizeof($params)>1) {
    		array_pop($params);
    		$numeroDocumento_b64 = implode('/', $params);
    	} else {
    		$numeroDocumento_b64 = $numeroDocumento_b64; 
    	}

    	$numeroDocumento = trim(base64_decode(trim($numeroDocumento_b64)));
    	$filename = trim($numeroDocumento) . '.pdf';
    	$this->auth();

		\Log::info('Get: ' . $numeroDocumento);
    	$response = $this->getDocument($numeroDocumento);
		//\Log::info(json_encode($response));

    	if($response['status'] ==200) {
            $response['filename'] = $filename;
			\Log::info('Stream: ' . $filename);
            return view('permisos.viewer',['response'=>$response]);
            // return view('permisos.valido',['response'=>$response]);
            /*
    		return (new Response(base64_decode($response['content']),200))
    			->header('ContentType','application/pdf')
    			->header('Content-Disposition','attachment; filename="'.$filename.'"');
            */
    	} else {

			\Log::info('Doc invalido');
    		return view('permisos.invalido');
    	}

    }

    

    public function getDocument($numeroDocumento = null) {
		
		\Log::info(__FUNCTION__);
    	
    	if(is_null($numeroDocumento)) {
    		$numeroDocumento = '';
    	}
    	$url = $this->pdfApiUrl . urlencode($numeroDocumento) . '/pdf/qr?sistemaOrigen=TAD_QR&codigoVerificador=';
    	//dd($url);
    	$headers = [
    		'Content-Type' => 'application/json',
    		'Accept' => 'application/json',
    		'Accept-Encoding' => 'gzip, deflate',
    		'Authorization' => 'Bearer ' . trim($this->accessToken)
    	];

    	$query = [
    		'sistemaOrigen' => 'TAD_QR',
    		'codigoVerificador' => ''
    	];

        $client = new Client;

		\Log::info('GET to ' . $url);
		\Log::info(json_encode([$query, $headers]));
        try {
          $r = $client->request('GET',$url,['headers'=>$headers, 'query' => $query]); //,'debug' => true
          	
          	$status_code = $r->getStatusCode();
            $content = \GuzzleHttp\json_decode($r->getBody(), true);
            $message = 'OK';
			

		} catch (Exception | ServerException | ClientException $e) {

			$status_code = $e->getCode();
            $content = '';
			$message = $e->getResponse()->getBody()->getContents() ?? '';
		}
		
			\Log::info(json_encode([$status_code, $message]));
        	return [
        		'status'=>$status_code,
        		'message'=>$message,
        		'content' => $content
        	];


    }


}
