<?php
namespace app\models;
use app\core\Database;
trait Profiledb{
  use Database;
  public function UpdateProfile($Bio, $image_path) {
    $user_name=$_SESSION['username'];
    $this->conn->begin_transaction();
    if($image_path==''){
      $sql="UPDATE users SET  bio = '$Bio' WHERE UserName = '$user_name';";
    }
  else if($Bio==''||$Bio==' '){
    $sql="UPDATE users SET profile_img = '$image_path' WHERE UserName = '$user_name';";

  }
  else{
    $sql="UPDATE users SET profile_img = '$image_path', bio = '$Bio' WHERE UserName = '$user_name';";
  }
    
    try {
      // Execute queries
      $query = $this->conn->query($sql);
      // Check if all queries were successful
      if ($query) {
        // Commit transaction
        $this->conn->commit();
        header('Location:profile');
      } else {
        // Rollback transaction
        $this->conn->rollback();
        echo $this->conn->error;
      }
    } catch (\mysqli_sql_exception $e) {
      $this->conn->rollback();
      echo $e->getMessage();
    }
}
}