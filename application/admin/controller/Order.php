<?php
namespace app\admin\controller;
use app\admin\model\RuleModel;
use app\admin\model\OrderModel;
use app\admin\model\QuestionTypeModel;

class Order
{

    //列表
    public function query()
    {
        $data = input('param.');
        $queryParam = $data['condition'];
        $where = array_filter($queryParam);
        $pageNumber = $data['pageNumber'] ? $data['pageNumber'] : '1';
        $type = new OrderModel();
        // 查询数据集
        $res = $type->getList($where, $pageNumber);
        return format_return_data($res);
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
