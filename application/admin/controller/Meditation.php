<?php
namespace app\admin\controller;
use app\admin\model\MeditationModel;

class Meditation
{
    //列表
    public function query()
    {
        $data = input('param.');
        $queryParam = $data['condition'];
        $where = array_filter($queryParam);
        $pageNumber = $data['pageNumber'] ? $data['pageNumber'] : '1';
        $type = new MeditationModel();
		// 查询数据集
		$res = $type->getList($where, $pageNumber);
		return format_return_data($res);
    }

	//下拉列表
    public function queryAll()
    {
        $type = new MeditationModel();
		// 查询数据集
		$res = $type->getSelect(1, 'id, typename');
		return format_return_data($res);
    }

    
    //添加
    public function add()
    {
        $data = input('param.');
        $type = new MeditationModel();
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

        $type = new MeditationModel();
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

        $type = new MeditationModel();
        // 查询数据集
        $res = $type->del('id = '.$data['id']);

        return format_return_data();
    }
}
