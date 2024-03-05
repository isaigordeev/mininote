<?php
class Utilisateur {
    public $login;
    public $mdp;
    public $name;
    public $surname;
    public $promotion;
    public $naissance;
    public $email;
    public $feuille;

    public function __toString() {
        return "[$this->login] $this->mdp $this->surname $this->name, né le $this->naissance X$this->promotion, $this->email\n";
    }

    public static function getUser($dbh, $login){
        $query = "SELECT * FROM `utilisateurs` WHERE `login` = '$login'";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Utilisateur');
        $request_succeeded = $sth->execute();
        if ($request_succeeded){
            $user = $sth->fetch();
            //print($user);
            return $user;
        }
        else return NULL;
    }

    public static function insertUser($dbh, $login, $mdp, $nom, $prenom, $promotion, $naissance, $email, $feuille){
        try{
            $sth = $dbh->prepare('INSERT INTO `utilisateurs` (`login`, `mdp`, `nom`, `prenom`, `promotion`, `naissance`, `email`, `feuille`) VALUES(?,?,?,?,?,?,?,?)');
            $sth->execute(array($login, password_hash($mdp, PASSWORD_DEFAULT), $nom, $prenom, $promotion, $naissance, $email, $feuille));
        } catch (PDOException $e) {
            echo 'User is already here: ' . $e->getMessage();
            exit(0);
        }
    }

    public static function checkPass($dbh, $login, $mdp){
        try {$user = Utilisateur::getUser($dbh, $login);

            if ($user == NULL){
                //echo 'User is not found';
                return False;
            }

            if (password_verify($mdp, $user->mdp)){
                //echo "Passwords match";
                return True;
            } else {
                //echo "Passwords do not match";
                return False;
            }

        } catch (PDOException $e) {
           // echo 'User is not found: ' . $e->getMessage();
            exit(0);
        }
    }

    public static function findFriendsNames($dbh, $login){
        $query = "SELECT login2 FROM `amis` WHERE `login1` = '$login'";
        $sth = $dbh->prepare($query);
//        $sth->setFetchMode(PDO::FETCH_CLASS, 'Utilisateur');
        $request_succeeded = $sth->execute();

//        if ($request_succeeded){
//            while($user = $sth->fetchAll())){
//                echo $user->login;
//            }
//        }
//        else return NULL;

        if ($request_succeeded) {
            print_r($sth->fetchAll(PDO::FETCH_COLUMN, 0));
            $arr = $sth->fetchAll(PDO::FETCH_COLUMN, 0);
//            foreach ($arr as $key => $value){
//                echo $value;
//            }
            return $arr; #FINISH
        }
        else return NULL;
    }

    public static function findFriends($dbh, $login){
        $query = "SELECT utilisateurs.login, utilisateurs.mdp,utilisateurs.nom,utilisateurs.prenom FROM `amis` JOIN `utilisateurs` ON amis.login1 = '$login' AND utilisateurs.login = amis.login2";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Utilisateur');
        $request_succeeded = $sth->execute();

//        if ($request_succeeded){
//            while($user = $sth->fetchAll()){
//                echo $user;
//            }
//        }
//        else return NULL;
        if ($request_succeeded) {
            print_r($sth->fetchAll());
        }
        else return NULL;
    }

}

abstract class MininoteUserAbstract {
    public $id;
    public $login;
    public $pass;
    public $name;
}

class MininoteUserMetaData {
    public $metadata_id;
    public $user_id;
    public $creation_date;
    public $last_modified_date;
    public $notes_num;
    public $dirs;

    public static function getUserMetaData($dbh, $login){
        $user = MininoteUser::getUser($dbh, $login);
        $query = "SELECT * FROM `metadata_users` WHERE `user_id` = '$user->id'";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'MininoteUserMetaData');
        $request_succeeded = $sth->execute();
        if ($request_succeeded){
            $user_metadata = $sth->fetch();
            return $user_metadata;
        }
        else return NULL;
    }

    public function __toString() {
        return "[$this->metadata_id] id: $this->user_id dirs: $this->dirs \n";
    }
}

class MininoteUser extends MininoteUserAbstract {


    public function __toString() {
        return "[$this->login] $this->pass $this->name \n";
    }

