<?php
class Question
{

    public $questions_id;
    public $questions_text;
    public $questions_type;
    public $questions_resp_1;
    public $questions_resp_2;
    public $questions_resp_3;
    public $questions_resp_good;
    public $cities_id;
    public $questions_datasource;

    function __construct($question_id=false)
    {
        global $con;
        if ($question_id) {

            $query = $con->prepare('SELECT * FROM questions WHERE questions_id=:question_id;');
            $query->execute(array('question_id'=>$question_id));

            $f = $query->fetch(PDO::FETCH_OBJ);
            $this->questions_id = $f->questions_id;
            $this->questions_text = $f->questions_text;
            $this->questions_type = $f->questions_type;
            $this->questions_resp_1 = $f->questions_resp_1;
            $this->questions_resp_2= $f->questions_resp_2;
            $this->questions_resp_3 = $f->questions_resp_3;
            $this->questions_resp_good = $f->questions_resp_good;
            $this->cities_id = $f->cities_id;
            $this->questions_datasource = $f->questions_datasource;
        }

    }
    function insert() {


    }
    static function getQuestions($cities_id,$question_numb) {
        global $con;
        $query = $con->prepare("SELECT questions_id FROM questions WHERE cities_id=:cities_id ORDER BY RAND() LIMIT :question_numb ");
        $query->bindParam(':cities_id', $cities_id);
        $query->bindParam(':question_numb', $question_numb, PDO::PARAM_INT);
        $query->execute();
        $questionsList = array();
        while ($f = $query->fetch(PDO::FETCH_OBJ)) {
            $questionsList[] = $f->questions_id;
        }
        return $questionsList;
    }
}