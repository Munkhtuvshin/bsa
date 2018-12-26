<?php
require_once ROOT . '/controller/Controller.php';
class NewsFeedController extends Controller {
    public function __construct() {
		parent::__construct();
    }
    public function index() {
        require ROOT . '/view/newsfeed/NewsFeed.php';
    }
}