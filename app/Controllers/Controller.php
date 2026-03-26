<?php

namespace App\Controllers;

use League\Plates\Engine;

class Controller
{
    protected $view;

    public function __construct()
    {
        $this->view = new Engine(ROOTDIR . 'app/views');
    }

    /**
     * Phương thức sendPage() thực hiện việc render trang và 
     * áp dụng kỹ thuật HTTP Caching thông qua ETag.
     */
    public function sendPage($page, array $data = [])
    {
        // Bước 1: Tạo ra nội dung HTML của trang web
        $content = $this->view->render($page, $data);

        /**
         * Bước 2: Tạo mã vân tay (ETag) cho nội dung trang web.
         * Hàm md5($content) sẽ tạo ra một chuỗi băm duy nhất dựa trên nội dung.
         * Nếu nội dung trang web thay đổi dù chỉ 1 ký tự, mã ETag này sẽ thay đổi theo.
         */

        // "" để phù hợp chuẩn http
        $etag = '"' . md5($content) . '"';

        /**
         * Bước 3: Kiểm tra xem trình duyệt có gửi kèm tiêu đề "If-None-Match" hay không.
         * Tiêu đề này chứa mã ETag của lần truy cập trước đó mà trình duyệt đã lưu lại.
         */
        if (isset($_SERVER['HTTP_IF_NONE_MATCH']) && trim($_SERVER['HTTP_IF_NONE_MATCH']) === $etag) {
            /**
             * Bước 4: So sánh ETag cũ từ trình duyệt và ETag mới vừa tạo.
             * Nếu chúng giống hệt nhau (tức là nội dung trang web không hề thay đổi),
             * Server sẽ gửi mã trạng thái "304 Not Modified".
             */
            header("HTTP/1.1 304 Not Modified");

            // Kết thúc chương trình ngay tại đây, không cần gửi lại nội dung (tiết kiệm băng thông)
            exit;
        }

        /**
         * Bước 5: Nếu nội dung có thay đổi (hoặc lần đầu truy cập):
         * - Cache-Control: no-cache, must-revalidate: Yêu cầu trình duyệt luôn phải hỏi lại server
         *   trước khi sử dụng nội dung đã lưu trong bộ nhớ đệm (cache).
         * - ETag: Gửi mã vân tay mới để trình duyệt lưu lại cho lần kiểm tra sau.
         */
        header("Cache-Control: no-cache, must-revalidate");
        header("ETag: " . $etag);

        // Xuất toàn bộ nội dung HTML ra màn hình cho người dùng
        exit($content);
    }

    // Lưu các giá trị của form được cho trong $data vào $_SESSION 
    protected function saveFormValues(array $data, array $except = [])
    {
        $form = [];
        foreach ($data as $key => $value) {
            if (!in_array($key, $except, true)) {
                $form[$key] = $value;
            }
        }
        $_SESSION['form'] = $form;
    }

    protected function getSavedFormValues()
    {
        return session_get_once('form', []);
    }

    public function sendNotFound()
    {
        http_response_code(404);
        $this->sendPage("errors/404");
    }
}
