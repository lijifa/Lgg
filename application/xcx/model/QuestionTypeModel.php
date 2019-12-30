<?php
namespace app\xcx\model;

use think\Model;
use think\Db;

class QuestionTypeModel extends Model
{
	function __construct(){
		$this->question_type = "question_type";
		$this->listRows = config('paginate.list_rows');
	}
	
	/*
	* 获取列表
	* @post:
	**/
	public function getList($where, $pagenum=1, $order='id asc') {
		//return M($this->problem_type)->where($where)->field($field)->limit($limit)->order($order)->select();
		$count = Db::name($this->question_type)->where($where)->count();
		
		$list = Db::name($this->question_type)->where($where)->page($pagenum.','.$this->listRows)->order($order)->select();
	
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
	* 获取全部
	* @post:
	**/
	public function getSelect($where=1, $field='') {
		//return M($this->problem_type)->where($where)->field($field)->limit($limit)->order($order)->select();
		$list = Db::name($this->question_type)->where($where)->field($field)->select();
	
		$resData = [
	        'list' => $list
		];

		return $resData;
	}
}