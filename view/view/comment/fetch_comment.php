<?php

//fetch_comment.php

$connect = new PDO('mysql:host=localhost;dbname=eschool', 'project', '');

$query = "
SELECT * FROM comment
WHERE parent_id = '0' 
ORDER BY id DESC
";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();
$output = '';
foreach($result as $row)
{
 $output .= '
 <div class="panel panel-default">
  <div class="panel-heading">By <b>'.$row["id"].'</b> on <i>'.$row["created_date"].'</i></div>
  <div class="panel-body">'.$row["comment"].'</div>
  <div class="panel-footer" align="right"><button type="button" class="btn btn-default reply" id="'.$row["id"].'">Reply</button></div>
 </div>
 ';
 $output .= get_reply_comment($connect, $row["id"]);
}

echo $output;

function get_reply_comment($connect, $parent_id = 0, $marginleft = 0)
{
 $query = "
 SELECT * FROM comment WHERE parent_id = '".$parent_id."'
 ";
 $output = '';
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 $count = $statement->rowCount();
 if($parent_id == 0)
 {
  $marginleft = 0;
 }
 else
 {
  $marginleft = $marginleft + 48;
 }
 if($count > 0)
 {
  foreach($result as $row)
  {
   $output .= '
   <div class="panel panel-default" style="margin-left:'.$marginleft.'px">
    <div class="panel-heading">By <b>'.$row["id"].'</b> on <i>'.$row["created_date"].'</i></div>
    <div class="panel-body">'.$row["comment"].'</div>
    <div class="panel-footer" align="right"><button type="button" class="btn btn-default reply" id="'.$row["id"].'">Reply</button></div>
   </div>
   ';
   $output .= get_reply_comment($connect, $row["id"], $marginleft);
  }
 }
 return $output;
}

?>