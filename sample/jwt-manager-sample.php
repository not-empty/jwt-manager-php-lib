<?php

require_once __DIR__ . '/../vendor/autoload.php';

use JwtManager\JwtManager;

$secret = '77682b9441bb7daa7a1fa6eb7522b689';
$context = 'test';
$expire = 30; //expire token time
$renew = 10; //time left to expire token

$jwtManager = new JwtManager(
    $secret,
    $context,
    $expire,
    $renew
);

//Generate token
$tokenGenerated = $jwtManager->generate('test');
print('token: ' . $tokenGenerated);
echo PHP_EOL;

//decode the token and return the data in array
$result = $jwtManager->decodePayload($tokenGenerated);
echo 'Decoded Token payload: ';
echo PHP_EOL;

print_r($result);
echo PHP_EOL;

//Verify if token is valid
$result = $jwtManager->isValid($tokenGenerated);
echo 'Is valid: '.$result;
echo PHP_EOL;

//Check if the token is still valid
$result = $jwtManager->isOnTime($tokenGenerated);
echo 'Is on time: '.$result;
echo PHP_EOL;

//Return the expire time that was set
$result = $jwtManager->getexpire();
echo 'Token expiration time: '.$result;
echo PHP_EOL;

//Check if is needed generate new token
$result = $jwtManager->tokenNeedToRefresh($tokenGenerated);
echo 'Need to refresh token: '.$result;
echo PHP_EOL;