    public static function getUser($dbh, $login){
        $query = "SELECT * FROM `Users` WHERE `login` = '$login'";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'MininoteUser');
        $request_succeeded = $sth->execute();
        if ($request_succeeded){
            $user = $sth->fetch();
            return $user;
        }
        else return NULL;
    }



    public static function insertUser($dbh, $login, $pass, $name){
        try{
            $sth = $dbh->prepare('INSERT INTO `users` (`Login`, `Pass`, `Name`) VALUES(?,?,?)');
            $sth->execute(array($login, password_hash($pass, PASSWORD_DEFAULT), $name));
        } catch (PDOException $e) {
            echo 'User is already here: ' . $e->getMessage();
            exit(0);
        }
    }

    public static function createNote($dbh, $login, $note_name, $text){
        try{
            $user_metadata = MininoteUserMetaData::getUserMetaData($dbh, $login);
            $user = MininoteUser::getUser($dbh, $login);
            print($user_metadata);
            print($user);
            $note_id = $user_metadata->notes_num + 1;
            $dirs = $user_metadata->dirs;

            if($dirs == null){
                $dirs = array();
                array_push($dirs, $note_name);
                $path = json_encode($dirs);
            } else {
                $paths_array = json_decode($dirs, true);
                print_r($dirs);
                print_r($paths_array);
                $lastIndex = 0;

                foreach ($paths_array as $key => $value) {
                    if (is_string($value)) {
                        $lastIndex++;
                    }
                }
//                $obj = (array) $paths_array;

//                $obj[$lastIndex+1] = $note_name;

//                $paths_array = (object) $obj;
                $paths_array[$lastIndex] = $note_name;

                print_r($paths_array);


//                array_push($paths_array, $note_name);
                $path = json_encode($paths_array);
            }


            $sth = $dbh->prepare('INSERT INTO `notes` (`user_id`, `note_user_id`,`name`, `text`) VALUES(?,?,?,?)');
            $sth->execute(array($user_metadata->user_id, $note_id, $note_name, $text));

            $sth = $dbh->prepare('UPDATE `metadata_users`
                      SET dirs = :path, notes_num = :note_number
                      WHERE `user_id` = :user_id');

            $sth->bindParam(':path', $path, PDO::PARAM_STR);
            $sth->bindParam(':note_number', $note_id, PDO::PARAM_INT);
            $sth->bindParam(':user_id', $user_metadata->user_id, PDO::PARAM_INT);
            $sth->execute();

        } catch (PDOException $e) {
            echo 'Note is not created: ' . $e->getMessage();
            exit(0);
        }
    }

    public static function modifyNode($dbh, $login, $name, $note_id, $text){
        try{
            $user = MininoteUser::getUser($dbh, $login);
            $sth = $dbh->prepare('INSERT INTO `notes` (`user_id`, `text`) VALUES(?,?)');
            $sth->execute(array($user->id, $text));
        } catch (PDOException $e) {
            echo 'Note is not created: ' . $e->getMessage();
            exit(0);
        }
    }

    public static function checkPass($dbh, $login, $pass){
        try {$user = MininoteUser::getUser($dbh, $login);

            if ($user == NULL){
                //echo 'User is not found';
                return False;
            }
            if (password_verify($pass, $user->pass)){
//                echo "Passwords match\n";
                return True;
            } else {
//                echo "Passwords do not match\n";
                return False;
            }

        } catch (PDOException $e) {
            // echo 'User is not found: ' . $e->getMessage();
            exit(0);
        }
    }

    public static function findFriendsNames($dbh, $login){
        $query = "SELECT login2 FROM `amis` WHERE `login1` = '$login'";
        $sth = $dbh->prepare($query);
//        $sth->setFetchMode(PDO::FETCH_CLASS, 'Utilisateur');
        $request_succeeded = $sth->execute();

//        if ($request_succeeded){
//            while($user = $sth->fetchAll())){
//                echo $user->login;
//            }
//        }
//        else return NULL;

        if ($request_succeeded) {
            print_r($sth->fetchAll(PDO::FETCH_COLUMN, 0));
            $arr = $sth->fetchAll(PDO::FETCH_COLUMN, 0);
//            foreach ($arr as $key => $value){
//                echo $value;
//            }
            return $arr; #FINISH
        }
        else return NULL;
    }

    public static function findFriends($dbh, $login){
        $query = "SELECT utilisateurs.login, utilisateurs.mdp,utilisateurs.nom,utilisateurs.prenom FROM `amis` JOIN `utilisateurs` ON amis.login1 = '$login' AND utilisateurs.login = amis.login2";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Utilisateur');
        $request_succeeded = $sth->execute();

//        if ($request_succeeded){
//            while($user = $sth->fetchAll()){
//                echo $user;
//            }
//        }
//        else return NULL;
        if ($request_succeeded) {
            print_r($sth->fetchAll());
        }
        else return NULL;
    }

}



function insertUser($dbh, $login, $mdp, $nom, $prenom, $promotion, $naissance, $email, $feuille){
    $sth = $dbh->prepare('INSERT INTO `utilisateurs` (`login`, `mdp`, `nom`, `prenom`, `promotion`, `naissance`, `email`, `feuille`) VALUES(?,?,?,?,?,?,?,?)');
    $sth->execute(array($login, password_hash($mdp, PASSWORD_DEFAULT), $nom, $prenom, $promotion, $naissance, $email, $feuille));
}

function queryDB($dbh, $query){
    $sth = $dbh->prepare($query);
    $request_succeeded = $sth->execute();
    if ($request_succeeded){
        while ($courant = $sth->fetch(PDO::FETCH_ASSOC)){
            echo $courant['prenom'];
//            echo '<br>';
        }
    }
}

function smartqueryDB($dbh, $query){
    $sth = $dbh->prepare($query);
    $sth->setFetchMode(PDO::FETCH_CLASS, 'Utilisateur');
    $request_succeeded = $sth->execute();
    if ($request_succeeded){
        while ($user = $sth->fetch(PDO::FETCH_ASSOC)){
            echo $user[''];
//            echo '<br>';
        }
    }
}
?>