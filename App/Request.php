<?php

// include "BD/BD.php";

class Request {
    protected string $table;
    protected string $request;
    public int $id;

    public function __construct(string $table="orders")
    {
        $this->table = $table;
    }

    public function execute(){
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $this->get();
        }
        
        if($_POST['METHOD'] == 'POST'){
            $this->post();
        }
        
        if($_POST['METHOD'] == 'PUT'){
            $this->put();
        }
        
        if($_POST['METHOD'] == 'DELETE'){
            $this->delete();
        }
        
        header("HTTP/1.1 400 Bad Request");
    }

    protected function get(){
        $this->id= isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)? $_GET['id']: 0;
        
        if($this-> id && isset($_GET) && count($_GET) > 0){
            $query = <<<INPUT
                    SELECT * FROM {$this->table} WHERE id = {$this->id}
                    INPUT;

                    $result= GetMethod($query);
                    
                    header("Content-Type: application/json; charset=UTF-8");
                    echo json_encode($result->fetch(PDO::FETCH_ASSOC));
        }
        else{
             $query = <<<INPUT
                        SELECT * FROM {$this->table}
                    INPUT;
            $result = GetMethod($query);
            echo json_encode($result->fetchAll());
        }
        header("HTTP/1.1 200 OK");
        exit();

    }

    protected function post(){
        unset($_POST['METHOD']);
        $ord_date = $_POST['ord_date'];
        $ord_hour = $_POST['ord_hour'];
        $client_id= $_POST['client_id'];
        $user= $_POST['user'];
        $ord_num = $_POST['ord_num'];
        $delivery_date= $_POST['delivery_date'];
        $delivery_hour= $_POST['delivery_hour'];
        $client_discount= $_POST['client_discount'];
        $Comments= $_POST['Comments'];

    
        $query = <<<INPUT
            INSERT INTO {$this->table}(ord_date, ord_hour, client_id, user, ord_num, delivery_date, delivery_hour, client_discount,Comments) VALUES ('{$ord_date}', '{$ord_hour}','{$client_id}','{$user}', '{$ord_num}', '{$delivery_date}', '{$delivery_hour}', '{$client_discount}','{$Comments}')
        
        INPUT;
        $queryAutoIncrement= <<<INPUT
        SELECT MAX(id) as id from {$this->table}
        INPUT;
        $result=PostMethod($query,$queryAutoIncrement);
        echo json_encode($result);
        header("HTTP/1.1 200 OK");
        exit();
    
    }

    public function put(){

        unset($_POST['METHOD']);


        $this->id= isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)? $_GET['id']:0;
        $ord_date = $_POST['ord_date'];
        $ord_hour = $_POST['ord_hour'];
        $client_id= $_POST['client_id'];
        $user= $_POST['user'];
        $ord_num = $_POST['ord_num'];
        $delivery_date= $_POST['delivery_date'];
        $delivery_hour= $_POST['delivery_hour'];
        $client_discount= $_POST['client_discount'];
        $Comments= $_POST['Comments'];

        $query= <<<INPUT
                UPDATE {$this->table} SET ord_date = '{$ord_date}', ord_hour='{$ord_hour}', client_id= '{$client_id}', user= '{$user}', ord_num= '{$ord_num}', delivery_date= '{$delivery_date}', delivery_hour = '{$delivery_hour}', client_discount ='{$client_discount}', Comments= '{$Comments}' WHERE id = '{$this->id}'

        INPUT;


        $result = PutMethod($query);
        echo json_encode($result);
        header("HTTP/1.1 200 OK");
        exit();

    }

    protected function delete(){
        unset($_POST['METHOD']);


        $this->id= isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)? $_GET['id']:0;
        

        $query= <<<INPUT
        DELETE FROM {$this->table} WHERE id = '{$this->id}'

        INPUT;


        $result=DeleteMethod($query);
        echo json_encode($result);
        header("HTTP/1.1 200 OK");
        exit();

    }





}




?>