<?php
namespace Iwanli\Wxxcx;


use Ixudra\Curl\Facades\Curl;

class Wxxcx
{
    /**
     * @var string
     */
    private $appId;
    private $secret;
    private $code2session_url;
    private $sessionKey;

    /**
     * Wxxcx constructor.
     * @param $code 登录凭证（code）
     */
    function __construct()
    {
        $this->appId = config('wxxcx.appid', '');
        $this->secret = config('wxxcx.secret', '');
        $this->code2session_url = config('wxxcx.code2session_url', '');
    }

    /**
     * Created by vicleos
     * @return mixed
     */
    public function getLoginInfo($code){
        return $this->authCodeAndCode2session($code);
    }

    /**
     * Created by vicleos
     * @param $encryptedData
     * @param $iv
     * @return string
     * @throws \Exception
     */
    public function getUserInfo($encryptedData, $iv){
        $pc = new WXBizDataCrypt($this->appId, $this->sessionKey);
        $decodeData = "";
        $errCode = $pc->decryptData($encryptedData, $iv, $decodeData);
        if ($errCode !=0 ) {
            return [
                'code' => 10001,
                'message' => 'encryptedData 解密失败'
            ];
        }
        return $decodeData;
    }

    /**
     * Created by vicleos
     * 根据 code 获取 session_key 等相关信息
     * @throws \Exception
     */
    private function authCodeAndCode2session($code){
        $code2session_url = sprintf($this->code2session_url,$this->appId,$this->secret,$code);
        $userInfo = $this->httpRequest($code2session_url);
        if(!isset($userInfo['session_key'])){
            return [
                'code' => 10000,
                'code' => '获取 session_key 失败',
            ];
        }
        $this->sessionKey = $userInfo['session_key'];
        return $userInfo;
    }


    /**
     * 请求小程序api
     * @author 晚黎
     * @date   2017-05-27T11:51:10+0800
     * @param  [type]                   $url  [description]
     * @param  [type]                   $data [description]
     * @return [type]                         [description]
     */
    private function httpRequest($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        if($output === FALSE ){
            return false;
        }
        curl_close($curl);
        return json_decode($output,JSON_UNESCAPED_UNICODE);
    }

}