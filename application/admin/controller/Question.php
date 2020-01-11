<?php
namespace app\admin\controller;
use app\admin\model\QuestionModel;

class Question
{
    //列表
    public function query()
    {
        $data = input('param.');
        $queryParam = $data['condition'];
        $where = array_filter($queryParam);
        $pageNumber = $data['pageNumber'] ? $data['pageNumber'] : '1';
        $type = new QuestionModel();
		// 查询数据集
		$res = $type->getList($where, $pageNumber);
		return format_return_data($res);
    }

    //列表
    public function queryChooseAll()
    {
        $data = input('param.');
        $queryParam = $data['condition'];
        $postData = array_filter($queryParam);
        $type = new QuestionModel();
        $where = 'question_type_id = '.$postData['question_type_id'];
        $where .= ' and id in ('.implode(',', $postData['question_no']).')';
        // 查询数据集
        $res = $type->getAllList($where);
        return format_return_data($res);
    }

    //添加
    public function add()
    {
        $data = input('param.');
        $type = new QuestionModel();
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

        $type = new QuestionModel();
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

        $type = new QuestionModel();
        // 查询数据集
        $res = $type->del('id = '.$data['id']);

        return format_return_data();
    }
}
