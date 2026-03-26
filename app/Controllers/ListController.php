<?php


namespace App\Controllers;

use App\Models\Fields;

class ListController extends Controller
{
    public function index()
    {
        $fieldModel = new Fields(PDO());
        $keyword = $_GET['keyword'] ?? '';
        $type = $_GET['type'] ?? '';

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;   // Chặn người dùng nhập vào url page = -1 chẳng hạn
        $limit = 12;
        $offset = ($page - 1) * $limit;

        $listAllField = $fieldModel->searchFields($keyword, $type, $limit, $offset);
        $totalRecords = $fieldModel->countSearchFields($keyword, $type);
        $totalPages = ceil($totalRecords / $limit);
        $types = $fieldModel->allTypes();

        $this->sendPage('list', [
            'listFields' => $listAllField,
            'types' => $types,
            'keyword' => $keyword,
            'selectedType' => $type,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalRecords' => $totalRecords,
            'limit' => $limit
        ]);
    }
}
