<?php
require_once ROOT . '/model/PhotoEditor.php';
class PhotoEditorController {
    public function index() {
        
        require ROOT . '/view/PhotoEditor/index.php';
    }
}