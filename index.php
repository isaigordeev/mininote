<?php
global $dbh;
session_start();

require('utils.php');
require('logInOut.php');
require ('connection.php');


if(array_key_exists('todo',$_GET) && $_GET['todo']=='signin'){
    SignUp($dbh);
    unset($_GET['todo']);
}

if(array_key_exists('todo',$_GET) && $_GET['todo']=='login'){
    logIn($dbh);
    unset($_GET['todo']);
}

if(array_key_exists('todo',$_GET) && $_GET['todo']=='logout'){
    logOut();
    unset($_GET['todo']);
}
 
$askedPage= "accueil";

if(array_key_exists('page',$_GET)){
    $askedPage = $_GET['page'];
}

if(!checkPage($askedPage)){
    $askedPage ='accueil';
}

$title = getPageTitle($askedPage);


generateHTMLHeader($title);

Menu();


if(key_exists("loggedIn", $_SESSION) && $_SESSION["loggedIn"]){
    account();
    require("content/client/$askedPage.php");
} else {
    $askedPage = "accueil";
    modalsignup($askedPage);
    modalconnexion($askedPage);

    require("content/guest/$askedPage.php");
}

$dbh = null;
?>
    


<?php
    generateHTMLFooter();
?>



 