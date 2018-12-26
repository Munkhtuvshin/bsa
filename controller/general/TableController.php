<?php
require_once ROOT . '/controller/Controller.php';
require_once ROOT . '/model/general/Table.php';
class TableController extends Controller {
    public function __construct() {
		parent::__construct();
    }
    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            switch($_POST['action']) {
                case 'add': $this->add(); break;
                case 'edit': $this->edit(); break;
                case 'remove': $this->remove(); break;
            }
            header('Location: '.$_SERVER['REQUEST_URI']);
        } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $model = new Table();
            $tables = $model->getAll();
            require ROOT . '/view/general/table.php';
        }
    }
    private function add() {
        if(isset($_POST['name']))
        {
            $model = new Table();
            $table = new stdClass();
            $table->name = $_POST['name'];
            return $model->add($table);
        }
    }
    private function remove() {
        $id = $_POST['id'];
        if ($id > 0) {
            $model = new Table();
            return $model->remove($id);
        }
    }
    private function edit() {
        if(isset($_POST['name']))
        {
            $model = new Table();
            $table = new stdClass();
            $id = $_POST['id'];
            $table->name = $_POST['name'];
            return $model->edit($id, $table);
        }
    }
}