<?php
namespace app\admin\model;

use think\Model;
use think\Db;

class UserModel extends Model
{
	function __construct(){
		$this->user	= "user";
	}
	
	/*
	* 获取列表
	* @post:
	**/
	public function getList($where) {
		//return M($this->problem_type)->where($where)->field($field)->limit($limit)->order($order)->select();
		return db($this->user)->where($where)->select();
		//return ProblemType::where($where)->order('problem_type_id desc')->select();
	}
	//添加

	//删除

	//编辑
}