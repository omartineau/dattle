<?php

class User
{
    public $logged = false; // true if user logged
    public $users_id;
    public $users_email;
    public $users_pseudo;
    public $users_round_avail  = 0;
    public $users_round_played = 0;

    function __construct()
    {

    }

    function Auth($email, $password)
    {
        global $con;
        $pwd_sha1 = sha1($password);

        $query = $con->prepare('SELECT * FROM users WHERE users_email = :users_email and users_password = :users_password');
        $query->execute(array(
            'users_email'       => $email,
            'users_password'    => $pwd_sha1
        ));
        if ($f = $query->fetch(PDO::FETCH_OBJ))
        {
            $this->users_id           = $f->users_id;
            $this->users_email        = $f->users_email;
            $this->users_pseudo       = $f->users_pseudo;
            $this->users_round_avail  = (int)$f->users_round_avail;
            $this->users_round_played = (int)$f->users_round_played;

            $this->logged = true;
        }
    }

    // add an user into DB
    // user logged if OK
    function Create($email, $password, $pseudo)
    {
        global $con;
        $pwd_sha1 = sha1($password);

        $query = $con->prepare('SELECT COUNT(*) as nb FROM users WHERE users_email = :users_email');
        $f = $query->fetch(PDO::FETCH_OBJ);

        if ($f->nb > 0)
        {
            // email already exists
            $this->logged = false;
            return null;
        }

        $query = $con->prepare('INSERT INTO USERS (users_email, users_password, users_pseudo)
            VALUES (:users_email, :users_password, :users_pseudo)');
        $query->execute(array(
            'users_email'    => $email,
            'users_password' => $pwd_sha1,
            'users_pseudo'   => $pseudo
        ));

        // log user
        $this->Auth($email, $password);
    }

}


























