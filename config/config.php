<?php

return [

    /*
    |--------------------------------------------------------------------------
    | AppID and AppSecret configuration
    |--------------------------------------------------------------------------
    |
    | Multiple AppId and AppSecret
    | Usage:
    | - default: new Iwanli\Wxxcx\Wxxcx();
    | - other: new Iwanli\Wxxcx\Wxxcx(config('wxxcx.other'));
    */

    'default' => [
        'appid' => 'your AppID',
        'secret' => 'your AppSecret',
    ],

    'other' => [
        'appid' => 'your other AppSecret',
        'secret' => 'your other AppSecret',
    ],

    // and more ...

	
    /**
     * 小程序登录凭证 code 获取 session_key 和 openid 地址，不需要改动
     */
    'code2session_url' => "https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code",
];
