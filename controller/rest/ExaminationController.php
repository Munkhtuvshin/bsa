<?php
require_once ROOT . '/model/exam/Examination.php';

class ExaminationController {
    
    public function index() {
        switch($_SERVER['REQUEST_METHOD']) {
            case 'POST': $this->add(); break;
            case 'PUT': $this->edit(); break;
            case 'DELETE': $this->remove(); break;
        }
    }
    private function add() {
        $result = new stdClass();
        $request_body = file_get_contents('php://input');
        if($request_body) {
            $model = new Question();
            $question = json_decode($request_body);
            $result->result = $model->add($question);
        }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    private function remove() {
        $result = new stdClass();
        $request_body = file_get_contents('php://input');
        if($request_body) {
            $model = new Question();
            $question = json_decode($request_body);
            $result->result = $model->remove($question->id);
        }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    private function edit() {
        $result = new stdClass();
        $request_body = file_get_contents('php://input');
        if($request_body) {
            $model = new Question();
            $question = json_decode($request_body);
            $result->result = $model->edit($question->id, $question);
        }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    private function generate($data){
        if ($data->date_type == 2) {
            $data->end_time = null;
            $data->start_time = null;
        }
        DB::transaction(function () use (&$requestData, &$exam) {
            $exam = $this->examModel->create($requestData);
            //Шалгалтын сэдвүүд, түвшин үүсгэлт(автоматаар асуулт онооход)
            if (isset($data->examLevels) && $data->question_pick_type == 2) {
                $examTopics = array();
                $examLevels = $data->examLevels;
                foreach ($examLevels as $examLevel) {
                    if (!in_array($examLevel->exam_topic_id, $examTopics))
                        array_push($examTopics, $examLevel->exam_topic_id);
                }
                for ($i = 0; $i < sizeof($examTopics); $i++) {
                    $examTopic = $this->examTopicModel->create(["topic_id" => $examTopics[$i], "exam_id" => $exam->id]);
                    foreach ($examLevels as $examLevel) {
                        if ($examLevel->exam_topic_id == $examTopics[$i]) {
                            $level = $this->examLevelModel->create(["exam_topic_id" => $examTopic->id,
                                "question_level_id" => $examLevel->question_level_id,
                                "point" => $examLevel->point,
                                "question_count" => $examLevel->question_count,
                                "answer_type_id" => $examLevel->answer_type_id]);
                        }
                    }
                }
                //Хувилбар ба түүний асуулт үүсгэх
                if (isset($data->variant)) {
                    for ($j = 0; $j < $data->variant; $j++) {
                        $variant = $this->variantModel->create(["exam_id" => $exam->id,
                            "name" => $j,
                            "total_point" => $data->total_point,
                            "max_point" => $data->max_point,
                            "created_user_id" => Auth::id(),
                            "updated_user_id" => Auth::id()]);
                        $examLevels = $data->examLevels;
                        foreach ($examLevels as $examLevel) {
                            $questions = $this->questionModel->where('topic_id', '=', $examLevel->exam_topic_id)
                                ->where('level_id', '=', $examLevel->question_level_id)
                                ->where('type_id', '=', $examLevel->answer_type_id)
                                ->whereNull('parent_id')
                                ->inRandomOrder()->limit($examLevel->question_count)->get();
                            if ($questions->count() < $examLevel->question_count)
                                throw new NotFoundException('Questions are not enough.');
                            foreach ($questions as $question) {
                                $question->variant_id = $variant->id;
                                $question->question_id = $question->id;
                                $question->point = $examLevel->point;
                                $question->exam_id = $exam->id;
                                $exam_p = $this->examQuestionModel->create(json_decode(json_encode($question), true));
                                if ($question->type_id == 7) {
                                    $questions_parent = $this->questionModel->where('parent_id', '=', $exam_p->question_id)->get();
                                    foreach ($questions_parent as $question_p) {
                                        $question_p->variant_id = $variant->id;
                                        $question_p->question_id = $question_p->id;
                                        $question_p->parent_id = $exam_p->id;
                                        $question_p->point = $examLevel->point / $questions_parent->count();
                                        $question_p->exam_id = $exam->id;
                                        $this->examQuestionModel->create(json_decode(json_encode($question_p), true));
                                    }
                                }
                            }
                        }
                    }
                }
            }

            //Гар аргаар асуулт оноосон бол
            if (isset($data->variants) && $data->question_pick_type == 1) {
                $variants = $data->variants;
                $j = 0;
                foreach ($variants as $variant) {
                    $questions = $variant['questions'];
                    $variant = $this->variantModel->create(["exam_id" => $exam->id,
                        "name" => $j,
                        "created_user_id" => Auth::id(),
                        "updated_user_id" => Auth::id()]);
                    $j++;
                    $contained_questions = [0];
                    foreach ($questions as $q) {
                        if (isset($q['id'])) $question = $this->questionModel->find($q['id']);
                        else {
                            $question = $this->questionModel->where('type_id', '=', $q['type_id'])
                                ->where('level_id', '=', $q['level_id'])
                                ->where('topic_id', '=', $q['topic_id'])
                                ->whereNull('parent_id')
                                ->whereNotIn('id', $contained_questions)
                                ->inRandomOrder()->first();
                            if (!$question) {
                                $question = $this->questionModel->where('type_id', '=', $q['type_id'])
                                    ->where('topic_id', '=', $q['topic_id'])
                                    ->whereNotIn('id', $contained_questions)
                                    ->whereNull('parent_id')
                                    ->inRandomOrder()->first();

                                if (!$question) {
                                    $question = $this->questionModel->where('type_id', '<>', 7)
                                        ->whereNull('parent_id')
                                        ->whereNotIn('id', $contained_questions)
                                        ->inRandomOrder()->first();
                                    if (!$question)
                                        return $this->response->errorNotFound('Could not find any question');
                                }
                            }
                        }
                        $contained_questions[] = $question->id;
                        $question->point = $q['point'];
                        $question->variant_id = $variant->id;
                        $question->question_id = $question->id;
                        $question->exam_id = $exam->id;
                        $exam_p = $this->examQuestionModel->create(json_decode(json_encode($question), true));
                        if ($question->type_id == 7) {
                            $questions_parent = $this->questionModel->where('parent_id', '=', $exam_p->question_id)->get();
                            foreach ($questions_parent as $question_p) {
                                $question_p->variant_id = $variant->id;
                                $question_p->question_id = $question_p->id;
                                $question_p->parent_id = $exam_p->id;
                                $question_p->point = $q['point'] / $questions_parent->count();
                                $question_p->exam_id = $exam->id;
                                $this->examQuestionModel->create(json_decode(json_encode($question_p), true));
                            }
                        }
                    }
                }
            }

            //Аль аль ангид орохыг үүсгэнэ
            $labels = $data->labels;
            foreach ($labels as $label) {
                $this->examLabelModel->create(['exam_id' => $exam->id, 'label' => $label]);
            }
        });
        return $exam;
    }
}