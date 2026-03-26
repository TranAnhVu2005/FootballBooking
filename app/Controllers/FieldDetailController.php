<?php

namespace App\Controllers;

use App\Models\Fields;
use App\Models\FieldSlot;
use App\Models\Booking;
use App\Models\Reviews;

class FieldDetailController extends Controller
{
    public function index(string $id)
    {
        $field = (new Fields(PDO()))->findById($id);

        if (!$field || strtoupper($field->status) !== 'ACTIVE') {
            $this->sendNotFound();
        }

        $date = $_GET['date'] ?? date('Y-m-d');
        if (!strtotime($date)) {
            $date = date('Y-m-d');
        }

        // Chỉ lấy slot đang active (is_active = true)
        $slots = (new FieldSlot(PDO()))->findActiveByField($id);

        // Lấy danh sách slot đã được đặt
        $bookedSlotIds = (new Booking(PDO()))->getBookedSlotIds($id, $date);

        //Bình luận
        $reviews = (new Reviews(PDO()))->findByField($field->fieldId);

        $this->sendPage('field_detail', [
            'field' => $field,
            'slots' => $slots,
            'date' => $date,
            'bookedSlotIds' => $bookedSlotIds,
            'reviews' => $reviews
        ]);
    }
}
