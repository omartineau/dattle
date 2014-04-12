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
    public $cities_lat = 0;
    public $cities_long = 0;



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
            $this->cities_population = (int)$f->cities_population;
            $this->cities_win_score  = (int)$f->cities_win_score;
            $this->users_id          = (int)$f->users_id;
            $this->cities_win_dt     = $f->cities_win_dt;
            $this->cities_lat        = (float)$f->cities_lat;
            $this->cities_long       = (float)$f->cities_long;

            // capture date, DateInterval type
            $this->cities_win_dt2    = ($this->cities_win_dt != null)
                                     ? new DateTime($this->cities_win_dt)
                                     : new DateTime("now");
            // capture date from now, DateInterval type
            $now = new DateTime("now");
            $this->cities_win_dt2_iv = $now->diff($this->cities_win_dt2);
            $this->cities_win_dt2  = "";
            if ($this->cities_win_dt2_iv->d > 0)
                $this->cities_win_dt2 .= $this->cities_win_dt2_iv->d . 'j ';
            if ($this->cities_win_dt2_iv->h > 0)
                $this->cities_win_dt2 .= $this->cities_win_dt2_iv->h . 'h ';
            $this->cities_win_dt2 .= $this->cities_win_dt2_iv->i . 'm ';
            //var_dump($this->cities_win_dt2_iv);
        }

    }

    function capturedBy($users_id, $points)
    {
        global $con;
        $query = $con->prepare("UPDATE cities SET
            users_id = :users_id,
            cities_win_score = :cities_win_score,
            cities_win_dt = NOW()
            WHERE cities_id = :cities_id");
        $query->bindParam(':users_id', $users_id, PDO::PARAM_INT);
        $query->bindParam(':cities_win_score', $points, PDO::PARAM_INT);
    }


    // return cities for an user
    static function getUserCitiesId($users_id, $limit = 100)
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

    // return all cities
    static function getAllCities($limit = 100)
    {
        global $con;

        $query = $con->prepare("SELECT cities_id FROM cities ORDER BY cities_id LIMIT :limit");
        $query->bindParam(':limit', $limit, PDO::PARAM_INT);

        $query->execute();
        $citiesList = array();
        while ($f = $query->fetch(PDO::FETCH_OBJ)) {
            $citiesList[] = new City($f->cities_id);
        }
        return $citiesList;
    }



}