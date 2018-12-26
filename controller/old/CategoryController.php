<?php
require_once ROOT . '/model/category.php';
class CategoryController {
    public function showCategories() {
        $model = new Category();
        $categories = $model->getAll();
        $edit_state = false;
        require ROOT . '/view/tasks.php';
    }
}