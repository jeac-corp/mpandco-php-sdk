# mpandco-php-sdk
PHP SDK para mPandco RESTful APIs

### Si desea puede correr tests para verificar la compatibilidad de la SDK con su sistema

Clonar proyecto "git clone git@github.com:jeac-corp/mpandco-php-sdk.git"


      git clone git@github.com:wittygrowth/mpandco-php-sdk.git
      Cloning into 'mpandco-php-sdk'...
      remote: Counting objects: 84, done.
      remote: Compressing objects: 100% (50/50), done.
      remote: Total 84 (delta 30), reused 68 (delta 19), pack-reused 0
      Receiving objects: 100% (84/84), 13.46 KiB | 551.00 KiB/s, done.
      Resolving deltas: 100% (30/30), done.

Ejecutar "composer update" para instalar los paquetes.

Ejecutar "./vendor/bin/simple-phpunit" para descargar phpunit, deberia ver una respuesta asi:


    ./vendor/bin/simple-phpunit
    ./composer.json has been updated
    Loading composer repositories with package information
    Updating dependencies
    Package operations: 19 installs, 0 updates, 0 removals
      - Installing sebastian/recursion-context (2.0.0): Loading from cache
      - Installing sebastian/exporter (2.0.0): Loading from cache
      - Installing sebastian/diff (1.4.3): Loading from cache
      - Installing sebastian/comparator (1.2.4): Loading from cache
      - Installing sebastian/resource-operations (1.0.0): Loading from cache
      - Installing myclabs/deep-copy (1.7.0): Loading from cache
      - Installing sebastian/version (2.0.1): Loading from cache
      - Installing sebastian/environment (2.0.0): Loading from cache
      - Installing sebastian/code-unit-reverse-lookup (1.0.1): Loading from cache
      - Installing phpunit/php-token-stream (1.4.12): Loading from cache
      - Installing phpunit/php-text-template (1.2.1): Loading from cache
      - Installing phpunit/php-file-iterator (1.4.5): Loading from cache
      - Installing phpunit/php-code-coverage (4.0.8): Loading from cache
      - Installing phpunit/php-timer (1.0.9): Loading from cache
      - Installing doctrine/instantiator (1.0.5): Loading from cache
      - Installing phpunit/phpunit-mock-objects (3.4.4): Loading from cache
      - Installing sebastian/global-state (1.1.1): Loading from cache
      - Installing sebastian/object-enumerator (2.0.1): Loading from cache
      - Installing symfony/phpunit-bridge (5.7.99): Symlinking from /private/var/www/mpandco/mpandco-php-sdk/vendor/symfony/phpunit-bridge
    Writing lock file
    Generating optimized autoload files

Luego puede ejecutar el comando "./vendor/bin/simple-phpunit" para correr los tests.

## Configurando ambiente de pruebas
