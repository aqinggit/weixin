<?php

class weixinSdk {

    public $appid;
    public $secret;
    public $redirect_uri;
    public static $state;

    const LOGIN_URL = 'https://open.weixin.qq.com/connect/oauth2/authorize?'; //登录地址
    //const LOGIN_URL = 'https://open.weixin.qq.com/connect/qrconnect?'; //登录地址
    const ACCESS_TOKEN_URL = 'https://api.weixin.qq.com/sns/oauth2/access_token?'; //AccessToken 获取地址
    const REFRESH_TOKEN_URL = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?'; //刷新 AccessToken
    const AUTH_ACCESS_TOKEN_URL = 'https://api.weixin.qq.com/sns/auth?'; //验证 AccessToken的有效性
    const USERINFO_URL = 'https://api.weixin.qq.com/sns/userinfo?'; //获取用户信息

    function __construct($appid, $secret, $callback) {
        $this->appid = $appid;
        $this->secret = $secret;
        $this->redirect_uri = $callback;
    }

    function login() {
        $state = $this->_state();
        $data = array(
            'appid' => $this->appid,
            'redirect_uri' => $this->redirect_uri,
            'response_type' => 'code',
            'scope' => 'snsapi_userinfo',
            'state' => $state,
        );
        $loginUrl = self::LOGIN_URL . (http_build_query($data)) . '#wechat_redirect';
        return $loginUrl;
    }

    function getAccessToken() {
        $get_state = $_GET['state'];
        $state = $this->_state('get');
        if ($get_state != $state) {
            //bug
            //return $this->_return('验证信息失败，请重新授权', 0);
        }
        $code = $_GET['code'];
        $data = array(
            'appid' => $this->appid,
            'secret' => $this->secret,
            'code' => $code,
            'grant_type' => 'authorization_code',
        );
        $accessTokenUrl = self::ACCESS_TOKEN_URL . (http_build_query($data));
        $token = $this->_Curl($accessTokenUrl);
        if (!$this->_is_json($token)) {
            return $this->_return('获取access_token失败', 0);
        } else {
            return $this->_return($token);
        }
    }

    function refreshToken($refresh_token) {
        $data = array(
            'appid' => $this->appid,
            'refresh_token' => $refresh_token,
            'grant_type' => 'refresh_token',
        );
        $refreshTokenUrl = self::REFRESH_TOKEN_URL . (http_build_query($data));
        $refreshToken = $this->_Curl($refreshTokenUrl);
        if (!$this->_is_json($refreshToken)) {
            return $this->_return('刷新access_token失败', 0);
        } else {
            return $this->_return($refreshToken);
        }
    }

    function authAccessToken($openid, $access_token) {
        $data = array(
            'openid' => $openid,
            'access_token' => $access_token,
        );
        $queryUrl = self::AUTH_ACCESS_TOKEN_URL . (http_build_query($data));
        $auth = $this->_Curl($queryUrl);
        $arr = json_decode($auth, true);
        if ($arr['errmsg'] === 'ok') {
            return true;
        } else {
            return false;
        }
    }

    function getUserInfo($openid, $access_token) {
        $data = array(
            'openid' => $openid,
            'access_token' => $access_token,
        );
        $queryUrl = self::USERINFO_URL . (http_build_query($data));
        $uinfo = $this->_Curl($queryUrl);
        if (!$this->_is_json($uinfo)) {
            return $this->_return('获取用户信息失败', 0);
        } else {
            return $this->_return($uinfo);
        }
    }

    function _state($do = '') {
        if ($do == 'get') {
            session_start();
            if ($_SESSION['state']) {
                return $_SESSION['state'];
            } else {
                return null;
            }
        } else {
            $this->state = md5(uniqid(rand(), TRUE));
            session_start();
            $_SESSION['state'] = $this->state;
            return $this->state;
        }
    }

    function _Curl($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $dataBlock = curl_exec($ch);
        curl_close($ch);
        return $dataBlock;
    }

    function _return($data, $status = 1) {
        $return['status'] = $status;
        if ($status == 1) {
            $arr = json_decode($data, true);
            if ($arr['errcode']) {
                $return['status'] = 0;
                $return['data'] = $arr['errmsg'];
            } else {
                $return['data'] = $arr;
            }
        } else {
            $return['data'] = $data;
        }
        return $return;
    }

    function _is_json($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

}

?>