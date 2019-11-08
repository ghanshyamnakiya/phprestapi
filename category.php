<?php
/*
*
*/
// Create a new object
require_once('dbhelper.php');

$obj = new Category;
$token = trim($_GET['token']);  //here you can post method for security
$type = trim($_POST['type']);  //type store, edit, update, delete

if($token=="12345" && $type == ""){
  echo $obj->index();
}
if($token=="12345" && $type == "store"){
  echo $obj->store();
}
if($token=="12345" && $type == "update"){
  echo $obj->update();
}
if($token=="12345" && $type == "delete"){
  echo $obj->delete();
}

class Category
{
    public function index()
    {
       $dbhelper = new Dbhelper();
       $sql = "SELECT * FROM categories";
       $res = $dbhelper->SelQuery($sql);
       $result = array();
       if (mysqli_num_rows($res) > 0) {
         $data = array();
         while ($row = $res->fetch_assoc()) {
           $det=array();
           $det ['id'] = $row['id'];
           $det ['name'] = $row['name'];
           $det['details'] = $row['details'];
           $data[]=$det;
         }
         $result ['category']=$data;
         $result ['status']=1;
       }else{
        $result ['error']="Categories are not available";
        $result ['status']=0;
      }
      echo json_encode($result);
    }
    public function store(){
      $dbhelper = new Dbhelper();
      $name = $_POST['name'];
      $details = $_POST['details'];
      $result = array();
      if($name!='' && $details!=''){
        $sql = "INSERT INTO  `categories` (`id` ,  `name` ,  `details` ,  `created_at` ,  `updated_at`)
        VALUES (NULL ,'".$name."','".$details."', NULL , NULL)";
        $res = $dbhelper->StoreQuery($sql);
      }
      if($res){
        $result ['msg']="Successfully Inserted data!";
        $result ['status']=1;
      }else{
        $result ['error']="Not Inserted Data!";
        $result ['status']=0;
      }
      echo json_encode($result);
    }
    public function update(){
      $dbhelper = new Dbhelper();
      $id = $_POST['id'];
      $name = $_POST['name'];
      $details = $_POST['details'];

      $result = array();
      if($name!='' && $details!='' && $id!=''){
        $sql = "UPDATE `categories` SET `name`='".$name."',`details`='".$details."' WHERE `id`='".$id."'";
        $res = $dbhelper->StoreQuery($sql);
      }
      if($res){
        $result ['msg']="Successfully Updated data!";
        $result ['status']=1;
      }else{
        $result ['error']="Not Update Data!";
        $result ['status']=0;
      }
      echo json_encode($result);
    }

    public function delete(){
      $dbhelper = new Dbhelper();
      $id = $_POST['id'];
      $result = array();
      if($id!=''){
        $sql = "DELETE FROM `categories` WHERE `id`='".$id."'";
        $res = $dbhelper->StoreQuery($sql);
      }
      if($res){
        $result ['msg']="Successfully Deleted data!";
        $result ['status']=1;
      }else{
        $result ['error']="Not deleted Data!";
        $result ['status']=0;
      }
      echo json_encode($result);
    }
}
?>
