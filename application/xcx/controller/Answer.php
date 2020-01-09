<?php
namespace app\xcx\controller;
use app\xcx\model\AnswerModel;
use app\xcx\model\OrderModel;

class Answer
{
    //列表
    public function query()
    {
        $data = input('param.');
        $where = $data['condition'];
        array_filter($where);
        $pageNumber = $data['pageNumber'] ? $data['pageNumber'] : '1';
        $type = new AnswerModel();
        // 查询数据集
        $res = $type->getList($where, $pageNumber);
        return format_return_data($res);
    }

    //添加
    public function add()
    {
        $data = input('param.');
        $type = new AnswerModel();
        // 查询数据集
        $res = $type->add($data);

        return format_return_data();
    }

    //修改
    public function edit()
    {
        $data = input('param.');
        if(!$data['id']){
            return format_return_data('', 'error');
        }

        $type = new AnswerModel();
        // 查询数据集
        $res = $type->edit('id = '.$data['id'], $data);

        return format_return_data();
    }

    //修改
    public function getAnswer()
    {
        $data = input('param.');
        if(!$data['id']){
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

        $type = new AnswerModel();
        // 查询数据集
        $res = $type->del('id = '.$data['id']);

        return format_return_data();
    }
}
