<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon --><!--  -->
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <form method="POST">
        <label>Point</label>
        <input type="text" name="point" value="<?php echo $grade->point; ?>"><br>
        <label>Description</label>
        <input type="text" name="description" value="<?php echo $grade->description; ?>" ><br>
        <label>Student Id</label>
        <input type="text" name="student_id" value="<?php echo $grade->student_user_id; ?>" ><br>
        <label>Lesson Id</label>
        <input type="text" name="lesson_id" value="<?php echo $grade->lesson_id; ?>"><br>
        <input type="submit" name="insert" value="zasah">
    </form>    
</body>

</html>
