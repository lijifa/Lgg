<?php
namespace app\admin\model;

use think\Model;
use think\Db;

class MeditationModel extends Model
{
	// 设置当前模型对应的完整数据表名称
	protected $table = 'zx_meditation';
	function __construct(){
		$this->meditation = "meditation";
		$this->listRows = config('paginate.list_rows');
	}
	
	/*
	* 获取列表
	* @post:
	**/
	public function getList($where, $pagenum=1, $order='id asc') {
		//return M($this->meditation)->where($where)->field($field)->limit($limit)->order($order)->select();
		$count = Db::name($this->meditation)->where($where)->count();
		
		$list = Db::name($this->meditation)->where($where)->page($pagenum.','.$this->listRows)->order($order)->select();
	
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
		//return M($this->meditation)->where($where)->field($field)->limit($limit)->order($order)->select();
		$list = Db::name($this->meditation)->where($where)->field($field)->select();
	
		$resData = [
	        'list' => $list
		];

		return $resData;
	}


	/*
	* 添加
	* @post:
	**/
	public function add($data) {
		$data['create_time'] = date("Y-m-d H:i:s");
		$data['update_time'] = date("Y-m-d H:i:s");
		// 添加单条数据
		$res = db('meditation')->insertGetId($data);
		//echo MeditationModel::getLastSql();
		return $res;
	}

	/*
	* 编辑
	* @post:
	**/
	public function edit($where, $data) {
		// 更新单条数据
		$res = Db::name($this->meditation)->where($where)->data($data)->update();
		//echo MeditationModel::getLastSql();
		return $res;
	}
	
	/*
	* 删除
	* @post:
	**/
	public function del($where) {
		// 更新单条数据
		$res = Db::name($this->meditation)->where($where)->delete();
		//echo MeditationModel::getLastSql();
		return $res;
	}
}