<?php

namespace App\Jobs;

use App\Models\ConfigMail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendMailGanHetHanXuLy implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;


    protected $vanbanganhethanxuly;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($vanbandi)
    {
        $emailSend = ConfigMail::getList()->first();

        $vanbandi['EmailSend'] = $emailSend->mail;


        ConfigMail::where('mail', $emailSend->mail)->update(array('send' => $emailSend->send +1));
        $this->vanbanganhethanxuly = $vanbandi;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->vanbanganhethanxuly;
        if (isset($data['noinhan'])) {
            $toUsers = [];
            for($i = 0, $l = sizeof($data['noinhan']); $i < $l; $i++) {
                $toUsers[] = (object) ['email' => $data['noinhan'][$i]];
            }


            sendMailMailer(['data' => $data], 'emails.vanbansaphethan', $data['title'], $toUsers, (object) ['name' => 'Điều Hành Tác Nghiệp', 'email' => $data['EmailSend']]);
        }
    }
}
