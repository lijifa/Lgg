<?php
namespace app\xcx\controller;
use app\xcx\model\RuleModel;

class Rule
{
    //列表
    public function query()
    {
        $data = input('param.');
        $where = '';
        $pageNumber = $data['pageNumber'] ? $data['pageNumber'] : '1';
        $type = new RuleModel();
		// 查询数据集
		$res = $type->getList($where, $pageNumber);
		return format_return_data($res);
    }

    //获取规则
    public function getRuleAnswer() {
        $data = input('param.');

        $where = '';
        $pageNumber = $data['pageNumber'] ? $data['pageNumber'] : '1';
        $type = new RuleModel();
        // 查询数据集
        $res = $type->getList($where, $pageNumber);
        return format_return_data($res);

    }



    //添加
    public function add()
    {
        $data = input('param.');
        $resultData = [
            'content_1' => $data['content_1'],
            'content_2' => $data['content_2'],
            'content_3' => $data['content_3']
        ];

        //$score_range = explode('|', $data['score_range']);
        $ruleData = [
            'question_type_id' => $data['question_type_id'],
            'rule_name' => $data['rule_name'],
            'nums' => $data['nums'],
            'score_type' => $data['score_type'],
            'rule_str'  => $data['rule_str'],
            'min_score' => 0,   //$score_range['0'],
            'max_score' => 0    //$score_range['1'],
        ];

        $type = new RuleModel();
        // 查询数据集
        $res = $type->add($ruleData, $resultData);

        return format_return_data();
    }

    //修改
    public function edit()
    {
        $data = input('param.');
        if(!$data['id']){
            return format_return_data('', 'error');
        }

        $type = new RuleModel();
        // 查询数据集
        $res = $type->edit('id = '.$data['id'], $data);

        return format_return_data();
    }

    //删除
    public function del()
    {
        $data = input('param.');
        if(!$data['id']){
            return format_return_data('', 'error');
        }

        $type = new RuleModel();
        // 查询数据集
        $res = $type->del('id = '.$data['id']);

        return format_return_data();
    }
}
