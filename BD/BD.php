<?php



$pdo= null;
$host= "localhost";
$user= "root";
$pass= "";
$database= "test"; 



function Connect(){

    try{

        $GLOBALS['pdo'] = new PDO("mysql:host=".$GLOBALS['host']."; dbname=".$GLOBALS['bd']."", $GLOBALS['user'], $GLOBALS['password']);
        $GLOBALS['pdo']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    catch(PDOException $e){
        print "Error!: No se pudo conectar a la base de datos ".$GLOBALS['bd']."<br/>";
        print "\n Error!: ".$e."<br\>";
    }
}



    function Disconnect(){
        $GLOBALS['pdo']= null;
    }

    function GetMethod($query){
        try{
            Connect();
            $sentence= $GLOBALS['pdo']->prepare($query);
            $sentence->setFetchMode(PDO::FETCH_ASSOC);
            $sentence->execute();
            Disconnect();

            return $sentence;

        }

        catch(Exception $e){
            die ("Error: ". $e);
        }
    }

    function PostMethod($query, $queryAutoincrement){
        try{
            Connect();
            $sentence= $GLOBALS['pdo']->prepare($query);
            $sentence->execute();
            $idAutoincrement= GetMethod($queryAutoincrement)-> fetch(PDO::FETCH_ASSOC);
            $result= array_merge($idAutoincrement, $_POST);
            $sentence->closeCursor();
            Disconnect();
            return $result;
        }
        catch(Exception $e){
            die("Error: ". $e);
        }
    }


    function PutMethod(){
        try{
            Connect();
            $sentence= $GLOBALS['pdo']->prepare($query);
            $sentence-> execute();
            $result= array_merge($_GET, $_POST);
            $sentence->closeCursor();
            Disconnect();
            return $result;
        }
        catch(Exception $e){

            die("Error: ".$e);

        }
        
    }

    function DeleteMethod(){
        try{
            Connect();
            $sentence=$GLOBALS['pdo']->prepare($query);
            $sentence->execute();
            $sentence->closeCursor();
            Disconnect();
            return  $_GET['id'];

        }
        catch(Exception $e){
            die ("Error:   ".$e);
        }
    }









?>