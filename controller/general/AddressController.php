<?php
require_once ROOT . '/controller/Controller.php';
require_once ROOT . '/model/general/Address.php';
class AddressController extends Controller {
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
            $model = new Address();
            $addresses = $model->getAll();
            require ROOT . '/view/general/address.php';
        }
    }
    private function add() {
        if(isset($_POST['name']))
        {
            $model = new Address();
            $address = new stdClass();
            $address->name = $_POST['name'];
            $address->parent = $_POST['parent'];
            return $model->add($address);
        }
    }
    private function remove() {
        $id = $_POST['id'];
        if ($id > 0) {
            $model = new Address();
            return $model->remove($id);
        }
    }
    private function edit() {
        if(isset($_POST['name']))
        {
            $model = new Address();
            $address = new stdClass();
            $id = $_POST['id'];
            $address->name = $_POST['name'];
            $address->parent = $_POST['parent'];
            return $model->edit($id, $address);
        }
    }
}