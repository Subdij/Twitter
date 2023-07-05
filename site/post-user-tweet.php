<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: auth");
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
require 'auth.php';

if($authentification){
    if($json['content'] != null && $json['replied'] != null){
        if($json['replied'] == "NULL"){
            $json['replied'] = NULL;
        }
        $sqlPostTweet = "INSERT INTO tweet (tweet_id,user_id,content,date_creation, origin_id, img_link) 
        VALUES (NULL, :id,:content, current_timestamp(), :replied, NULL)";
        $postTweet = $db->prepare($sqlPostTweet);
        $params = [
            'id' => $userId,
            'content' => $json["content"],
            'replied' => $json["replied"]
        ];
        $postTweet->execute($params);
    }else {
        echo 333;
    }
}else{
    echo "Le token fourni via le setRequestHeader est invalide";
}
?>
