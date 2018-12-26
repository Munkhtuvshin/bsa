<?php
class Controller {
    public function __construct() {
		$this->leftMenu = json_decode(file_get_contents(ROOT . '/database/left-menu.json'));
    }
}