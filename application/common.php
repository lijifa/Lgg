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
function clacScore ($ruledata, $answerData) {

    $allScore = 0;
	$itemScore = [];
    $score = 0;
	//总分
    foreach ($answerData as $key => $value) {
        $allScore += $value['2'];
    }

	foreach ($ruledata as $k => $item) {  
        //分项
        if($item['score_type'] == 1){
            foreach ($answerData as $kk => $value) {
                //echo strpos($value['0'], $item['nums']);
                if (strpos($item['nums'], $value['0'])) {
                    $score += $value['2'];
                }
            }
            array_push($itemScore, ['score' => $score, 'rule_id' => $item['id']]);
            $score=0;
        }
	}

    return [
        'allScore' => $allScore,
        'itemScore' => $itemScore
    ];
}

//判断规则条件是否正确
function isRuleOk($x, $ruleStr){
    $ruleTmp = '';
    if (substr_count($ruleStr, '<') > 1 || substr_count($ruleStr, '>') > 1) {
        $ruleTmp = str_replace("x", 'x && x', $ruleStr);
    }else{
        $ruleTmp = $ruleStr;
    }

    // if (substr_count('>', $ruleStr) > 1) {
    //      $rule = str_replace("x", 'x && x', $ruleStr);
    // }

    $rule = str_replace("x", $x, $ruleTmp);
    $result = eval("return $rule;");
    return $result;
}

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


