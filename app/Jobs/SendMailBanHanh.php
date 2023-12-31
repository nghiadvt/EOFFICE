<?php

namespace App\Jobs;

use App\Models\ConfigMail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailBanHanh implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    private $src;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
        $emailSend = ConfigMail::getList()->first();

        $this->src = [
            'name' => $data->name,
            'tenCoQuanBanHanh' => $data->tenCoQuanBanHanh,
            'tenDonviNhan' => $data->tenDonviNhan,
            'tenUserNhans' => $data->tenUserNhans,
            'thoigian_banhanh' => $data->thoigian_banhanh,
            'fileDinhKem' => $data->fileDinhKem,
            'file' => $data->file,
            'toUsers'=>$data->toUsers,
            'EmailSend'=>$emailSend->mail
        ];

        ConfigMail::where('mail', $emailSend->mail)->update(array('send' => $emailSend->send +1));
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $subject = 'Văn bản ban hành: ' . $this->src['name'];

        $toUsers = $this->src['toUsers'];


        sendMailMailer(['data' => $this->src], 'emails.vanbanbanhanh', $subject, $toUsers, (object)['name' => 'Điều Hành Tác Nghiệp', 'email' => $this->src['EmailSend']]);
    }
}
