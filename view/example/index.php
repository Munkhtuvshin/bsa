<html>
<head></head>
<body>
    <a href="/example/hello/add">add</a>
    <table border="1">
        <?php foreach($userTypes as $userType){ ?>
            <tr>
                <td><?php echo $userType->id; ?></td>
                <td><a href="/example/hello/edit/<?php echo $userType->id; ?>"><?php echo $userType->name; ?></a></td>
                <td><form action="/example/hello/remove/<?php echo $userType->id; ?>" method="POST"><input type="submit" value="Remove"></form></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>