# Source code of the [Trainter.ru](http://trainter.ru/#/)

## How to install application

### Server side installation

First of all need to build application with **composer** (https://getcomposer.org/download/) 
and run the following:

    cd application
    composer.phar update
    composer.phar install

### Client side installation

First of all you need to download **npm** (https://nodejs.org/en/). After you can run
the following commands:

    cd site
    npm install
    npm run build
    
### Database installation    

Will be added latter...

## How to use application

For server starting need to run the following:

    cd application
    php -S localhost:8080 src/application.php
    
