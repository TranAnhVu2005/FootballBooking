<?php

// Khai báo không gian tên (namespace) để tránh xung đột với các lớp khác
namespace App\Controllers;

// Định nghĩa lớp SSEController kế thừa từ lớp Controller cơ sở
class SSEController extends Controller
{
    /**
     * Phương thức stream() dùng để khởi tạo và duy trì luồng dữ liệu 
     * Server-Sent Events (SSE) gửi về trình duyệt của người dùng.
     */
    public function stream()
    {
        // Thiết lập Header để trình duyệt hiểu đây là luồng dữ liệu sự kiện (event-stream)
        header('Content-Type: text/event-stream');
        
        // Vô hiệu hóa bộ nhớ đệm (cache) để đảm bảo dữ liệu luôn được cập nhật mới nhất
        header('Cache-Control: no-cache');
        
        // Giữ cho kết nối luôn mở để có thể gửi dữ liệu liên tục
        header('Connection: keep-alive');

        // Gọi hàm nội bộ để tính toán số lượng người dùng thực sự đang truy cập
        $onlineUsers = $this->getRealOnlineUsersCount();

        // Tạo một mảng dữ liệu chứa số lượng người online và thời gian hiện tại
        $data = [
            'online_users' => $onlineUsers, // Số lượng người đang hoạt động
            'timestamp'    => date('H:i:s')   // Thời gian lúc gửi dữ liệu
        ];

        // Xuất dữ liệu theo định dạng chuẩn SSE: "data: {chuỗi JSON}\n\n"
        echo "data: " . json_encode($data) . "\n\n";
        
        // Đẩy nội dung từ bộ đệm đầu ra của PHP (output buffer) xuống trình duyệt ngay
        ob_flush();
        
        // Buộc hệ thống đẩy toàn bộ dữ liệu ra mạng để client nhận được tức thì
        flush();
        
        /**
         * Kết thúc chương trình tại đây để giải phóng tiến trình (worker) của server.
         * Phía trình duyệt (EventSource) sẽ tự động gọi lại sau khoảng 3 giây 
         * nếu không nhận được dữ liệu thêm, tạo thành một chu kỳ cập nhật.
         */
        exit;
    }

    /**
     * Hàm dùng để đếm số lượng người truy cập thực tế dựa trên cơ chế ghi nhận "nhịp tim".
     * Kết quả trả về là một số nguyên (int).
     */
    private function getRealOnlineUsersCount(): int
    {
        // Đường dẫn đến file JSON dùng để lưu trữ danh sách người dùng tạm thời
        $file = ROOTDIR . 'online_users.json';
        
        // Thời gian tối đa (giây) để giữ trạng thái online nếu không có phản hồi mới
        $timeout = 10; 
        
        // Biến chứa dữ liệu người dùng hiện tại, mặc định là mảng rỗng
        $currentData = [];
        
        // Nếu file dữ liệu đã tồn tại thì tiến hành đọc nội dung
        if (file_exists($file)) {
            // Đọc toàn bộ nội dung file JSON
            $content = file_get_contents($file);
            if ($content) {
                // Giải mã chuỗi JSON thành mảng PHP (associative array)
                $currentData = json_decode($content, true) ?: [];
            }
        }

        // Lấy thời gian hiện tại dưới dạng timestamp (số giây)
        $now = time();
        
        // Lấy mã phiên làm việc (Session ID) độc nhất của người dùng
        $sessionId = session_id();
        
        // Nếu chưa có session (ví dụ: khách chưa đăng nhập), tạo ID bằng IP và trình duyệt
        if (!$sessionId) {
            $sessionId = md5($_SERVER['REMOTE_ADDR'] . ($_SERVER['HTTP_USER_AGENT'] ?? ''));
        }

        // Cập nhật mốc thời gian hoạt động cuối cùng của người dùng này vào mảng
        $currentData[$sessionId] = $now;

        // Khởi tạo mảng mới để chỉ chứa những người vẫn còn đang hoạt động (active)
        $activeData = [];
        
        // Duyệt qua danh sách tất cả người dùng trong dữ liệu đã lưu
        foreach ($currentData as $sid => $timestamp) {
            // Nếu thời gian chênh lệch không quá timeout (10s) thì giữ lại
            if ($now - $timestamp <= $timeout) {
                $activeData[$sid] = $timestamp;
            }
        }

        // Ghi đè danh sách những người "còn sống" vào lại file JSON
        file_put_contents($file, json_encode($activeData));

        // Trả về tổng số lượng mã định danh còn lại trong danh sách active
        return count($activeData);
    }
}
