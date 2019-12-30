<?php
namespace app\admin\controller;
use app\admin\model\UserModel;

class Index
{
    public function index()
    {
        $type = new UserModel();
		// 查询数据集
		$res = $type->getList('id=1');
		return format_return_data($res);
    }

    public function add()
    {
        return '添加用户';
    }
}
