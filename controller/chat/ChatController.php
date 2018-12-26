<?php
require_once ROOT . '/controller/Controller.php';
class ChatController extends Controller {
    public function __construct() {
		parent::__construct();
    }
    public function index() {
        require ROOT . '/view/chat/chat.php';
    }
}