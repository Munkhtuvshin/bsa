<?php
    require_once ROOT . '/controller/Controller.php';
    require_once ROOT . '/model/sticker/Admin.php';
    class AdminController extends Controller {
        public function __construct() {
            parent::__construct();
        }
        public function index() {
            $model = new Admin();
            $stickerAlbums = $model->getAllStickerAlbum();
            foreach($stickerAlbums as $stickerAlbum) {
                $stickerAlbum->stickers = $model->getStickersByAlbum($stickerAlbum->id);
            }
            require ROOT . '/view/sticker/admin.php';
        }
        public function deleteStickerAlbum($id) {
            $model = new Admin();
            $model->deleteStickerAlbum($id);
            header('Location: /sticker/admin');
        }
    }
?>