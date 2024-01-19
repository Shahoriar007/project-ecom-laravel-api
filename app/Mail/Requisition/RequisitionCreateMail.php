<?php

namespace App\Mail\Requisition;

use App\Models\User;
use App\Models\Requisition;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RequisitionCreateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $requisition;
    public $authUser;
    public $emails;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Requisition $requisition, User $authUser)
    {
        $this->requisition = $requisition;
        $this->authUser = $authUser;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = config('app.front_url') . "/panel/requisitions/{$this->requisition->id}";

        return $this->subject('New Requisition Generated')
            ->markdown('emails.requisitions.create', [
                'user' => $this->authUser,
                'requisition' => $this->requisition,
                'url' => $url
            ]);
    }
}
