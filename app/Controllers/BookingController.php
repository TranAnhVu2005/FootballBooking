<?php

namespace App\Controllers;

use App\Models\Booking;
use App\Models\Fields;
use App\Models\FieldSlot;

class BookingController extends Controller
{
    public function __construct()
    {
        // Yêu cầu đăng nhập để sử dụng tính năng đặt sân
        if (!AUTHGUARD()->isUserLoggedIn()) {
            redirect('/login');
        }
        parent::__construct();
    }

    public function index()
    {
        $user = AUTHGUARD()->user();
        $bookings = (new Booking(PDO()))->findByUserId($user->userId);

        $this->sendPage('booking/index', [
            'bookings' => $bookings,
            'messages' => session_get_once('messages'),
            'errors'   => session_get_once('errors')
        ]);
    }

    public function create()
    {
        $fieldId = $_GET['field'] ?? '';
        $slotId = $_GET['slot'] ?? '';
        $date = $_GET['date'] ?? date('Y-m-d');

        if (!$fieldId || !$slotId || !$date) {
            redirect('/list', ['errors' => ['system' => 'Thông tin đặt sân không hợp lệ.']]);
        }

        // Kiểm tra tính hợp lệ của ngày đặt (không đặt trong quá khứ)
        $selectedDate = strtotime($date);
        $today = strtotime(date('Y-m-d'));
        if ($selectedDate < $today) {
            redirect('/field/' . $fieldId, ['errors' => ['system' => 'Không thể đặt sân trong quá khứ.']]);
        }

        $field = (new Fields(PDO()))->findById($fieldId);
        $slot = (new FieldSlot(PDO()))->findById($slotId);

        if (!$field || strtoupper($field->status) !== 'ACTIVE' || !$slot || !$slot->isActive) {
            redirect('/list', ['errors' => ['system' => 'Sân hoặc khung giờ không khả dụng.']]);
        }

        // Kiểm tra xem khung giờ còn trống không hay đã bị đặt mất
        $bookingModel = new Booking(PDO());
        $bookedSlotIds = $bookingModel->getBookedSlotIds($fieldId, $date);
        if (in_array($slotId, $bookedSlotIds)) {
            redirect('/field/' . $fieldId . '?date=' . $date, ['errors' => ['system' => 'Khung giờ này đã được đặt, vui lòng chọn khung giờ khác.']]);
        }

        $this->sendPage('booking/create', [
            'field' => $field,
            'slot' => $slot,
            'date' => $date
        ]);
    }

    public function store()
    {
        verify_csrf_token();

        $fieldId = $_POST['field_id'] ?? '';
        $slotId = $_POST['slot_id'] ?? '';
        $date = $_POST['date'] ?? '';
        $note = trim($_POST['note'] ?? '');
        $paymentMethod = $_POST['payment_method'] ?? 'Tiền mặt';

        if (!$fieldId || !$slotId || !$date) {
            redirect('/list', ['errors' => ['system' => 'Thông tin không hợp lệ.']]);
        }

        $field = (new Fields(PDO()))->findById($fieldId);
        $slot = (new FieldSlot(PDO()))->findById($slotId);

        if (!$field || strtoupper($field->status) !== 'ACTIVE' || !$slot || !$slot->isActive) {
            redirect('/field/' . $fieldId, ['errors' => ['system' => 'Sân hoặc khung giờ không khả dụng.']]);
        }

        $bookingModel = new Booking(PDO());
        $bookedSlotIds = $bookingModel->getBookedSlotIds($fieldId, $date);
        if (in_array($slotId, $bookedSlotIds)) {
            redirect('/field/' . $fieldId . '?date=' . $date, ['errors' => ['system' => 'Xin lỗi, khung giờ này vừa được người khác đặt.']]);
        }

        $user = AUTHGUARD()->user();

        $booking = new Booking(PDO());
        $booking->userId = $user->userId;
        $booking->fieldId = $field->fieldId;
        $booking->slotId = $slot->fieldSlotId;
        $booking->bookingDate = $date;
        $booking->totalPrice = $slot->price;
        $booking->paymentMethod = $paymentMethod;
        $booking->paymentStatus = 'Chưa thanh toán';
        $booking->status = 'Đã đặt';
        $booking->note = $note ?: null;

        if ($booking->save()) {
            redirect('/bookings', ['messages' => ['success' => 'Đặt sân thành công!']]);
        } else {
            redirect('/field/' . $fieldId . '?date=' . $date, ['errors' => ['system' => 'Có lỗi xảy ra khi đặt sân. Vui lòng thử lại.']]);
        }
    }

    public function cancel(string $id)
    {
        verify_csrf_token();

        $user = AUTHGUARD()->user();
        $bookingModel = new Booking(PDO());
        $booking = $bookingModel->findById($id);

        if (!$booking || $booking->userId !== $user->userId) {
            redirect('/bookings', ['errors' => ['system' => 'Không tìm thấy hóa đơn đặt sân hợp lệ.']]);
        }

        if ($booking->status !== 'Đã đặt') {
            redirect('/bookings', ['errors' => ['system' => 'Không thể hủy hóa đơn này vì đã thay đổi trạng thái.']]);
        }

        // Chỉ cho phép hủy đơn đặt sân đối với ngày hiện tại hoặc tương lai
        $selectedDate = strtotime($booking->bookingDate);
        $today = strtotime(date('Y-m-d'));
        if ($selectedDate < $today) {
            redirect('/bookings', ['errors' => ['system' => 'Không thể hủy sân đã đặt trong quá khứ.']]);
        }

        $booking->status = 'Đã hủy';

        if ($booking->save()) {
            redirect('/bookings', ['messages' => ['success' => 'Đã hủy đặt sân thành công.']]);
        } else {
            redirect('/bookings', ['errors' => ['system' => 'Có lỗi trong quá trình hủy đặt sân.']]);
        }
    }
}
