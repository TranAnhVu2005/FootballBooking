<?php

namespace App\Controllers;

use App\Models\Fields;

class HomeController extends Controller
{
    public function __construct()
    {
        // Trang chủ có thể xem mà không cần đăng nhập
        parent::__construct();
    }

    public function index()
    {
        // Lấy 4 sân nổi bật nhất từ DB để hiển thị trên trang chủ
        $fieldModel = new Fields(PDO());
        $featuredFields = $fieldModel->findFeatured(4);
        $types = $fieldModel->allTypes();

        $this->sendPage('home', [
            'featuredFields' => $featuredFields,
            'types' => $types
        ]);
    }
}
