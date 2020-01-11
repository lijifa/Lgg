<?php
namespace app\admin\controller;
use app\admin\model\RuleModel;

class Rule
{
    //列表
    public function query()
    {
        $data = input('param.');
        $queryParam = $data['condition'];
        $where = array_filter($queryParam);
        $pageNumber = $data['pageNumber'] ? $data['pageNumber'] : '1';
        $type = new RuleModel();
		// 查询数据集
		$res = $type->getList($where, $pageNumber);
		return format_return_data($res);
    }

        //添加
    public function add()
    {
        $data = input('param.');
        $resultData = [
            'score_type' => $data['score_type'],
            'audio_path' => $data['audio_path'],
            'content_1' => $data['content_1'],
            'content_2' => $data['content_2'],
            'content_3' => $data['content_3']
        ];

        //$score_range = explode('|', $data['score_range']);
        $ruleData = [
            'question_type_id'  => $data['question_type_id'],
            'rule_name'         => $data['rule_name'],
            'nums'              => $data['nums'],
            'score_type'        => $data['score_type'],
            'rule_str'          => $data['rule_str'],
            'min_score'         => 0,   //$score_range['0'],
            'max_score'         => 0    //$score_range['1'],
        ];

        $type = new RuleModel();
        // 查询数据集
        $res = $type->add($ruleData, $resultData);

        return format_return_data();
    }

    public function uploadFiles(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        
        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                // 成功上传后 获取上传信息
                // 输出 jpg
                //echo $info->getExtension();
                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                $filePath = $info->getSaveName();
                // 输出 42a79759f284b767dfcb2a0197904287.jpg
                //echo $info->getFilename(); 
                return format_return_data($filePath);
            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }
    }

    //修改
    public function edit()
    {
        $data = input('param.');
        if(!$data['id']){
            return format_return_data('', 'error');
        }

        $resultData = [
            'score_type' => $data['score_type'],
            'audio_path' => $data['audio_path'],
            'content_1' => $data['content_1'],
            'content_2' => $data['content_2'],
            'content_3' => $data['content_3']
        ];

        //$score_range = explode('|', $data['score_range']);
        $ruleData = [
            'id'                => $data['id'],
            'question_type_id'  => $data['question_type_id'],
            'rule_name'         => $data['rule_name'],
            'nums'              => $data['nums'],
            'qs_no'             => $data['qs_no'],
            'score_type'        => $data['score_type'],
            'rule_str'          => $data['rule_str'],
            'min_score'         => 0,   //$score_range['0'],
            'max_score'         => 0    //$score_range['1'],
        ];

        $type = new RuleModel();
        // 查询数据集
        $res = $type->edit('id = '.$data['id'], $ruleData, $resultData);

        return format_return_data();
    }

    //删除
    public function del()
    {
        $data = input('param.');
        if(!$data['id']){
            return format_return_data('', 'error');
        }

        $type = new RuleModel();
        // 查询数据集
        $res = $type->del($data['id']);

        return format_return_data();
    }
}
