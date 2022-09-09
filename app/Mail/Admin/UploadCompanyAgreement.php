<?php

namespace App\Mail\Admin;

use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UploadCompanyAgreement extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $company;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Company $company)
    {
        $this->company = $company;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Ladda upp avtal')
            ->markdown('emails.admin.company.upload-agreement');
    }
}
