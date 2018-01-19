<?php

namespace common\models;

use Yii;


class Notificacoes
{
    public function __construct()
    {
            $server = "127.0.0.1";     
    $port = 1883;                     
    $username = "";                   
    $password = "";                   
    $client_id = \uniqid();

    $mqtt = new \common\mosquitto\phpMQTT($server, $port, $client_id);

    if(!$mqtt->connect(true, NULL, $username, $password)) {
        exit(1);
    }

    //$mqtt->publish(Yii::$app->user->identity->username, "Entrou", 0);

    $topics[Yii::$app->user->identity->username] = array("qos" => 0, "function" => "procmsg");
    $mqtt->subscribe($topics, 0);
    
    while($mqtt->proc()){
            
    }
    $mqtt->close();
    }
    function procmsg($topic, $msg)
    {
        
    }
}