<?php
require_once ROOT . '/model/jurnal.php';
class JurnalController {
    public function index() {
        $model = new Jurnal();
        $jurnalList = $model->getAll();
        require ROOT . '/view/jurnal/index.php';
    }
    public function jurnalDetail() {
        $message = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['studentId']) && isset($_POST['dvn'])) {
                $stdId = $_POST['studentId'];
                $dvn = $_POST['dvn'];
                $model = new Jurnal();
                $model->addStudentPoint($stdId, $dvn);
            }
            if(isset($_POST['id'])) {
                $id = $_POST['id'];
                $model = new Jurnal();
                $jurnal = $model->getOne($id);
            }
            else {
                $message = 'Алдаа гарлаа!';
            }
        }
        require ROOT . '/view/jurnal/jurnalDetail.php';
    }
}