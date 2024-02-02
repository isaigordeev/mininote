<?php

function modalconnexion($askedPage){
    echo<<<AA
    

<div id='logindemo' class='modal Login'>
 <div class='modal-dialog modal-dialog-centered'>
  <div class='modal-content'>
   <div class='modal-body'>
    <button type='button' class='btn-close btn-close-white' data-bs-dismiss='modal'>
    </button>
    <div class='myform bg-dark'>
    <h1 class='text-center'>Connexion</h1>
    <form action='index.php?page=$askedPage&todo=login' method='POST'>
        <div class='form-group'>
        <label for='input_Login' class='col-sm-4 control-label'>Login</label>
            <div class='mr-sm-2'>
                  <input class='form-control' type='text' placeholder='Login' id='imput_login' name='login' require></div>
            </div> 
              <div class='form-group'>
              <label for='input_mdp' class='col-sm-4 control-label'>Mot de Passe</label>
              <div class='mr-sm-2'>
                <input class='form-control' type='password' placeholder='Mot de passe' id='input_mdp' name='psw'></div>
              </div> 
            <button type='submit' class='btn btn-light mt-3'>Connexion</button>
            <p>Vous n'avez pas de compte?<button class='btn1 btn-primary' type='button' data-bs-toggle='modal' data-bs-target='#signupdemo'>Signup</button></a></p>
        </form>
    </div>
   </div>
  </div>
 </div>
</div>

AA;
}

function modalsignup(){
    echo<<<AA
<div id='signupdemo' class='modal signup'>
 <div class='modal-dialog modal-dialog-centered'>
  <div class='modal-content'>
   <div class='modal-body'>
    <button type='button' class='btn-close btn-close-white' data-bs-dismiss='modal'>
    </button>
    <div class='myform bg-dark'>
    <h1 class='text-center'>Signup Form</h1>
    <form action='#'>
    <div>
        <label for='input_name' class='col-sm-4 control-label'>Name</label>
        <input class='form-control' type='text' placeholder='Name' id='input_name' name='Name' require> 
              </div>&nbsp;
              <div class='form-group'>
              <label for='input_Login' class='col-sm-4 control-label'>Login</label>
              <div class='mr-sm-2'>
                  <input class='form-control' type='text' placeholder='Login' id='imput_login' name='login' require></div>
              </div> 
              <div class='form-group'>
              <label for='input_mdp' class='col-sm-4 control-label'>Mot de Passe</label>
              <div class='mr-sm-2'>
                <input class='form-control' type='password' placeholder='Mot de passe' id='input_mdp' name='psw'></div>
              </div> 
              <div class='form-group'>
              <label for='input_mdp2' class='control-label'>confirmer Mot de Passe</label>
              <div class='mr-sm-2'>  
                <input class='form-control mr-sm-2' type='password' placeholder='Confirmation Mot de passe' id='input_mdp2' name='psw2'></div> 
                </div>
            <button type='button' class='btn btn-light mt-3'>Signup</button>
            <p>Vous avez un compte?<button class='btn1 btn-primary' type='button' data-bs-toggle='modal' data-bs-target='#logindemo'>Connexion</button></a></p>
        </form>
    </div>
   </div>
  </div>
 </div>
</div>

AA;
}

function Connexion(){
    echo<<<BD

    <form class='form-inline d-flex '>
    <button class='btn btn-primary my-2 my-sm-0' type='button' data-bs-toggle='modal' data-bs-target='#logindemo'>Connexion</button>&nbsp;&nbsp;
     <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#signupdemo'>
     Signup
     </button>
     </form>

BD;    
}
function Deconnexion(){
    echo<<<BD
    
    <a href='index.php?page=accueil&todo=logout'>
    <button class='btn btn-danger my-2 my-sm-0'>Deconnexion</button></a>&nbsp;
     <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#signupdemo'>
     Compte
     </button>
     

BD;    
}

?>