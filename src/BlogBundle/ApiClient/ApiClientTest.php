<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 21.03.2018
 * Time: 13:25
 */

namespace BlogBundle\ApiClient;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ApiClientTest
{
    private $apiClient;
    private $container;

    function __construct($apiClient, $container)
    {
        $this->apiClient = $apiClient;
        $this->container = $container;
    }
    public function APIRequest($method = 'GET', $url = '', $access_token = '', $sendData = '', $log = true)
    {
        $testApi=$this->container->get('blog.api')->APIRequest($method,$url,$access_token,$sendData);

        $browser = new Client();
        $response = array();
//        $data = array();
        if ($access_token) {
            $data['headers'] = ['Authorization'=> 'Bearer ' . $access_token];
//            $headers[] = 'cache-control: no-cache';
//            $headers[] = 'content-type: application/json';
        }
        if(isset($sendData['form_params'])){
            $data=$sendData;
        }elseif($sendData){
            $data['json']=$sendData;
        }
        try{
            switch ($method) {

                case "POST":
                    if ($data) {
                        $response = $browser->post($url,  $data);
                    }
                    break;
                case "PUT":
                    $response = $browser->put($url);
                    break;
                case "GET":

                    $response = $browser->get($url);
                    break;
            }

//            if (empty($response->getBody()->getContents())) {
//                echo "API is not available. ";
//                $this->logger->debug('API is not available for [' . $method . ']' . $url);
//
//            }
//            if ($log) {
//                $this->logger->debug('Response: ' . $response->getBody()->getContents());
//            }

            return json_decode($response->getBody()->getContents());
        }catch(RequestException $e){
            return ['error'=>$e->getCode(),'message'=>json_decode($e->getResponse()->getBody()->getContents())];
        }

    }
}