<?php

namespace App\Notifications\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CompanyCreated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $company;

    /**
     * Create a new event instance.
     *
     * @param  App\Models\Company $company
     * @return void
     */
    public function __construct($company)
    {
        $this->company = $company;

        $this->afterCommit();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject('Företaget har skapats')
            ->line('Företaget har skapats')
            ->line($this->company->name)
            ->line('Kontakt Person: ' . $this->company->contact->name)
            ->line('Kontakt Email: ' . $this->company->contact->email)
            ->action('Se Företaget', url(route('admin.company.edit', $this->company->id)));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
