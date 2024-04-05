<?php
class Model {
  public function test($name){
    $filename="../app/models/".$name.".php";
    if(file_exists($filename)){
      require $filename;
    }
  }
}  