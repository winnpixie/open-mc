<?php namespace OpenMC\Utilities;

function httpGet(string $url)
{
    $req = curl_init($url);

    curl_setopt_array($req, array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CONNECTTIMEOUT => 15,
        CURLOPT_TIMEOUT => 15,
        CURLOPT_VERBOSE => true,
        CURLOPT_HEADER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTPHEADER => array(
            'User-Agent' => 'PHP cURL (winnpixie/open-mc)'
        ),
    ));

    $res = curl_exec($req);
    if (curl_errno($req)) {
        $req_err = curl_error($req);
        trigger_error($req_err);
    }

    $val = new HttpResponse($res, (int) curl_getinfo($req, CURLINFO_HTTP_CODE));

    curl_close($req);
    return $val;
}

class HttpResponse {
    public $text;
    public $code;
    
    public function __construct(string $text, int $code)
    {
        $this->text = $text;
        $this->code = $code;
    }
}
