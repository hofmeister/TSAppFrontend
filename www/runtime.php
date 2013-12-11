<?php
require_once 'bootstrap.php';

$headers = apache_request_headers();

$httpMethod = strtoupper($headers['X-Tradeshift-Remote-HTTP-Method']);
if (!$httpMethod) {
    $httpMethod = 'GET';
}

header('Content-type: application/json');


$input = file_get_contents('php://input');
$body = null;
if ($input) {
    $body = json_decode($input);
}
echo json_encode(TS::instance()->proxy($httpMethod,$_GET['url'],$body));