<?php require('printForms.php');
function generateHTMLHeader($title){
    echo<<<CHAINE_DE_FIN
    <!DOCTYPE html>
    <html>
 
    <head>
    <title>$title</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/perso.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Shadows+Into+light' rel='stylesheet' type='text/css'>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/codemirror.css">

    
    </head>
    <body>
CHAINE_DE_FIN;
}

$pageListOut = array(
    array(
        'name' => 'accueil',
        'title' => 'Accueil site',
        'menutitle' => 'Accueil'
    ),
    array(
        'name' => 'editor',
        'title' => 'Editor',
        'menutitle' => 'Editor'
    ),
);

$pageListIn = array(
    array(
        'name' => 'accueil',
        'title' => 'Accueil site',
        'menutitle' => 'Accueil'
    ),
    array(
        'name' => 'editor',
        'title' => 'Editor',
        'menutitle' => 'Editor'
    ),
    array(
        'name' => 'signup',
        'title' => 'Inscription'
    ),
    array(
        'name' => 'compte',
        'title' => 'Compte'
    )
);

function Menu(){
    global $pageListIn;
    echo<<<FIB
    <div class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
        <a class="navbar-brand" href="index.php?page=accueil">Mininote</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto ">
FIB;
    if(array_key_exists('loggedIn', $_SESSION) && $_SESSION['loggedIn']){
    foreach($pageListIn as $page){
        if(array_key_exists('menutitle',$page)){

            if($page['name'] == "editor"){
                echo"
        <li class='nav-item active'>
        <a class='nav-link' href='index.php?page={$page['name']}'>{$page['menutitle']} </a>
                </li>";
            } else {
                echo "
        <li class='nav-item active'>
        <a class='nav-link' href='index.php?page={$page['name']}'>{$page['menutitle']} </a>
                </li>";
            }
        }
    }}

//    foreach($pageList as $page){
//        if(array_key_exists('menutitle',$page)){
//        echo"
//            <li class='nav-item active'>
//            <a class='nav-link' href='index.php?page={$page['name']}'>{$page['menutitle']} </a>
//                    </li>";
//    }
//}

   echo'</ul>';
               
  if(array_key_exists('loggedIn',$_SESSION) && $_SESSION['loggedIn']){
    Deconnexion();
    }  else{
    Connexion();
    }
echo "FIB                    
    </div>
    </nav></div> ";
 }



function generateHTMLFooter(){
    echo <<<CHAINE
    
    </body>

    
    <script src="js/jquery.min.js"></script>
    <script src="js/codemirror.js"></script>
    
    <script src="js/code.js"></script>
    <link rel='stylesheet' href='fullcalendar/fullcalendar.css' />
    <script src='fullcalendar/lib/moment.min.js'></script>
    <script src='fullcalendar/fullcalendar.js'></script>
    
    <script src="create_session.js"></script>
    
    <script src="content/client/navigation_handler.js"></script>
    <script src="event_handlers_general.js"></script>
    <script src="events_handlers_core.js"></script>
    <script src="event_click_delete_notes.js"></script>
    <script src="event_click_delete_account.js"></script>
    <script src="event_click_make_all_notes_public.js"></script>
    <script src="event_click_make_all_notes_private.js"></script>
    
    </html>

    CHAINE;
    }


function CheckPage($askedPage) {
    global $pageListIn;
    foreach($pageListIn as $page) {
      if( $page["name"] == $askedPage ) {
        return true;}
    }
    return false;
  }

function getPageTitle($page_name){
    global $pageListIn;
    foreach( $pageListIn as $page ) {
      if( $page["name"] == $page_name ) {
        return $page["title"];
      }
    }
    return "erreur";
}  
?>