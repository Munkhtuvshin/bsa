<?php
require_once ROOT . '/controller/Controller.php';
class SurveyController extends Controller {
    public function __construct() {
		parent::__construct();
    }
    public function index() {
        require ROOT . '/view/survey/chat.php';
    }
}