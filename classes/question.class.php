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
            $query = $con->query("SELECT * FROM questions WHERE questions_id=".$question_id);
            $query->setFetchMode(PDO::FETCH_OBJ);
            $f = $query->fetch();
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
}