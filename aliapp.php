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
	     * 自从支付宝去除了那个臃肿的php sdk引用框架后，现在是用到什么引入什么。
	     * 但还是建议在哪里用到了，在哪里引入，其他地方不要引入。
	     * 和以前的sdk的使用方式一样，最大区别就是，不能单单引用一个类，而是用到多少类，引用多少类
	    */
//        include (IA_ROOT . '/addons/chenyu_uniapp/inc/SDK/alipay-sdk-PHP-3.4.2/AopSdk.php');
        include (IA_ROOT . '/addons/chenyu_uniapp/inc/SDK/alipay-sdk-PHP-4.9.2/aop/AopClient.php');
        include (IA_ROOT . '/addons/chenyu_uniapp/inc/SDK/alipay-sdk-PHP-4.9.2/aop/request/AlipaySystemOauthTokenRequest.php');
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

        $list = pdo_fetch('select * from '.tablename('chenyu_uniapp_user_mp_alipay').' where uniacid=:uniacid and user_id=:user_id ',array(':uniacid'=>$_W['uniacid'],':user_id'=>$result->alipay_system_oauth_token_response->user_id));
        if(empty($list)){
            $errno = 0;
            $info = array(
                'uniacid'=>$_W['uniacid'],
                'user_id'=>$result->alipay_system_oauth_token_response->user_id,
                'nickName'=>$_GPC['nickName'],
                'avatar'=>$_GPC['avatar'],
                'createtime'=>time(),
            );
            $ress=pdo_insert('chenyu_uniapp_user_mp_alipay', $info);
            if (!empty($ress)) {
                $userlist = pdo_fetch("SELECT * FROM ".tablename('chenyu_uniapp_user_mp_alipay')." WHERE uniacid=:uniacid and user_id=:user_id ", array(':uniacid'=>$_W['uniacid'],':user_id'=>$ress['user_id']));
                $data = $userlist;
            }
        } else {
            $errno = 0;
            $data = $list;
        }


        return $this->result($errno, $message, array(
            'result'=>$result,
            '$data'=>$data
        ));
    }
}