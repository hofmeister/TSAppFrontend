<?php

class BackendService extends RestService {

    function __construct() {
        parent::__construct('http://localhost:8888/tradeshift-backend/rest');
    }


    public function auth($username , $password) {
        return $this->httpBodyRequest('POST','/users',array(
            'CredentialType' => 'UsernamePasswordCredential',
            'Username' =>  $username,
            'Password' => $password
        ));
    }

    public function getUserByCredential($username) {
        if (!$username) {
            return false;
        }

        $username = urlencode($username);

        return $this->httpGet("/users/credential/$username");
    }
}