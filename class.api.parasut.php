<?php

/**
 * Mehmet Bozkurt ParasutApi
 *
 * @package   ParasutApi
 * @author    Mehmet Bozkurt <mehmetxbozkurt@gmail.com>
 * @license   Mehmet Bozkurt
 * @copyright 2017
 */

namespace ParasutApi ;

class Parasut
{

    const CLIENT_ID = '';
    const CLIENT_SECRET = '';
    const PARASUT_USER_NAME = '';
    const PARASUT_PASSWORD = '';
    const COMPANY_ID = '';
    const REDIRECT_URI = '';
    const AUTHORIZATION_ENDPOINT = 'https://api.parasut.com/oauth/authorize';
    const TOKEN_ENDPOINT = 'https://api.parasut.com/oauth/token';
    const TOKEN_URL = 'https://api.parasut.com/v1';

    public $access_token;
    public $refresh_token;
    public $created_at;
    public $token_type;
    public $connected;

    public function __construct()
    {
        $this->connected = $this->apiConnect();
    }

    public function __destruct()
    {

    }

    /**
     * Create a new api connection.
     *
     * @return bool
     */
    public function apiConnect()
    {

        if (!class_exists('\http\Client\Request')){
            return false;
        }
        else {
            try {
                $client = new \http\Client;
                $request = new \http\Client\Request;

                $request->setRequestUrl(self::TOKEN_ENDPOINT);
                $request->setRequestMethod('POST');
                $request->setQuery(new \http\QueryString(array(
                    'client_id' =>  self::CLIENT_ID,
                    'client_secret' => self::CLIENT_SECRET,
                    'username' => self::PARASUT_USER_NAME,
                    'password' => self::PARASUT_PASSWORD,
                    'grant_type' => 'password',
                    'redirect_uri' => self::REDIRECT_URI
                )));

                $client->enqueue($request)->send();
                $response = $client->getResponse();

                $body = $response->getBody();

                $resAut = json_decode($body, true);

                $this->access_token     = $resAut["access_token"];
                $this->refresh_token    = $resAut["refresh_token"];
                $this->created_at       = $resAut["created_at"];
                $this->token_type       = $resAut["token_type"];

                return true;

            } catch (HttpException $ex) {
           
                echo $ex->getMessage();

                return false;
            }
        }
    }

    /**
     * Create a new get request for listing.
     *
     * @param  string  $tokenName
     * @param  array   $params
     * @return mixed
     */

    public function apiTokenGet($tokenName,$params)
    {

        if ($this->connected) {

            if (count($params) > 0) {

                $pr = "?";
                foreach ($params as $param => $val) {
                    $pr .= $param . "=" . $val . "&";
                }
            } else {
                $pr = "";
            }

            $pr = substr($pr, 0, -1);

            try {
                $client = new \http\Client;
                $request = new \http\Client\Request;
                
                $request->setRequestUrl(self::TOKEN_URL . '/' . self::COMPANY_ID . '/' . $tokenName . $pr);
                $request->setRequestMethod('GET');
                $request->setHeaders(array(
                    'content-type' => 'application/json',
                    'authorization' => 'Bearer ' . $this->access_token

                ));

                $client->enqueue($request)->send();
                $response = $client->getResponse();

                return $response->getBody();

            } catch (HttpException $ex) {

                echo $ex->getMessage();
            }
        }
        else
        return false;
    }

    /**
     * Create a new post request.
     *
     * @param  string  $tokenName
     * @param  array   $postParams
     * @param  string  $postParam < default null>
     * @param  string  $additional < default null>
     * @return mixed
     */

    public function apiTokenPost($tokenName,$postParams,$postParam=null,$additional=null)
    {

        if(isset($postParam))
            $postParam = "/" . $postParam;
        else
            $postParam = "";

        if(isset($additional))
            $additional = "/" . $additional;
        else
            $additional = "";


        if ($this->connected) {
            try {
                $client = new \http\Client;
                $request = new \http\Client\Request;

                $request->setRequestUrl(self::TOKEN_URL . '/' . self::COMPANY_ID . '/' . $tokenName . $postParam . $additional);
                $request->setRequestMethod('POST');
                $request->setHeaders(array(
                    'content-type' => 'application/json',
                    'authorization' => 'Bearer ' . $this->access_token

                ));

                $request->setQuery(new \http\QueryString($postParams));

                $client->enqueue($request)->send();
                $response = $client->getResponse();

                return $response->getBody();

            } catch (HttpException $ex) {

                echo $ex->getMessage();
            }
        }
        else
            return false;
    }

    /**
     * Create a new request.
     *
     * @param  string  $tokenName <put request name>
     * @param  integer  $putParam  <id value>
     * @param  array   $putParams <for http querystring>
     * @return mixed
     */

    public function apiTokenPut($tokenName,$putParam,$putParams)
    {

        if ($this->connected) {

            try {
                $client = new \http\Client;
                $request = new \http\Client\Request;

                $request->setRequestUrl(self::TOKEN_URL . '/' . self::COMPANY_ID . '/' . $tokenName .'/'. $putParam);
                $request->setRequestMethod('PUT');
                $request->setHeaders(array(
                    'content-type' => 'application/json',
                    'authorization' => 'Bearer ' . $this->access_token
                ));

                $request->setQuery(new \http\QueryString($putParams));

                $client->enqueue($request)->send();
                $response = $client->getResponse();

                return $response->getBody();

            } catch (HttpException $ex) {

                echo $ex->getMessage();
            }
        }
        else
            return false;
    }

    /**
     * Create a new delete request for listing.
     *
     * @param  string  $tokenName
     * @param  array   $param
     * @return mixed
     */

    public function apiTokenDelete($tokenName,$param)
    {

        if ($this->connected) {

            try {
                $client = new \http\Client;
                $request = new \http\Client\Request;

                $request->setRequestUrl(self::TOKEN_URL . '/' . self::COMPANY_ID . '/' . $tokenName . "/" . $param);
                $request->setRequestMethod('DELETE');
                $request->setHeaders(array(
                    'content-type' => 'application/json',
                    'authorization' => 'Bearer ' . $this->access_token

                ));

                $client->enqueue($request)->send();
                $response = $client->getResponse();

                return $response->getBody();

            } catch (HttpException $ex) {

                echo $ex->getMessage();
            }
        }
        else
            return false;
    }
}

?>
