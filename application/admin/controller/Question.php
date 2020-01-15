<?php
namespace app\admin\controller;
use app\admin\model\QuestionModel;
use think\Db;
class Question
{
    //列表
    public function query()
    {
        $data = input('param.');
        $queryParam = $data['condition'];
        $where = array_filter($queryParam);
        $pageNumber = $data['pageNumber'] ? $data['pageNumber'] : '1';
        $type = new QuestionModel();
		// 查询数据集
		$res = $type->getList($where, $pageNumber);
		return format_return_data($res);
    }

    //列表
    public function queryChooseAll()
    {
        $data = input('param.');
        $queryParam = $data['condition'];
        $postData = array_filter($queryParam);
        $type = new QuestionModel();
        $where = 'question_type_id = '.$postData['question_type_id'];
        $where .= ' and id in ('.implode(',', $postData['question_no']).')';
        // 查询数据集
        $res = $type->getAllList($where);
        return format_return_data($res);
    }

    //添加
    public function add()
    {
        $data = input('param.');
        $type = new QuestionModel();
        // 查询数据集
        $res = $type->add($data);

        return format_return_data();
    }

    //修改
    public function edit()
    {
        $data = input('param.');
        if(!$data['id']){
            return format_return_data('', 'error');
        }

        $type = new QuestionModel();
        // 查询数据集
        $res = $type->edit('id = '.$data['id'], $data);

        return format_return_data();
    }

    //删除
    public function del()
    {
        $data = input('param.');
        if(!$data['id']){
            return format_return_data('', 'error');
        }

        $type = new QuestionModel();
        // 查询数据集
        $res = $type->del('id = '.$data['id']);

        return format_return_data();
    }

    //批量录入数据
    public function moreaddanswer($index)
    {
        //读取源数据
        $sqlstr = "SELECT q.id as qid, q.question_type_id as q_question_type_id, q.title as q_title, q3.question_type_id as q3_q_question_type_id, q3.title as q3_title, q3.title as q3_title,

            q3.problem_option_a_score as q3_a_score, 
            q3.problem_option_a_title as q3_a_title,
            q3.problem_option_b_score as q3_b_score,
            q3.problem_option_b_title as q3_b_title,
            q3.problem_option_c_score as q3_c_score,
            q3.problem_option_c_title as q3_c_title,
            q3.problem_option_d_score as q3_d_score,
            q3.problem_option_d_title as q3_d_title,
            q3.problem_option_e_score as q3_e_score,
            q3.problem_option_e_title as q3_e_title,
            q3.problem_option_f_score as q3_f_score,
            q3.problem_option_f_title as q3_f_title,
            q3.problem_option_g_score as q3_g_score,
            q3.problem_option_g_title as q3_g_title

        FROM `zx_question_3` `q3` INNER JOIN `zx_question` `q` ON `q`.`title`=`q3`.`title` WHERE ( q.question_type_id = ".$index." )";
        echo $sqlstr.'<br />';

        $res = Db::query($sqlstr);

        
      
        //根据题目匹配批量插入答案表
        foreach ($res as $key => $value) {
            $qsid = $value['qid'];
            if ($value['q3_a_title']) {
                //echo 'A '.$value['q3_a_title'].'<br />';

                $data = [
                    'question_type_id' => $value['q_question_type_id'],
                    'question_id' => $value['qid'],
                    'num' => 'A',
                    'title' => $value['q3_a_title'],
                    'score' => $value['q3_a_score'],
                ];
                Db::name('answer')->insert($data);
            }

            if ($value['q3_b_title']) {
               $data = [
                    'question_type_id' => $value['q_question_type_id'],
                    'question_id' => $value['qid'],
                    'num' => 'B',
                    'title' => $value['q3_b_title'],
                    'score' => $value['q3_b_score'],
                ];
                Db::name('answer')->insert($data);
            }

            if ($value['q3_c_title']) {
               $data = [
                    'question_type_id' => $value['q_question_type_id'],
                    'question_id' => $value['qid'],
                    'num' => 'C',
                    'title' => $value['q3_c_title'],
                    'score' => $value['q3_c_score'],
                ];
                Db::name('answer')->insert($data);
            }

            if ($value['q3_d_title']) {
               $data = [
                    'question_type_id' => $value['q_question_type_id'],
                    'question_id' => $value['qid'],
                    'num' => 'D',
                    'title' => $value['q3_d_title'],
                    'score' => $value['q3_d_score'],
                ];
                Db::name('answer')->insert($data);
            }

            if ($value['q3_e_title']) {
               $data = [
                    'question_type_id' => $value['q_question_type_id'],
                    'question_id' => $value['qid'],
                    'num' => 'E',
                    'title' => $value['q3_e_title'],
                    'score' => $value['q3_e_score'],
                ];
                Db::name('answer')->insert($data);
            }

            if ($value['q3_f_title']) {
               $data = [
                    'question_type_id' => $value['q_question_type_id'],
                    'question_id' => $value['qid'],
                    'num' => 'F',
                    'title' => $value['q3_f_title'],
                    'score' => $value['q3_f_score'],
                ];
                Db::name('answer')->insert($data);
            }

            if ($value['q3_g_title']) {
               $data = [
                    'question_type_id' => $value['q_question_type_id'],
                    'question_id' => $value['qid'],
                    'num' => 'G',
                    'title' => $value['q3_g_title'],
                    'score' => $value['q3_g_score'],
                ];
                Db::name('answer')->insert($data);
            }

            // $data = [
            //     'question_type_id' => $value['q_question_type_id'],
            //     'question_id' => $value['qid'],
            //     'num' => '',
            //     'score' => '',
            //     'title' => '',
            // ]
            // db('answer')->insert($data);
        }
    }

 public function batchchange()
 {

    for ($i=2; $i < 13; $i++) { 
       $this->moreaddanswer($i);
    }
 }



}
