            //*************************************************
            // $maxa = $model->getGradesAndMaxGradeCount($course_id);
            // var_dump($maxa);
            // $maxSem = $model->maxSemCount($course_id);
            // var_dump($maxSem);
            // $maxLec = $model->maxLecCount($course_id);
            // var_dump($maxLec);
            //*************************************************
            
            $results = $model->getGradesAndMaxGradeCount($course_id);
            $count =0;
            // var_dump($results[0]);
            foreach ($results[1] as $key => $datavalue) {
                foreach ($results[0] as $key1 => $value) {
                    if($datavalue->id==$value->id && $value->name=="Лаборатори"){
                        $count++;
                    }
                }
                $res[]=$count;
                $count=0;
            }
            $maxLab=max($res);
            unset($res);

            $c=0;
            foreach ($results[1] as $key => $datavalue) {
                foreach ($results[0] as $key1 => $value) {
                    if($datavalue->id==$value->id && $value->name=="Лекц"){
                        $c++;
                    }
                }
                $res[]=$c;
                $c=0;
            }
            $maxLec=max($res);
            unset($res);

            $c=0;
            foreach ($results[1] as $key => $datavalue) {
                foreach ($results[0] as $key1 => $value) {
                    if($datavalue->id==$value->id && $value->name=="Семинар"){
                        $c++;
                    }
                }
                $res[]=$c;
                $c=0;
            }
            $maxSem=max($res);
            unset($res);
            //********Soril
            $soril=$model->getSoril($course_id);
            $c=0;
            foreach ($results[1] as $key => $datavalue) {
                foreach ($soril as $key1 => $value) {
                    if($datavalue->id==$value->id ){
                        $c++;
                    }
                }
                $res[]=$c;
                $c=0;
            }
            $maxSoril=max($res);






            <?php 
                for ($x = 0; $x < $maxLec; $x++) {
                    echo '<th>Лк '.($x+1).'</th>';
                } 
            ?>
            <?php 
                for ($x = 0; $x < $maxSem; $x++) {
                    echo '<th>Сем '.($x+1).'</th>';
                } 
            ?>
            <?php 
                for ($x = 0; $x < $maxSoril; $x++) {
                    echo '<th>Сорил '.($x+1).'</th>';
                } 
            ?>



            SELECT u.id, sl.point as onoo, sl.id as student_lesson_id,s.id as lesson_id, s.description, ct.name FROM 
((((course as c inner join class on c.id=class.course_id ) inner join lesson as s on s.class_id=class.id) 
inner join student_lesson as sl on sl.lesson_id=s.id) 
inner join user as u on u.id=sl.student_user_id) inner join class_type as ct on ct.id=s.class_type_id
             where c.id=1;







