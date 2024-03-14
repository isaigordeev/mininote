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
        $user = MininoteUser::getUser($dbh, $login);
        $query = "SELECT `text` FROM `notes` WHERE `user_id` = :user_id AND `name` = :note_name";

        $sth = $dbh->prepare($query);
        $sth->bindParam(':note_name', $note_name);
        $sth->bindParam(':user_id', $user->id); // Assuming user_id is a property of $user
        $request_succeeded = $sth->execute();

        if ($request_succeeded){
            $note = $sth->fetch(PDO::FETCH_ASSOC); // Fetch the result as an associative array
            if ($note) {
                return $note['text']; // Return the value of the 'text' column
            } else {
                return NULL; // Note not found
            }
        } else {
            return NULL; // Error executing the query
        }
    }

    public static function openNoteExtended($dbh, $login, $note_name){
        $user = MininoteUser::getUser($dbh, $login);
        $query = "SELECT * FROM `notes` WHERE `user_id` = :user_id AND `name` = :note_name";

        $sth = $dbh->prepare($query);
        $sth->bindParam(':note_name', $note_name);
        $sth->bindParam(':user_id', $user->id); // Assuming user_id is a property of $user
        $request_succeeded = $sth->execute();

        if ($request_succeeded){
            $note = $sth->fetch(PDO::FETCH_ASSOC); // Fetch the result as an associative array
            if ($note) {
                return json_encode($note); // Return the value of the 'text' column
            } else {
                return NULL; // Note not found
            }
        } else {
            return NULL; // Error executing the query
        }
    }

    public static function getNoteId($dbh, $login, $name) {
        $user = MininoteUser::getUser($dbh, $login);
        $query = "SELECT `note_user_id` FROM `notes` WHERE `user_id` = :login AND `name` = :name";

        $sth = $dbh->prepare($query);
        $sth->bindParam(':login', $user->id);
        $sth->bindParam(':name', $name);
        $request_succeeded = $sth->execute();

        if ($request_succeeded) {
            $result = $sth->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return $result['note_user_id']; // Return the node ID
            } else {
                return null; // Node not found
            }
        } else {
            return null; // Error executing the query
        }
    }

    public static function makeNotePublic($dbh, $login, $note_name){
        $user = MininoteUser::getUser($dbh, $login);

        $note_user_id = MininoteUser::getNoteId($dbh, $login, $note_name);

        $query = "UPDATE `notes` SET `public` = 1 WHERE `note_user_id` = :note_user_id AND `user_id` = :user_id";

        $sth = $dbh->prepare($query);
        $sth->bindParam(':note_user_id', $note_user_id);
        $sth->bindParam(':user_id', $user->id);
        $request_succeeded = $sth->execute();
    }

    public static function getPublic($dbh){
        $query = "SELECT u.login, n.name, n.text 
              FROM notes n 
              JOIN users u ON n.user_id = u.id 
              WHERE n.public = 1";

        $sth = $dbh->prepare($query);
        $request_succeeded = $sth->execute();

        if ($request_succeeded) {
            // Fetch all rows as associative array
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } else {
            // Handle query execution failure
            return false;
        }
    }

    public static function getMentions($dbh, $login, $note){
        $note_id = MininoteUser::getNoteId($dbh, $login, $note);
        $user = MininoteUser::getUser($dbh, $login);

        $query = "SELECT * FROM `notes` WHERE text LIKE '%[[$note]]%' AND `note_id` != $note_id AND `user_id` = $user->id";

        $sth = $dbh->prepare($query);
        $request_succeeded = $sth->execute();

        if ($request_succeeded) {
            // Fetch all rows as associative array
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } else {
            // Handle query execution failure
            return false;
        }
    }



    public static function makeNotePrivate($dbh, $login, $note_name){
        $user = MininoteUser::getUser($dbh, $login);

        $note_user_id = MininoteUser::getNoteId($dbh, $login, $note_name);

        $query = "UPDATE `notes` SET `public` = 0 WHERE `note_user_id` = :note_user_id AND `user_id` = :user_id";

        $sth = $dbh->prepare($query);
        $sth->bindParam(':note_user_id', $note_user_id);
        $sth->bindParam(':user_id', $user->id);
        $request_succeeded = $sth->execute();
    }

    public static function renameNote($dbh, $login, $note_name, $new_note_name){
        $user = MininoteUser::getUser($dbh, $login);
        $user_metadata = MininoteUserMetaData::getUserMetaData($dbh, $login);

        $note_user_id = MininoteUser::getNoteId($dbh, $login, $note_name);

        $dirs_arr = json_decode($user_metadata->dirs, true);

        foreach ($dirs_arr as $key => $value) {
            // Check if the value matches the element to find
            if ($value === $note_name) {
                $dirs_arr[$key] = $new_note_name;
            }
        }
        $dirs = json_encode($dirs_arr);

        $query = "UPDATE `metadata_users` SET `dirs` = :new_dirs WHERE `user_id` = :user_id";

        $sth = $dbh->prepare($query);
        $sth->bindParam(':new_dirs', $dirs);
        $sth->bindParam(':user_id', $user->id);
        $request_succeeded = $sth->execute();

        $query = "UPDATE `notes` SET `name` = :new_note_name WHERE `note_user_id` = :note_user_id AND `user_id` = :user_id";

        $sth = $dbh->prepare($query);
        $sth->bindParam(':new_note_name', $new_note_name);
        $sth->bindParam(':note_user_id', $note_user_id);
        $sth->bindParam(':user_id', $user->id);
        $request_succeeded = $sth->execute();
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

    public static function makeAllPublic($dbh, $login){
        $user = MininoteUser::getUser($dbh, $login);

        $query = "UPDATE `notes` SET `public` = 1 WHERE `user_id` = :user_id";

        $sth = $dbh->prepare($query);
        $sth->bindParam(':user_id', $user->id);
        $request_succeeded = $sth->execute();
    }

    public static function makeAllPrivate($dbh, $login){
        $user = MininoteUser::getUser($dbh, $login);

        $query = "UPDATE `notes` SET `public` = 0 WHERE `user_id` = :user_id";

        $sth = $dbh->prepare($query);
        $sth->bindParam(':user_id', $user->id);
        $request_succeeded = $sth->execute();
    }

    public static function deleteAccount($dbh, $login){
        $user = MininoteUser::getUser($dbh, $login);
        $query = "DELETE FROM notes WHERE `user_id` = '$user->id'";
        $sth = $dbh->prepare($query);
        $request_succeeded = $sth->execute();

        $query = "DELETE FROM metadata_users WHERE `user_id` = '$user->id'";
        $sth = $dbh->prepare($query);
        $request_succeeded = $sth->execute();

        $query = "DELETE FROM Users WHERE `id` = '$user->id'";
        $sth = $dbh->prepare($query);
        $request_succeeded = $sth->execute();

        if ($request_succeeded){
            return true;
        }
        else return NULL;
    }

    public static function deleteNote($dbh, $login, $note_name){
        $user_metadata = MininoteUserMetaData::getUserMetaData($dbh, $login);

        $note_user_id = MininoteUser::getNoteId($dbh, $login, $note_name);


        $query = "DELETE FROM notes WHERE `user_id` = '$user_metadata->user_id' AND `note_user_id` = '$note_user_id'";
        $sth = $dbh->prepare($query);
        $request_succeeded = $sth->execute();

        $dirs_arr = json_decode($user_metadata->dirs, true);

//        foreach ($dirs_arr as $key => $value) {
//            // Check if the value matches the element to find
//            if ($value === $note_name) {
//                unset($dirs_arr[$key]);
//            }
//        }
//
//        $dirs = json_encode($dirs_arr);

        $key = array_search($note_name, $dirs_arr);
        if ($key !== false) {
            unset($dirs_arr[$key]);
        }

        $dirs = json_encode(array_values($dirs_arr));

        $query = "UPDATE `metadata_users` SET `dirs` = :new_dirs WHERE `user_id` = :user_id";

        $sth = $dbh->prepare($query);
        $sth->bindParam(':new_dirs', $dirs);
        $sth->bindParam(':user_id', $user_metadata->user_id);
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
            $dbh->rollBack();
            echo 'Note is not created: ' . $e->getMessage();
            exit(0);
        }
    }

    public static function
    modifyNote($dbh, $login, $name, $text){
        try{
            $dbh->beginTransaction();

            $user = MininoteUser::getUser($dbh, $login);


            $sth = $dbh->prepare('UPDATE `notes`
                      SET  `text` = :text
                      WHERE `user_id` = :user_id AND `name` = :name');

//            $name = "Untitled9";

//            echo ($name)."name ";

            $sth->bindParam(':name', $name);
            $sth->bindParam(':text', $text);
            $sth->bindParam(':user_id', $user->id);
            $sth->execute(); #TODO a problem of transaction with that

            $dbh->commit();
            echo "Update successful";

//            $sth->execute(array($user->id, $text));
        } catch (PDOException $e) {
            $dbh->rollBack();
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