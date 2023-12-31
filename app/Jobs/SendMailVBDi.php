<?php

namespace App\Jobs;

use App\Models\ConfigMail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailVBDi implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;


    protected $vanbandi;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($vanbandi) {
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
    public function handle() {
        $data = $this->vanbandi;
        if (isset($data['emails']) && $data['emails']) {
            $toUsers = [];
            for($i = 0, $l = sizeof($data['emails']); $i < $l; $i++) {
                $toUsers[] = (object) ['email' => $data['emails'][$i]];
            }

            sendMailMailer(['data' => $data], 'emails.gui_mail_vanbandi', $data['title'], $toUsers, (object) ['name' => 'Điều Hành Tác Nghiệp', 'email' => env('MAIL_USERNAME', 'dieuhanh1@ac.udn.vn')]);
        }
    }
}
