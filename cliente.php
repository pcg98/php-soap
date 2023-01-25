<?php

try {
    $client = new SoapClient(null, array(
            'uri' => 'http://localhost/soap-automoviles/',
            'location' => 'http://localhost/soap-automoviles/service-automoviles.php',
            'trace' => 1
        )
    );
     // set the header 
    // https://www.php.net/manual/en/reserved.classes.php
    $auth_params = new stdClass();
    $auth_params->username = 'ies';
    $auth_params->password = 'daw';

    // https://www.php.net/manual/en/class.soapheader.php
    // https://www.php.net/manual/en/class.soapvar.php

    $header_params = new SoapVar($auth_params, SOAP_ENC_OBJECT);
    $header = new SoapHeader('http://localhost/soap-automoviles/', 'authenticate', $header_params, false);
    $client->__setSoapHeaders(array($header));

} catch (Exception $e) {
    echo($client->__getLastResponse());
    echo PHP_EOL;
    echo($client->__getLastRequest());
}

?>