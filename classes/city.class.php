<?php
class City
{

    public $cities_id;
    public $cities_name;
    public $cities_class;
    public $cities_canton;
    public $cities_kml;
    public $cities_polulation = 0;
    public $cities_win_score = 0;
    public $users_id = 0;
    public $cities_win_dt = 0;
    public $cities_win_dt2;



    function __construct($cities_id=false)
    {
        global $con;
        if ($cities_id) {

            $query = $con->prepare('SELECT * FROM cities WHERE cities_id=:cities_id;');
            $query->execute(array('cities_id'=>$cities_id));

            $f = $query->fetch(PDO::FETCH_OBJ);
            $this->cities_id         = $f->cities_id;
            $this->cities_name       = $f->cities_name;
            $this->cities_class      = $f->cities_class;
            $this->cities_canton     = $f->cities_canton;
            $this->cities_kml        = $f->cities_kml;
            $this->cities_polulation = (int)$f->cities_polulation;
            $this->cities_win_score  = (int)$f->cities_win_score;
            $this->users_id          = (int)$f->users_id;
            $this->cities_win_dt     = (int)$f->cities_win_dt;

            // capture date, DateInterval type
            $this->cities_win_dt2    = new DateTime($this->cities_win_dt);
            // capture date from now, DateInterval type
            $now = new DateTime("now");
            $this->cities_win_dt2_iv = $now->diff($this->cities_win_dt2);
            $this->cities_win_dt2  = "";
            if ($this->cities_win_dt2_iv->d > 0)
                $this->cities_win_dt2 .= $this->cities_win_dt2_iv->d . 'j ';
            $this->cities_win_dt2 .= $this->cities_win_dt2_iv->h . 'h ';
            $this->cities_win_dt2 .= $this->cities_win_dt2_iv->i . 'm ';
            //var_dump($this->cities_win_dt2_iv);
        }

    }

    // return cities for an user
    static function getUserCities($users_id, $limit = 1000)
    {
        global $con;

        $query = $con->prepare("SELECT cities_id FROM cities WHERE users_id = :users_id
            ORDER BY cities_population DESC LIMIT :limit");
        $query->bindParam(':users_id', $users_id, PDO::PARAM_INT);
        $query->bindParam(':limit', $limit, PDO::PARAM_INT);

        $query->execute();
        $citiesList = array();
        while ($f = $query->fetch(PDO::FETCH_OBJ)) {
            $citiesList[] = $f->cities_id;
        }
        return $citiesList;
    }



}