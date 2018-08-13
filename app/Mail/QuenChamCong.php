<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class QuenChamCong extends Mailable
{
    use Queueable, SerializesModels;

    public $quenMaChamCong;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($quen_ma_cham_cong,$ma_the_cham_cong)
    {
        $this->quenMaChamCong = $quen_ma_cham_cong;
        $this->maTheChamCong = $ma_the_cham_cong;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.quenmachamcong',[
            'ma_the_cham_cong'=>$this->maTheChamCong
        ]);
    }
}
