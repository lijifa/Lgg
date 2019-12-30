<?php
namespace app\xcx\model;

use think\Model;
use think\Db;

class VipModel extends Model
{
	function __construct(){
		$this->vip	= "vip";
		$this->listRows = config('paginate.list_rows');
	}
	
	/*
	* 获取列表
	* @post:
	**/
	public function getList($where=1, $pagenum=1) {
		//return M($this->problem_type)->where($where)->field($field)->limit($limit)->order($order)->select();
		$count = Db::name($this->vip)->where($where)->count();
		
		$list = Db::name($this->vip)->where($where)->page($pagenum.','.$this->listRows)->select();

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
		$res = Db::name($this->vip)->insert($data);
		$userId = Db::name($this->vip)->getLastInsID();
		//echo VipModel::getLastSql();
		return $userId;
	}

	//删除

	//编辑
}