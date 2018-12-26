<html>
<head></head>
<body>
    <a href="/comment/comment2/add">add</a>
    <table border="1">
   
        <?php 
            //  var_dump($commenTs);
            foreach($commenTs as $soyloo){ ?>
            <tr>
                <td><?php echo $soyloo->id; ?></td>
                <td><?php echo $soyloo->comment; ?></td>
                <td><?php echo $soyloo->reaction; ?></td>
                <td><?php echo $soyloo->user_id; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>