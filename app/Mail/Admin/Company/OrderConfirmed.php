<?php

namespace App\Mail\Admin\Company;

use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmed extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $company;
    public $plans;
    public $form;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Company $company, $plans, $form)
    {
        $this->company = $company;
        $this->plans = $plans;
        $this->form = $form;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Tack för er beställning')
            ->view('emails.company.order-confirmation');
    }

    public function toText()
    {
        // code...
    }
}
