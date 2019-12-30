<?php
namespace app\xcx\controller;
use app\xcx\model\QuestionTypeModel;

class QuestionType
{
    //列表
    public function query()
    {
        $data = input('param.');
        $where = '';
        $pageNumber = $data['pageNumber'] ? $data['pageNumber'] : '1';
        $type = new QuestionTypeModel();
		// 查询数据集
		$res = $type->getList($where, $pageNumber);
		return format_return_data($res);
    }

	//下拉列表
    public function queryAll()
    {
        $type = new QuestionTypeModel();
		// 查询数据集
		$res = $type->getSelect(1, 'id, typename');
		return format_return_data($res);
    }

    //添加
    public function add()
    {
        return '添加';
    }
}
