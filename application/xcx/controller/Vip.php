<?php
namespace app\xcx\controller;
use app\xcx\model\VipModel;
use \think\Session;

class Vip
{
    //列表
    public function query()
    {
        $type = new VipModel();
		// 查询数据集
		$res = $type->getList();
		return format_return_data($res);
    }

    //获取openid
    public function getopenid()
    {
        $appid = config('appid');
        $secret = config('appSecret');
        $js_code = input('js_code');
        //通过code换取网页授权access_token
        $weixin =  file_get_contents("https://api.weixin.qq.com/sns/jscode2session?appid=$appid&secret=$secret&js_code=$js_code&grant_type=authorization_code");
        $jsondecode = json_decode($weixin);     //对JSON格式的字符串进行编码
        $array = get_object_vars($jsondecode);  //转换成数组
        return $array['openid'];                //输出openid
    }
 
 
    //获取用户信息
    public function get_user()
    {
        if($this->check_openid()){
            $openid = input('openid');
            $data['nickname'] = input('nickname');
            $data['userpic'] = input('userpic');
            $user = db('vip')->where('openid', $openid)->find();
            if($user){
                //判断用户的头像和名称为空的话，更新信息，并更新返回的$user
                if($user['nickname']=='' && $user['userpic']==''){
                    db('vip')->where('openid',$openid)->update($data);
                    $user['nickname'] = $data['nickname'];
                    $user['userpic'] = $data['userpic'];
                }
                //重置token
                $user['token'] = $this->restToken($openid);
                if($user['token']){
                    Session::set('vipData', $user);
                    return json(['status'=>200,'msg'=>'验证成功','data'=>$user]);
                }else{
                    return json(['status'=>401,'msg'=>'token重置失败']);
                }
            }else{
                return json(['status'=>400,'msg'=>'用户不存在']);
            }
        }else{
            return json(['status'=>401,'msg'=>'登录失败，请重新授权登录']);
        }
    }
 
    //注册
    public function register()
    {
        $data['openid'] = input('openid');
        $data['nickname'] = input('nickname');
        $data['userpic'] = input('userpic');
        $data['token'] = getRandChar(32);
        $data['token_time'] = time();
        $vipId = db('vip')->getLastInsID($data);
        if($user){
            $data['vipId'] = $vipId;
            Session::set('vipData', $data);
            return json(['status'=>200,'msg'=>'注册成功','data'=>$data]);
        }else{
            return json(['status'=>400,'msg'=>'注册失败']);
        }
    }



    //检验openid，服务端获取的openid与传过来的openid进行对比
    public function check_openid()
    {
        $appid = config('appid');
        $secret = config('appSecret');
        $grant_type = 'authorization_code';
        $url = 'https://api.weixin.qq.com/sns/jscode2session';
        $openid = input('openid');
        $js_code = input('code');
        $data = [
            'appid'=>$appid,
            'secret'=>$secret,
            'js_code'=>$js_code,
            'grant_type'=>$grant_type
        ];
        //获取接收结果
        $res =httpWurl($url,$data,'POST');
        $obj = json_decode($res);
        //return $obj->openid;
        if($obj->openid == $openid){
            return true;
        }else{
            return false;
        }
    }
 
 
    //重置token,还有token_time
    public function restToken($openid)
    {
        $data['token'] = getRandChar(32);//getRandChar(32):获取32位的字符串
        $data['token_time'] = time();
        $res = db('vip')->where('openid',$openid)->update($data);
        if($res){
            return $data['token'];
        }else{
            return false;
        }
    }
 
 
    //验证token有效性
    public function checkToken()
    {
        $openid = input('openId');
        $token = input('token');
        $user = db('vip')->where(array('openid'=>$openid,'token'=>$token))->find();
        if($user){
            //如果登录超过1个月，就表示过期了
            if((time()-$user['token_time'])>2592000){
                return false;
            }else{
                return true;
            }
        }else{
            return false;
        }
    }
 
    //获取用户id
    public function getUserId($openId){
        $userId = db('vip')->where('openid',$openId)->value('id');
        return $userId;
    }
 
    //获取用户头像，名字
    public function getPicName($openId)
    {
        $userPicName = db('vip')->where('openid',$openId)->field('username,userpic')->find();
        return $userPicName;
    }
 
}
