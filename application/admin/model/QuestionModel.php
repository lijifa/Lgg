<?php
namespace app\admin\model;

use think\Model;
use think\Db;

class QuestionModel extends Model
{
	function __construct(){
		$this->question	= "question";
		$this->listRows = config('paginate.list_rows');
	}
	
	/*
	* 获取列表
	* @post:
	**/
	public function getList($where, $pagenum=1, $order='question_no asc') {

		$count = Db::name($this->question)->where($where)->count();
		
		$list = Db::name($this->question)->where($where)->page($pagenum.','.$this->listRows)->order($order)->select();

		foreach($list as $key=>$item){
		    $qm = QuestionType::get($item['question_type_id']);
			$list[$key]['typename'] = $qm->typename;
		}
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
		$res = db('question')->insert($data);
		//echo QuestionModel::getLastSql();
		return $res;
	}

	/*
	* 编辑
	* @post:
	**/
	public function edit($where, $data) {
		// 更新单条数据
		$res = Db::name($this->question)->where($where)->data($data)->update();
		//echo QuestionModel::getLastSql();
		return $res;
	}
	
	/*
	* 删除
	* @post:
	**/
	public function del($where) {
		// 更新单条数据
		$res = Db::name($this->question)->where($where)->delete();
		//echo QuestionModel::getLastSql();
		return $res;
	}
}