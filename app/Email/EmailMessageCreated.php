<?php


namespace App\Email;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class EmailMessageCreated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    private $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    function build()
    {
        Log::channel('email')->info($this->message);

        return $this->from('info@example.com', 'EXAMPLE')
            ->subject('subject')
            ->view('email')->with([

            ]);
    }
}
