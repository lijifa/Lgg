<?php
namespace app\admin\controller;
use app\admin\model\VipModel;

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

    //会员添加
    public function add()
    {
        return '添加用户';
    }
}
