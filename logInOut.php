<?php
require ("query.php");


function SignUp($dbh){
    // print($_SESSION['loggedIn']);

    if(isset($_POST["login"]) && $_POST["login"] != "" && isset($_POST["psw"]) && $_POST["psw"] != "" && isset($_POST["psw2"]) && isset($_POST["name"])) {
//        require('../TD3/query.php');
//            require('query.php');



        $pass = $_POST["psw"];
        $pass_confirmation = $_POST["psw2"];

        if($pass && $pass_confirmation && $pass == $pass_confirmation) {
            $login = $_POST["login"];
            $name = $_POST["name"];
            $_SESSION["login"] = $login;

//            print_r($pass);

//        $logged = MininoteUser::checkPass($dbh, $login, $pass);
            MininoteUser::insertUser($dbh, $login, $pass, $name);
            $user  = MininoteUser::getUser($dbh, $login);

            if (!($user == null)) {
                $_SESSION['loggedIn'] = true;
            }
        }

    }

}
function logIn($dbh){
    // print($_SESSION['loggedIn']);

        if(isset($_POST["login"]) && $_POST["login"] != "" && isset($_POST["psw"])) {
//        require('../TD3/query.php');
//            require('query.php');

            $login = $_POST["login"];
            $pass = $_POST["psw"];

            $_SESSION["login"] = $login;

//            print_r($pass);

//        $logged = MininoteUser::checkPass($dbh, $login, $pass);
            $user = MininoteUser::getUser($dbh,$login);
            $mdp = MininoteUser::checkPass($dbh, $login, $pass);
//        print_r($logged);

            if(!($user == null) && $mdp) {
                $_SESSION['loggedIn'] = true;
            }

        }

}

function logOut(){
    $_SESSION['loggedIn'] = false;
//    unset($_SESSION['loggedIn']);
    $_SESSION = array();
    session_destroy();

}



?>