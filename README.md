# Common Files Microservice 

Esse package foi desenvolvido com o objetivo de fornecer arquivos básicos para comunicação entre microserviços via HTPP.
O package foi desenvolvido com foco no framework PHP Laravel e utiliza o HTPP Client do próprio framework.

## O que pode ser feito com esse package? 
Ele estabelece a comunicação entre microserviços possiblitando a utilização dos verbos GET, POST, PUT e DELETE.

## Breve tutorial 

Para transferência de arquivos utilizando POST ou PUT, siga os seguintes passos:

1. Instale o [Common Files Microservice](https://packagist.org/packages/dev-martins/common-files-microservices): 
   ```bash 
   composer require dev-martins/common-files-microservices
   ``` 
2. Insira o namespace dele no arquivo onde se pretende chamar os métodos do package: 
   ```php 
   <?php

    namespace App\Services;

    use DevMartins\CommonFilesMicroservices\Services\Traits\ConsumeExternalService;
    ...
    ```
3. Crie o método responsável pela execução do método **requestWithFiles(...)**

    ```php
    public function uploadVideo($request)
    {
        $this->token = $request->header('Authorization');
        $this->permission = $request->user_data['permission_name'];
        $response = $this->requestWithFiles($request, 'video', "/micro/upload/files/videos", "POST", ['Permission' => $this->permission]);
        return $response;
    }
    ```

Para requisições sem transferência de arquivos com os verbos GET, POST, PUT e DELETE siga os mesmos passos substituindo o método **requestWithFiles(...)** por **request(string $method, string $endPoint, array $formParams = [], array $headers = [])**