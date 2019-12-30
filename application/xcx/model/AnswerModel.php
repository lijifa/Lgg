<?php
namespace app\xcx\model;

use think\Model;
use think\Db;

class AnswerModel extends Model
{
	function __construct(){
		$this->answer	= "answer";
		$this->listRows = config('paginate.list_rows');
	}
	
	/*
	* 获取列表
	* @post:
	**/
	public function getList($where, $pagenum=1, $order='num asc') {
		$count = Db::name($this->answer)->where($where)->count();
		
		$list = Db::name($this->answer)->where($where)->page($pagenum.','.$this->listRows)->order($order)->select();
	
		$resData = [
			'totalRow' => $count,
	        'pageNumber' => $pagenum,
	        'pageSize' => $this->listRows,
	        'totalPage' => ceil($count/$this->listRows),
	        'list' => $list
		];

		return $resData;
	}

	/*
	* 获取答案，并且生成订单
	* @post:
	**/
	public function getAnswer($data) {
		// 获取规则列表中的数据


		// 生成订单
		$res = db('answer')->insert($data);
		//echo AnswerModel::getLastSql();
		return $res;
	}

	/*
	* 添加
	* @post:
	**/
	public function add($data) {
		// 添加单条数据
		$res = db('answer')->insert($data);
		//echo AnswerModel::getLastSql();
		return $res;
	}

	/*
	* 编辑
	* @post:
	**/
	public function edit($where, $data) {
		// 更新单条数据
		$res = Db::name($this->answer)->where($where)->data($data)->update();
		//echo AnswerModel::getLastSql();
		return $res;
	}
	
	/*
	* 删除
	* @post:
	**/
	public function del($where) {
		// 更新单条数据
		$res = Db::name($this->answer)->where($where)->delete();
		//echo AnswerModel::getLastSql();
		return $res;
	}
}