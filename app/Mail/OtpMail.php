<?php
namespace App\Mail;

use Illuminate\Mail\Mailable;

class OtpMail extends Mailable
{
    public $otp;
    public $status;

    public function __construct($otp, $status= null )
    {
        $this->otp = $otp;
        $this->status = $status;
        
    }

    public function build()
    {
        return $this->subject('Yêu cầu đặt lại mật khẩu')
                    ->view('client.mail.otp'); 
    }
}
