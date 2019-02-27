<?php
//'ToDo' object
class ToDo{
    private $conn;
    private $table_name = "ToDo";
    public $idTodo;
    public $task;
    public $dateTask;
    public $idUser;
    public $user_Name;
//constructor
public function __construct($db){
    $this->conn = $db;
}
function create(){
 
    // insert query
    $query = "INSERT INTO " . $this->table_name . "
            SET
                task= :task,
                dateTask = :dateTask,idUser=:idUser";
 
    // prepare the query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->task=htmlspecialchars(strip_tags($this->task));
    $this->date_task=htmlspecialchars(strip_tags($this->date_task));
    $this->idUser=htmlspecialchars(strip_tags($this->idUser));

    // bind the values
    $stmt->bindParam(':task', $this->task);
    $stmt->bindParam(':dateTask', $this->dateTask);
        $stmt->bindParam(':idUser', $this->idUser);

    // execute the query, also check if query was successful
    if($stmt->execute()){
        return true;
    }
 
    return false;
}
public function update(){
 
    // if password needs to be updated

 
    // if no posted password, do not update the password
    $query = "UPDATE " . $this->table_name . "
            SET
                task = :task,
                dateTask = :dateTask,
                idUser=:idUser
            WHERE idTodo = :idTodo";
 
    // prepare the query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->task=htmlspecialchars(strip_tags($this->task));
    $this->dateTask=htmlspecialchars(strip_tags($this->dateTask));
    $this->idUser=htmlspecialchars(strip_tags($this->idUser));
    $this->idTodo=htmlspecialchars(strip_tags($this->idTodo));


    // bind the values from the form
    $stmt->bindParam(':task', $this->task);
    $stmt->bindParam(':dateTask', $this->dateTask); 
    $stmt->bindParam(':idUser', $this->idUser); 
    $stmt->bindParam(':idTodo', $this->idTodo);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}
// read products
function read(){
 
    // select all query
    $query = "SELECT
                U.firstname as user_Name, T.idTodo, T.task, T.dateTask,T.idUser, T.created
            FROM
                " . $this->table_name . " T
                LEFT JOIN
                    users U
                        ON T.idUser = T.idUser
            ORDER BY
                T.created DESC";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}
// delete the product
function delete(){
 
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE idTodo = ?";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->idTodo=htmlspecialchars(strip_tags($this->idTodo));
 
    // bind id of record to delete
    $stmt->bindParam(1, $this->idTodo);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}

}

?>