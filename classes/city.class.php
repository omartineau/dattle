<?php
class City
{

    public $cities_id;
    public $cities_name;
    public $cities_class;
    public $cities_canton;
    public $cities_kml;
    public $cities_polulation;
    public $cities_win_score;
    public $users_id;
    public $cities_win_dt;



    function __construct($cities_id=false)
    {
        global $con;
        if ($cities_id) {

            $query = $con->prepare('SELECT * FROM cities WHERE cities_id=:cities_id;');
            $query->execute(array('cities_id'=>$cities_id));

            $f = $query->fetch(PDO::FETCH_OBJ);
            $this->cities_id = $f->cities_id;
            $this->cities_name = $f->cities_name;
            $this->cities_class = $f->cities_class;
            $this->cities_canton = $f->cities_canton;
            $this->cities_kml = $f->cities_kml;
            $this->cities_polulation = $f->cities_polulation;
            $this->cities_win_score = $f->cities_win_score;
            $this->users_id = $f->users_id;
            $this->cities_win_dt = $f->cities_win_dt;

        }

    }

}