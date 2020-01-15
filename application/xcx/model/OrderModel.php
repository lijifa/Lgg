<?php
namespace app\xcx\model;

use think\Model;
use think\Db;

class OrderModel extends Model
{
	function __construct(){
		$this->order	= "order";
		$this->result	= "result";
		$this->listRows = config('paginate.list_rows');
	}
	
	/*
	* 获取列表
	* @post:
	**/
	public function getList($where, $pagenum=1, $order='num asc') {
		$count = Db::name($this->order)->where($where)->count();
		
		$list = Db::name($this->order)->where($where)->page($pagenum.','.$this->listRows)->order($order)->select();
	
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
	public function addOrder($data) {
		// 获取规则列表中的数据


		// 生成订单
		$res = db('order')->insert($data);
		return $res;
	}
	

	/*
	* 添加
	* @post:
	**/
	public function add($data) {
		$data['create_time'] = date("Y-m-d H:i:s");
		// 添加单条数据
		$res = db('order')->insertGetId($data);
		//echo OrderModel::getLastSql();
		return $res;
	}

	/*
	* 编辑
	* @post:
	**/
	public function edit($where, $data) {
		// 更新单条数据
		$res = Db::name($this->order)->where($where)->data($data)->update();
		//echo OrderModel::getLastSql();
		return $res;
	}

	/*
	* 获取订单详情
	* @post:
	**/
	public function detail($where) {
		// 获取单条数据
		$order_res = Db::name($this->order)->where($where)->find();

		// 获取返回内容
		$res = Db::name($this->result)->where('rule_id', 'in', $order_res['result_ids'])->order('score_type')->select();

		$order_res['result'] = $res;
		return $order_res;
	}
	
	/*
	* 删除
	* @post:
	**/
	public function del($where) {
		// 更新单条数据
		$res = Db::name($this->order)->where($where)->delete();
		//echo OrderModel::getLastSql();
		return $res;
	}
}