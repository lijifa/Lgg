<?php
namespace app\xcx\controller;
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
            'price' => $data['price'],
            'score' => '0',
            'result_ids' => '1,2,3',
            'state' => 1
        ];

        //根据分类判断积分规则


        $order = new OrderModel();
        $questionType = new QuestionTypeModel();

        $qtData = $questionType->detail('id = '. $data['question_type_id']);
        $addData['question_type'] = $qtData['typename'];
        

        // 添加数据
        $res = $order->add($addData);

        return format_return_data();
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
