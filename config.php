<?php

    /*
        ini_set('display_errors', 0);
        ini_set('display_startup_errors', 0);
        error_reporting(E_ALL);
    */
    
    try {
        if (version_compare(phpversion(), '5.4.0', '<')) {
        if(session_id() == '') {
            session_start();
        }
        }
        else {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
        }        
    }catch(Exception $err){}


    $UPLOAD_ONLINEPATH = "http://geocarsapp.000webhostapp.com/";

    $HOST = "localhost";
    $USER = "andydevs69420";
    $PASS = "andy404";
    $DB   = "geocarsDB";
    

    if (!isset($CONN)) { 

        $CONN = new mysqli(
            $HOST , 
            $USER ,
            $PASS ,
            $DB
        );

        if ($CONN->connect_error)
            die("ConnectionError: " . $CONN->error);
    }
    
?>