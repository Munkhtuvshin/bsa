<html>
<head></head>
<body>
    <form method="POST" >
         <div>
            id: <input name="id" value="<?php echo $id; ?>">
        </div>
        <div>
            name: <input name="name" value="<?php echo $name; ?>">
        </div>
        <div>
        description: <input name="description" value="<?php echo $description; ?>">
        </div>
        <div>
        division_type_id: <input name="division_type_id" value="<?php echo $division_type_id; ?>">
        </div>
        <div>
        school_id: <input name="school_id" value="<?php echo $school_id; ?>">
        </div>
        <div>
        parent_id: <input name="parent_id" value="<?php echo $parent_id; ?>">
        </div>
        <div>
            <input type="submit" value="Edit">
            <a href="/credit/choose">Cancel</a>
        </div>
    </form>
</body>
</html>