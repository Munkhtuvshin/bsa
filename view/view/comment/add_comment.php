<?php

//add_comment.php

$connect = new PDO('mysql:host=localhost;dbname=eschool', 'project', '');

$error = '';
$comment_name = '';
$comment_content = '';

if(empty($_POST["id"]))
{
 $error .= '<p class="text-danger">Name is required</p>';
}
else
{
 $comment_name = $_POST["id"];
}

if(empty($_POST["comment_content"]))
{
 $error .= '<p class="text-danger">Comment is required</p>';
}
else
{
 $comment_content = $_POST["comment_content"];
}

if($error == '')
{
$query = 'INSERT INTO comment (comment, user_id, created_date, parent_id ) values("' . $comment . '",' . $user_id . ',curdate(),' . ($parent_id > 0?$parent_id:'null') . ')';
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':parent_id' => $_POST["id"],
   ':comment'    => $comment_content,
   ':comment_name' => $_POST["id"],

   
  )
 );
 $error = '<label class="text-success">Comment Added</label>';
}

$data = array(
 'error'  => $error
);

echo json_encode($data);

?>