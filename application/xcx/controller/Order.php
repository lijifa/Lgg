<?php
namespace app\xcx\controller;
use app\xcx\model\RuleModel;
use app\xcx\model\OrderModel;
use app\xcx\model\QuestionTypeModel;

class Order
{
    //列表
    public function query()
    {
        $data = input('param.');
        $where = $data['condition'];
        array_filter($where);
        $pageNumber = $data['pageNumber'] ? $data['pageNumber'] : '1';
        $type = new OrderModel();
        // 查询数据集
        $res = $type->getList($where, $pageNumber);
        return format_return_data($res);
    }

    //添加
    public function add()
    {
        $data = input('param.');

        //分析提交数据
        $addData = [
            'user_id' => $data['user_id'],
            'user_name' => $data['user_name'],
            'question_type_id' => $data['question_type_id'],
            'state' => 1
        ];

        // 取得当前问题类型的设置的对应计分规则
        $rule = new RuleModel();
        $ruleData = $rule->getAllList('question_type_id='.$data['question_type_id']);

        // 根据规则计算用户最后得分分数
        $res = clacScore($ruleData['list'], $data['answerOption']);
// dump($res);
        // 根据设置的计分规则判断条件得出结果
        $all_content   = '';
        $item_content  = [];
        $result_ids = '';
        foreach ($ruleData['list'] as $key => $value) {
            //【总项计分】根据结果得分分数，获取对应内容
            if ($value['score_type'] == 0){
                if(isRuleOk($res['allScore'], $value['rule_str'])) {
                   $all_content = $value['content_1'];
                   $result_ids .= $value['rule_id'].',';
                }
            }else{
            //【分项计分】根据不同题号所得分数，获取对应内容
                foreach ($res['itemScore'] as $kk => $vv) {
                    if ($vv['rule_id'] == $value['id'] && isRuleOk($vv['score'], $value['rule_str'])) {
                        array_push($item_content, $value['content_1']);
                        $result_ids .= $value['rule_id'].',';
                    }
                }
            }
        }
        // 判断分项规则
        // foreach ($ruleData['list'] as $key => $value) {
        //     foreach ($res['itemScore'] as $kk => $vv) {
        //         if (isRuleOk($vv, $value['rule_str'])) {
        //             array_push($item_content, $value['content_1']);
        //         }
        //     }
        // }

        $result = [
            'all' => $all_content,
            'item' => $item_content
        ];


      //  dump(json_encode($result));exit();
        //获取分类名称、价格
        $questionType = new QuestionTypeModel();
        $qtData = $questionType->detail('id = '. $data['question_type_id']);
        $addData['question_type'] = $qtData['typename'];
        $addData['price'] = $qtData['price'];
        $addData['score_json'] = json_encode($res);
        $addData['result_ids'] = trim($result_ids, ',');
        
        // 添加订单数据
        $order = new OrderModel();
        $res = $order->add($addData);

        return format_return_data($res);
    }

    //修改
    public function edit()
    {
        $data = input('param.');
        if(!$data['id']){
            return format_return_data('', 'error');
        }

        $type = new OrderModel();
        // 查询数据集
        $res = $type->edit('id = '.$data['id'], $data);

        return format_return_data();
    }

    public function getDetail()
    {
        $data = input('param.');
        if(!$data['oid']){
            return format_return_data('', 'error');
        }

        $order = new OrderModel();
        // 查询订单详情
        $res = $order->detail('id = '.$data['oid']);

        return format_return_data($res);
    }

    //删除
    public function del()
    {
        $data = input('param.');
        if(!$data['id']){
            return format_return_data('', 'error');
        }

        $type = new OrderModel();
        // 查询数据集
        $res = $type->del('id = '.$data['id']);

        return format_return_data();
    }
}
