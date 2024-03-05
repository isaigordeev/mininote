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

    public static function openNote($dbh, $login, $note_name){
        $query = "SELECT `text` FROM `notes` WHERE `login` = '$login' AND `note_name` = '$note_name'";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $request_succeeded = $sth->execute();
        if ($request_succeeded){
            $note = $sth->fetch();
            return $note;
        }
        else return NULL;
    }

    public static function deleteNotes($dbh, $login){
        $user = MininoteUser::getUser($dbh, $login);
        $query = "DELETE FROM notes WHERE `user_id` = '$user->id'";
        $sth = $dbh->prepare($query);
        $request_succeeded = $sth->execute();

        $query = "UPDATE metadata_users SET dirs = '' WHERE `user_id` = '$user->id'";
        $sth = $dbh->prepare($query);
        $request_succeeded = $sth->execute();

        if ($request_succeeded){
            return true;
        }
        else return NULL;
    }



    public static function insertUser($dbh, $login, $pass, $name){
        try{
            $dbh->beginTransaction();

            $sth = $dbh->prepare('INSERT INTO `Users` (`login`, `pass`, `name`) VALUES(?,?,?)');
            $sth->execute(array($login, password_hash($pass, PASSWORD_DEFAULT), $name));

            $user = MininoteUser::getUser($dbh, $login);

            $currentDateTime = date('Y-m-d H:i:s');

            $sth = $dbh->prepare('INSERT INTO `metadata_users` (`user_id`, `creation_date`,
                          `last_modified_date`, `notes_num`, `dirs`) VALUES(?,?,?,?,?)');
            $sth->execute(array($user->id, $currentDateTime, $currentDateTime, 0, ""));

            $dbh->commit();
        } catch (PDOException $e) {
            echo 'User is already here: ' . $e->getMessage();
            exit(0);
        }
    }

    public static function createNote($dbh, $login, $note_name, $text){
        try{
            $user_metadata = MininoteUserMetaData::getUserMetaData($dbh, $login);
            $user = MininoteUser::getUser($dbh, $login);
//            print($user_metadata);
//            print($user);
            $note_id = $user_metadata->notes_num + 1;
            $dirs = $user_metadata->dirs;

            if($dirs == null || $dirs == ""){
                $path = json_encode([$note_name]);
            } else {
//                $paths_array = json_decode($dirs, true);
//                $lastIndex = 1;
//
//                foreach ($paths_array as $key => $value) {
//                    if (is_string($value)) {
//                        $lastIndex++;
//                    }
//                }
//                $paths_array[$lastIndex] = $note_name;

                $paths_array = json_decode($dirs, true);

                if ($paths_array === null) {
                    $paths_array = [];
                }

                $paths_array[] = $note_name;

                $path = json_encode($paths_array);
            }

            $dbh->beginTransaction();

            $sth = $dbh->prepare('INSERT INTO `notes` (`user_id`, `note_user_id`,`name`, `text`) VALUES(?,?,?,?)');
            $sth->execute(array($user_metadata->user_id, $note_id, $note_name, $text));

            $sth = $dbh->prepare('UPDATE `metadata_users`
                      SET dirs = :path, notes_num = :note_number
                      WHERE `user_id` = :user_id');

            $sth->bindParam(':path', $path, PDO::PARAM_STR);
            $sth->bindParam(':note_number', $note_id, PDO::PARAM_INT);
            $sth->bindParam(':user_id', $user_metadata->user_id, PDO::PARAM_INT);
            $sth->execute();

            $dbh->commit();

        } catch (PDOException $e) {
            echo 'Note is not created: ' . $e->getMessage();
            exit(0);
        }
    }

    public static function
    modifyNote($dbh, $login, $name, $text){
        try{
            $user = MininoteUser::getUser($dbh, $login);
//            $sth = $dbh->prepare('INSERT INTO `notes` (`user_id`, `text`) VALUES(?,?)');

            $sth = $dbh->prepare('UPDATE `notes`
                      SET  `text` = :text
                      WHERE `user_id` = :user_id AND `name` = :note_id');

            $sth->bindParam(':note_id', $name, PDO::PARAM_STR);
            $sth->bindParam(':text', $text, PDO::PARAM_STR);
            $sth->bindParam(':user_id', $user->id, PDO::PARAM_INT);
            $sth->execute(); #TODO a problem of transaction with that

//            $sth->execute(array($user->id, $text));
        } catch (PDOException $e) {
            echo 'Note is not modified: ' . $e->getMessage();
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