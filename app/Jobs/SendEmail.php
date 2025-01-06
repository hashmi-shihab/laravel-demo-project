<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, \Illuminate\Bus\Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            Mail::send($this->data['blade'], $this->data, function ($message) {
                $message->to($this->data['to'])->subject($this->data['subject']);
                /*$message->from($this->data['from'],$this->data['from-head']);*/
                $message->from('noreply@xyz.com', 'noreply@xyz.com');
            });

            return true;
        } catch (\Throwable $th) {
            Log::info([
                'source' => 'Email-Job',
                'sending_status' => false,
                'blade' => $this->data['blade'],
                'email' => $this->data['to'],
                'exception' => $th->getMessage()
            ]);

            return false;
        }
    }
}
