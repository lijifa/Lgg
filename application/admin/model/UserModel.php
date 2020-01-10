<?php
namespace app\admin\model;

use think\Model;
use think\Db;

class UserModel extends Model
{
	function __construct(){
		$this->user	= "user";
		$this->listRows = config('paginate.list_rows');
	}
	
	/*
	* 获取列表
	* @post:
	**/
	public function getList($where=1, $pagenum=1, $order='id desc') {
		//return M($this->problem_type)->where($where)->field($field)->limit($limit)->order($order)->select();
		$count = Db::name($this->user)->where($where)->count();
		
		$list = Db::name($this->user)->where($where)->page($pagenum.','.$this->listRows)->order($order)->select();

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
	* 添加
	* @post:
	**/
	public function add($data) {
		// 添加单条数据
		$res = db('user')->insert($data);
		//echo QuestionModel::getLastSql();
		return $res;
	}

	/*
	* 编辑
	* @post:
	**/
	public function edit($where, $data) {
		// 更新单条数据
		$res = Db::name($this->user)->where($where)->data($data)->update();
		//echo QuestionModel::getLastSql();
		return $res;
	}
	
	/*
	* 删除
	* @post:
	**/
	public function del($where) {
		// 更新单条数据
		$res = Db::name($this->user)->where($where)->delete();
		//echo QuestionModel::getLastSql();
		return $res;
	}
}