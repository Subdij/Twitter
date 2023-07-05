<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

try{
    $db = new PDO(
        'mysql:host=localhost;dbname=twitter;charset=utf8',
        'root'
    );    
    $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e){
    die(print_r($e));
}
$json = json_decode(file_get_contents('php://input'), true);
if($json['mail'] != null && $json['pseudo'] != null && $json['password'] != null && $json['identifiant'] != null){
    $sqlMail = "SELECT mail,identifiant FROM user";
    $getMail = $db->prepare($sqlMail);
    $getMail->execute();
    $retour = $getMail->fetchAll();
    foreach($retour as $test){
        if($test['mail'] == $json['mail'] || $test['identifiant'] == $json["identifiant"]){
            echo 22;
            return;
        }
    }
    $sql = 'INSERT INTO user (user_id, mail, pseudo, password, bio, pp_link, identifiant) 
    VALUES (NULL, :mail, :pseudo, :password, NULL, NULL, :identifiant)';
            $setUser = $db->prepare($sql);
            $sqlParams = [
            'mail' => $json["mail"],
            'pseudo' => $json["pseudo"],
            'password' => $json["password"],
            'identifiant' => $json["identifiant"]
            ];
            $setUser->execute($sqlParams);
            echo 777;
}else {
    echo 111;
}

/*$sql = 'INSERT INTO user (user_id, mail, pseudo, password) VALUES (NULL, :mail, :pseudo, :password)';
            $setUser = $db->prepare($sql);
            $sqlParams = [
            'mail' => $json["mail"],
            'pseudo' => $json["pseudo"],
            'password' => $json["password"],
            ];
            $setUser->execute($sqlParams);
            echo "Vous avez bien créez votre compte dans la base de donnée";*/
?>
