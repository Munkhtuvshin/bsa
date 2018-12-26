<?php
    require_once ROOT . '/controller/Controller.php';
    require_once ROOT . '/model/sticker/Sticker.php';
    class StickerController extends Controller {
        public function __construct() {
            parent::__construct();
        }
        public function index() {
            $model = new Sticker();
            $stickerAlbums = $model->getAllStickerAlbum();
            require ROOT . '/view/sticker/store.php';
        }
        public function getStickersByAlbum($id) {
            $model = new Sticker();
            $userSticker = new stdClass();
            $userSticker->album_id = $id;
            $userSticker->user_id = 1;
            $hasSticker = $model->userHasStickerAlbum($userSticker);
            $stickerAlbumName = $model->getStickerAlbumName($id);
            $stickers = $model->getStickersByAlbum($id);
            require ROOT . '/view/sticker/sticker.php';
        }
        public function toggleStickerToUser($id) {
            $model = new Sticker();
            $userSticker = new stdClass();
            $userSticker->album_id = $id;
            $userSticker->user_id = 1;
            if($model->userHasStickerAlbum($userSticker))
                $result = $model->removeStickerFromUser($userSticker);
            else
                $result = $model->addStickerToUser($userSticker);
            header('Location: /sticker/sticker');
        }
    }
?>