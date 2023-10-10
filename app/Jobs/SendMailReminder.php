<?php

namespace App\Jobs;

use App\Models\ConfigMail;
use App\Models\VanbanXuLy;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendMailReminder implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;


    protected $vanbannhacnho;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($datas)
    {

        $emailSend = ConfigMail::select('config_mails.*')->orderBy('send', 'ASC')->first();
        $datas['EmailSend'] = $emailSend->mail;
        $datas['PassSend'] = $emailSend->password;

        $this->vanbannhacnho = $datas;
        ConfigMail::where('mail', $emailSend->mail)->update(array('send' => $emailSend->send +1));
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->vanbannhacnho;
        sendMailMailer(['data' => $data], 'emails.gui_mail_nhacnho_xuly', $data['title'], 'nhacnho', (object) ['name' => 'Điều Hành Tác Nghiệp', 'email' => $data['EmailSend'],  'password' => $data['PassSend']]);
        VanbanXuLy::where('id', $data['id'])->update(['reminder' => 1]);
    }
}
