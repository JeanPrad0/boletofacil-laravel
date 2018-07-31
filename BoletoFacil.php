<?php

namespace Modules\Boletofacil;

use GuzzleHttp\Client;

class BoletoFacil{

    const SESSION = 0;
    const SESSION_SANDBOX = 1;

    private $requests = [
        0 => [
            'url' => 'https://www.boletobancario.com/boletofacil/integration/api/v1/issue-charge',
            'method' => 'GET',
        ],
        1 => [
            'url' => 'https://sandbox.boletobancario.com/boletofacil/integration/api/v1/issue-charge',
            'method' => 'GET',
        ],
    ];

    public function request(int $url, array $data = [])
    {
        $request = $this->requests[$url];

        $url = $request['url'];

        $url = $url . '?' . http_build_query($data);

        $client = new Client;
        $response = $client->request($request['method'], $url);

        return $response->getBody();
    }

    public static function boleto(array $data){

        $data['token'] = config('boletofacil.token');
        $data['responseType'] = 'XML';
    
        $response = (new BoletoFacil)->request(BoletoFacil::SESSION_SANDBOX, $data);
    
        $session =  new \SimpleXMLElement($response->getContents());


        if($session->success == true){
            $invoice = [];
            $invoice['due_date'] = $session->data->charges->charge->dueDate;
            $invoice['link_boleto'] = $session->data->charges->charge->link;

            return $invoice;
        }else{
            return $session->errorMessage;
        }

    }


}