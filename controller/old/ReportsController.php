<?php
require_once ROOT . '/model/reports.php';
class ReportsController {
    public function index() {
        $model = new Reports();
        $reports = $model->getAll();
        $edit_state = false;
        require ROOT . '/view/user/report.php';
    }
    public function report() {
        $message = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['report_reason_id'])){
                $model = new User();
                $report = new stdClass();
                $report->name = $_POST['report_reason_id'];
                $result = $model->add($report);
                if ($result > 0){
                    $message = 'Амжилттай репортлолоо';
                } else {
                    $message = 'Репортолж  чадсангүй';
                }
            } else {
                $message = 'Шалтгаанаа оруулна уу';
            }
        }
        require ROOT . '/view/user/report.php';
    }
 
}