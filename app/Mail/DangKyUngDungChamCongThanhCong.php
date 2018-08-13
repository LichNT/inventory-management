<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DangKyUngDungChamCongThanhCong extends Mailable
{
    use Queueable, SerializesModels;

    public $dangKyUngDungChamCong;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($dang_ky_ung_dung_cham_cong)
    {
        $this->dangKyUngDungChamCong = $dang_ky_ung_dung_cham_cong;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.thongbaodangkyungdungchamcongthanhcong');
    }
}
