<?php
namespace App\Controller\Api\V1;

use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Exception\ClientException;

class ApiController
{

    public function getCurrentRates(int $amount,string $currency = 'sek'): Response
    {
        $client = new \GuzzleHttp\Client();
        try{
            $req = $client->request('GET','api.nbp.pl/api/exchangerates/rates/a/'. $currency .'/',[
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type' => 'json'
                ]
            ]);
            $json = json_decode($req->getBody());
        } catch (ClientException $e) {

            return new Response('error');
        }
        $plnValue =  round($json->rates[0]->mid * $amount,2);

        return new Response($plnValue);
    }
}
