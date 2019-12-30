<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件


//格式化Json返回数据
function format_return_data ($data = '', $flag = 'success') {
	if($flag == 'success') {
		return json([
	      'code' => '00',
	      'msg' => '操作成功',
	      'data' => $data
		]);
	} else {
		return json([
	      'code' => 'A1',
	      'msg' => '操作失败',
	      'data' => ''
	    ]);
	}
	//return json(['data'=>$data,'code'=>1,'message'=>'操作完成']);
}

//计算分数
// function clacScore ($data, $no = '', flag = 1) {
// 	$resScore = 0;
// 	if ($flag == 0) {
// 		//算总分
// 		foreach ($data as $key => $item) {
			
// 		}
// 	}


// }

//随机字符串
function getRandChar($len){
    $str = "1234567890asdfghjklqwertyuiopzxcvbnmASDFGHJKLZXCVBNMPOIUYTREWQ";
    return substr(str_shuffle($str),0,$len);
}

function httpWurl($url, $params, $method = 'GET', $header = array(), $multi = false){
        date_default_timezone_set('PRC');
        $opts = array(
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTPHEADER     => $header,
            CURLOPT_COOKIESESSION  => true,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_COOKIE         =>session_name().'='.session_id(),
        );
        /* 根据请求类型设置特定参数 */
        switch(strtoupper($method)){
            case 'GET':
                // $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
                // 链接后拼接参数  &  非？
                $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
                break;
            case 'POST':
                //判断是否传输文件
                $params = $multi ? $params : http_build_query($params);
                $opts[CURLOPT_URL] = $url;
                $opts[CURLOPT_POST] = 1;
                $opts[CURLOPT_POSTFIELDS] = $params;
                break;
            default:
                throw new Exception('不支持的请求方式！');
        }
        /* 初始化并执行curl请求 */
        $ch = curl_init();
        curl_setopt_array($ch, $opts);
        $data  = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if($error) throw new Exception('请求发生错误：' . $error);
        return  $data;
    }


