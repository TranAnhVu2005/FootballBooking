<?php

namespace App\Controllers;

use App\Models\Reviews;

class ReviewController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!AUTHGUARD()->isUserLoggedIn()) {
            redirect("/login");
        }
    }

    public function store()
    {
        verify_csrf_token();
        $fieldId = $_POST['field_id'];
        $content = $_POST['comment'];
        $review = new Reviews(PDO());
        $review->userId = AUTHGUARD()->user()->userId;
        $review->fieldId = $fieldId;
        $review->content = $content;
        $review->save();
        $linkRedirect = "/field/" . $fieldId;
        redirect($linkRedirect);
    }

    public function update()
    {
        verify_csrf_token();
        $reviewId = $_POST['review_id'];
        $fieldId = $_POST['field_id'];
        $content = $_POST['content'];
        $review = new Reviews(PDO());
        $review->update(AUTHGUARD()->user()->userId, $reviewId, $content);
        redirect("/field/" . $fieldId);
    }

    public function delete()
    {
        verify_csrf_token();
        $reviewId = $_POST['review_id'];
        $fieldId = $_POST['field_id'];
        $review = new Reviews(PDO());
        $review->delete(AUTHGUARD()->user()->userId, $reviewId);
        redirect("/field/" . $fieldId);
    }
}
