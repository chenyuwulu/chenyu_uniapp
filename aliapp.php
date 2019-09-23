<?php
/**
 * chenyu_uniapp支付宝小程序接口定义
 *
 * @author 尘雨雾录
 * @url
 */
defined('IN_IA') or exit('Access Denied');

class Chenyu_uniappModuleAliapp extends WeModuleAliapp {
	public function doPageTest(){
        global $_GPC, $_W;
        $errno = 0;
        $message = '此处是微擎小程序后端返回消息';
        $data = array(
            'w'=>$_W,
            'gpc'=>$_GPC
        );
        return $this->result($errno, $message, $data);
	}

	public function doPageGetuserinfo(){
	    /*
	     * 引入支付宝的php对应的sdk，对应版本可自行去支付宝开放平台查询
	     * 不推荐引入在头部，因为阿里的sdk，大家心里清楚，冗余代码很多
	     * 建议哪里用到再引入，尽可能避免效率问题  (因为作者的服务器很烂，服务器好的可忽略)
	    */
        include (IA_ROOT . '/addons/chenyu_uniapp/inc/SDK/alipay-sdk-PHP-3.4.2/AopSdk.php');
	    global $_GPC, $_W;
        $list = pdo_fetch("SELECT * FROM " . tablename('chenyu_uniapp_site') . " WHERE uniacid=:uniacid ", array(':uniacid' => $_W['uniacid']));
        $siteinfo = unserialize($list['site']);
        $errno = 0;
        $message = '这是用户授权';
        $aop = new AopClient();
        $aop->gatewayUrl = $siteinfo['gatewayUrl'];
        $aop->appId = $siteinfo['appId'];
        $aop->rsaPrivateKey = $siteinfo['rsaPrivateKey'];
        $aop->alipayrsaPublicKey = $siteinfo['alipayrsaPublicKey'];
        $aop->apiVersion = '1.0';
        $aop->signType = 'RSA2';
        $aop->postCharset='UTF-8';
        $aop->format='json';
        $request = new AlipaySystemOauthTokenRequest ();
        $request->setGrantType("authorization_code");
        $request->setCode($_GPC['authCode']);
        $request->setRefreshToken("");
        $result = $aop->execute($request);
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $resultCode = $result->$responseNode->code;
        return $this->result($errno, $message, array(
            'result'=>$result,
            'resultCode'=>$resultCode
        ));
    }
}