<?php

class User
{
    public $logged = false; // true if user logged
    public $users_id = 0;
    public $users_email;
    public $users_pseudo;
    public $users_round_avail  = 0;
    public $users_round_played = 0;


    function __construct($users_id)
    {
        global $con;

        $query = $con->prepare('SELECT * FROM users WHERE users_email = :users_email');
        $query->execute(array(
            'users_email'       => $this->users_email
        ));
        if ($f = $query->fetch(PDO::FETCH_OBJ))
        {
            $this->users_id           = $f->users_id;
            $this->users_pseudo       = $f->users_pseudo;
            $this->users_round_avail  = (int)$f->users_round_avail;
            $this->users_round_played = (int)$f->users_round_played;
        }
    }

    // Auth an user
    function Auth($email, $password)
    {
        global $con;
        $this->users_email = $email;

        $query = $con->prepare('SELECT * FROM users WHERE users_email = :users_email and users_password = :users_password');
        $query->execute(array(
            'users_email'       => $this->users_email,
            'users_password'    => sha1($password)
        ));
        if ($f = $query->fetch(PDO::FETCH_OBJ))
        {
            $this->users_id           = $f->users_id;
            $this->users_pseudo       = $f->users_pseudo;
            $this->users_round_avail  = (int)$f->users_round_avail;
            $this->users_round_played = (int)$f->users_round_played;

            $this->logged = true;
        }
        else
        {
            $this->logged = false;
        }
    }

    // add an user into DB and log him
    function Create($email, $password, $pseudo)
    {
        global $con;

        $this->users_email  = $email;
        $this->users_pseudo = $pseudo;

        $query = $con->prepare('SELECT COUNT(*) as nb FROM users WHERE users_email = :users_email');
        $query->execute(array(
            'users_email'    => $this->users_email
        ));
        $f = $query->fetch(PDO::FETCH_OBJ);

        // email already exists
        if ($f->nb > 0)
        {
            return;
        }

        $query = $con->prepare('INSERT INTO USERS (users_email, users_password, users_pseudo)
            VALUES (:users_email, :users_password, :users_pseudo)');
        $query->execute(array(
            'users_email'    => $this->users_email,
            'users_password' => sha1($password),
            'users_pseudo'   => $this->users_pseudo
        ));

        // log user
        $this->logged = true;
    }

    // delete an user into DB
    function Delete($email, $password)
    {
        global $con;
        $this->logged = false;

        $query = $con->prepare('DELETE FROM USERS WHERE users_email = :users_email and users_password = :users_password');
        $query->execute(array(
            'users_email'    => $email,
            'users_password' => sha1($password)
        ));
    }

    // TODO : resent pwd

}












