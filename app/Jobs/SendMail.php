<?php

namespace App\Jobs;

use App\Models\ConfigMail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Vanbandi;
use Illuminate\Support\Facades\Mail;

class SendMail implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;


    protected $vanbandi;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($vanbandi)
    {
        $emailSend = ConfigMail::getList()->first();

        $vanbandi['EmailSend'] = $emailSend->mail;

        $this->vanbandi = $vanbandi;
        ConfigMail::where('mail', $emailSend->mail)->update(array('send' => $emailSend->send +1));
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->vanbandi;

        if (isset($data['noinhan'])) {
            $toUsers = [];
            for($i = 0, $l = sizeof($data['noinhan']); $i < $l; $i++) {
                $toUsers[] = (object) ['email' => $data['noinhan'][$i]];
            }

            sendMailMailer(['data' => $data], 'emails.vanbandi', $data['title'], $toUsers, (object) ['name' => 'Điều Hành Tác Nghiệp', 'email' => $data['EmailSend']]);
        }
    }
}
