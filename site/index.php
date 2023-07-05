<?php
header('Content-Type: application/json');
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
$blaze = $json['test'];
$sql = 'SELECT * from tweet join user on tweet.user_id = user.user_id where user.user_id = '.$blaze;
$getUserTweet = $db->prepare($sql);
$getUserTweet->execute();
$retour = $getUserTweet->fetchAll();
$retour = json_encode($retour);
if(array_key_exists('test', $json)){
    echo $retour[0]['password'];
}else{
    echo "fait rien fro";
}




?>
