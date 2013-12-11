<?php
require_once 'Session.php';

class RestService {
    private static $companyId = "210dc7b0-1cbd-4320-a044-5061318c12d4";
    private static $userId = "37617bf8-4e04-41f2-bd27-9ad9153419ee";

    /**
     * @return string
     */
    public static function getCompanyId()
    {
        return self::$companyId;
    }

    /**
     * @return string
     */
    public static function getUserId()
    {
        return self::$userId;
    }



    private $baseUrl;

    function __construct($baseUrl) {
        $this->baseUrl = $baseUrl;
    }


    public static function setContext($userId, $companyId) {
        self::$companyId = $companyId;
        self::$userId = $userId;
    }


    private function headers() {
        $headers = '';
        if (self::$companyId)
            $companyId = self::$companyId;
            $headers .= "X-Tradeshift-TenantId: $companyId\r\n";

        if (self::$userId) {
            $userId = self::$userId;
            $headers .= "X-Tradeshift-ActorId: $userId\r\n";
        }

        $headers .= "Accept: application/json\r\n";

        return $headers;
    }

    public function url($pathPattern, $urlParms, $queryParms) {
        $url = $pathPattern;
        if ($urlParms) {
            foreach($urlParms as $key=>$value) {
                $url = str_replace('$'.$key,$value,$url);
            }
        }

        if ($queryParms) {
            $parms = array();
            foreach($queryParms as $key=>$value) {
                $parms[] = "$key=".urlencode($value);
            }
            if (count($parms) > 0) {
                $url .= '?'.implode('&', $parms);
            }
        }

        return $url;
    }

    public function httpDelete($url,$raw = false) {
        return $this->httpRequest('DELETE', $url, $raw);
    }

    public function httpGet($url,$raw = false) {
        return $this->httpRequest('GET', $url, $raw);
    }

    public function httpPost($url,$data) {
        return $this->httpBodyRequest('POST', $url, $data);
    }

    public function httpRequest($method, $url,$raw = false) {
        $opts = array(
            'http'=>array(
                'method'=> $method,
                'header'=> $this->headers()
            )
        );



        $context = stream_context_create($opts);

        $content = file_get_contents($this->baseUrl.$url,false,$context);

        if ($raw)
            return $content;
        return json_decode($content);
    }

    public function httpBodyRequest($method, $url, $data) {
        $content = json_encode($data);

        $headers = "Content-type: application/json\r\n"
                    .$this->headers();

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->baseUrl.$url);
        switch($method) {
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, false);
                break;
            case 'PUT':
                curl_setopt($ch, CURLOPT_PUT, false);
                break;
        }

        curl_setopt($ch, CURLOPT_BINARYTRANSFER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, explode("\r\n",$headers));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content);


        $response = curl_exec($ch);
        $httpCode = intval(curl_getinfo($ch, CURLINFO_HTTP_CODE));

        if ($httpCode > 399) {
            if ($httpCode >= 400 && $httpCode < 500) {
                return false;
            }
            throw new Exception($httpCode);
        }

        if (!$response) {
            return true;
        }

        return json_decode($response);
    }

    public function httpPostFile($url,$file,$data) {
        $boundary = md5(microtime());
        $content = json_encode($data);


        $body = "--$boundary\r\n"
            ."Content-disposition:form-data;\r\n"
            ."Content-type:application/json;\r\n\r\n"
            .$content."\r\n"
            ."--$boundary\r\n";

        $file = (object) $file;
        $body .= "Content-disposition:form-data; name=\"$file->field\";filename=\"$file->name\"\r\n"
            ."Content-type:$file->contentType;\r\n"
            ."Content-Transfer-Encoding: base64;\r\n\r\n"
            .base64_encode($file->content)."\r\n"
            ."--$boundary---\r\n";

        $content_length = strlen($body);

        $opts = array(
            'http'=>array(
                'method'=>"POST",
                'header'=> "Content-type: multipart/form-data, boundary=$boundary\r\n"
                ."Content-length: $content_length\r\n"
                .$this->headers(),
                'content'=> $content
            )
        );

        $context = stream_context_create($opts);

        $content = @file_get_contents($this->baseUrl.$url,false,$context);

        return json_decode($content);
    }

    public function getBaseUrl() {
        return $this->baseUrl;
    }
}