<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class RenewalReminder extends Notification
{
    use Queueable;

    protected $subscription;

    public function __construct(object $subscription)
    {
        $this->subscription = $subscription;
    }

    public function via(object $notifiable): array
    {
        return ['database','mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $renewalDate = Carbon::parse($this->subscription->end_date)->format('F d, Y');
        $serviceName = $this->subscription->subject->name; 
        $serviceGrade = $this->subscription->subject->grade->name; 
        $renewalCost = number_format($this->subscription->price, 2, '.', ',');

        return (new MailMessage)
                    ->subject('Reminder: Your Subscription is Renewing Soon')
                    ->greeting('Hello ' . $notifiable->name . ',')
                    ->line("This is a reminder that your {$serviceName} - {$serviceGrade} subscription will automatically renew on {$renewalDate}.")
                    ->line("A charge of RM{$renewalCost} will be applied to your payment method.")
                    ->line('No action is required if you wish to continue your subscription.')
                    ->action('Manage Subscription', route('user.order-history'))
                    ->line('Thank you for using our application!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'subscription_id' => $this->subscription->id,
            'service_name' => $this->subscription->subject->name,
            'end_date' => Carbon::parse($this->subscription->end_date)->format('F d, Y'),
            'message' => 'Your ' . $this->subscription->subject->name . ' subscription will expire on ' . Carbon::parse($this->subscription->end_date)->format('F d, Y')
        ];
    }
}
