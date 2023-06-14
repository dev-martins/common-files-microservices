<?php

namespace DevMartins\CommonFilesMicroservices\Services\Traits;

use Illuminate\Support\Facades\Http;

trait ConsumeExternalService
{
    /**
     * Recomenda-se utilizar para métodos GET, POST, PUT, DELETE que não sejam submetidos arquivos
     */
    public function headers(array $headers = [])
    {
        $headers = array_merge($headers, [
            'Accept' => 'application/json',
            'Authorization' => isset($this->token) ? $this->token : ''
        ]);
        
        return $headers;
    }

    public function request(string $method, string $endPoint, array $formParams = [], array $headers = [])
    {
        $response = Http::withHeaders($this->headers($headers))
            ->$method($this->url . $endPoint,  $formParams);

        return json_decode($response);
    }

    /**
     * Atende requisções POST e PUT com envio de arquivos
     */
    public function requestWithFiles(object $request, string $fileName, string $endPoint, string $method = 'POST', array $headers = [])
    {

        $response =  Http::attach($fileName, fopen($request->file($fileName), 'r'))
            ->acceptJson()
            ->withHeaders($this->headers($headers))
            ->withOptions(
                [
                    'connect_timeout'   => config('curl.time.connect_timeout'),
                    'read_timeout'      => config('curl.time.read_timeout'),
                    'timeout'           => config('curl.time.timeout'),
                ]
            )
            ->$method($this->url . $endPoint);

        return json_decode($response);
    }
}
