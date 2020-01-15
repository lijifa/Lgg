<?php
namespace app\xcx\model;

use think\Model;
use think\Db;

class RuleModel extends Model
{
	function __construct(){
		$this->rule	= "rule";
		$this->result	= "result";
		$this->listRows = config('paginate.list_rows');
	}
	
	/*
	* 获取列表
	* @post:
	**/
	public function getList($where, $pagenum=1, $order='r.id desc') {
		$count = Db::name($this->rule)->where($where)->count();
		
		$list = Db::name($this->rule)
				->alias("r") //取一个别名
		      //与result表进行关联，取名c，并且r表的rule_id字段等于result表的rule_id字段
		      ->join('result c', 'r.id = c.rule_id')
		      ->where($where)
		      ->page($pagenum.','.$this->listRows)
		      ->order($order)
		      ->select();
	
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
	* 获取全部列表【根据条件】
	* @post:
	**/
	public function getAllList($where, $order='r.id desc') {
		$count = Db::name($this->rule)->where($where)->count();
		
		$list = Db::name($this->rule)
				->alias("r") //取一个别名
		      //与result表进行关联，取名c，并且r表的rule_id字段等于result表的rule_id字段
		      ->join('result c', 'r.id = c.rule_id')
		      ->field('r.*, c.id as cid, c.rule_id, c.audio_path, c.content_1, c.content_2, c.content_3')
		      ->where($where)
		      ->order($order)
		      ->select();
	
		$resData = [
			'totalRow' => $count,
	        'list' => $list
		];

		return $resData;
	}

	/*
	* 获取单条数据
	* @post:
	**/
	public function getAnswer($where, $pagenum=1, $order='r.id desc') {


		//先要找到是那个分类的题目
		//哪个总分or 分项
		
		$count = Db::name($this->rule)->where($where)->count();
		
		$list = Db::name($this->rule)
				->alias("r") //取一个别名
		      //与result表进行关联，取名c，并且r表的rule_id字段等于result表的rule_id字段
		      ->join('result c', 'r.id = c.rule_id')
		      ->where($where)
		      ->page($pagenum.','.$this->listRows)
		      ->order($order)
		      ->select();
	
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
	public function add($ruleData, $resultData) {
		// 添加返回内容
		$res_1 = db($this->rule)->insertGetId($ruleData);
		$res_2 = false;
		if($res_1) {
			$resultData['rule_id'] = $res_1;
			// 添加规则数据
			$res_2 = db($this->result)->insertGetId($resultData);
		}

		//echo RuleModel::getLastSql();
		return $res_2;
	}

	/*
	* 编辑
	* @post:
	**/
	public function edit($where, $data) {
		// 更新单条数据
		$res = Db::name($this->rule)->where($where)->data($data)->update();
		//echo RuleModel::getLastSql();
		return $res;
	}
	
	/*
	* 删除
	* @post:
	**/
	public function del($where) {
		// 更新单条数据
		$res = Db::name($this->rule)->where($where)->delete();
		//echo RuleModel::getLastSql();
		return $res;
	}
}