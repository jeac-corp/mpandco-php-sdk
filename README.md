# mpandco-php-sdk
PHP SDK para mPandco RESTful APIs

### Instalar libreria en su proyecto

    composer require jeac-corp/mpandco-php-sdk

## Ejemplos de uso
Ejecute el comando `php sample/index.php` para levantar el ambiente de pruebas en http://localhost:4000

## Configure su ApiContext que lo ayudara a realizar las peticiones

    /** @var JeacCorp\Mpandco\Rest\ApiContext $apiContext */
    $apiContext = new JeacCorp\Mpandco\Rest\ApiContext([
        "clientId" => $clientId,//Su cliente
        "clientSecret" => $clientSecret,//Su secreto
        "mode" => "sandbox",
    ]);

El parametro **"mode"** tiene **"sandbox"** su entorno de desarrollo y **"live"** para su ambiente en productivo.

[Documentacion oficial de la API RESTful][7d8ab947]

  [7d8ab947]: https://jeac-corp.github.io/mpandco-api/ "mPandco API Documentación"
