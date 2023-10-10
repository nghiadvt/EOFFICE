<?php

namespace App\Console\Commands;

use App\Jobs\SendMailReminder;
use App\Models\User;
use App\Models\VanbanXuLy;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendReminderEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SendMail:Reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a word processing reminder email to';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
       $curDate = (new \DateTime('now', new \DateTimeZone('Asia/Ho_Chi_Minh')))->format('Y'.'-01-01');
        $vanbans = VanbanXuLy::where('vanban_xulys.status', '<>', 3)
            ->leftJoin('vanbans', 'vanbans.id', 'vanban_xulys.vanbanUser_id')
            ->leftJoin('users', 'users.id', 'vanban_xulys.id_nhan')
            ->select('users.email','users.id as idUser', 'vanban_xulys.id as id', 'vanbans.file_dinhkem as file', 'vanbans.id as idvanbanden', 'users.fullname as tenUserNhan', 'vanbans.title', 'vanbans.hanxuly')
            ->where('vanbans.book_id', 1)
            ->where('vanban_xulys.is_chuyentiep', 0)
            ->where('vanbans.isDelete', 1)
            ->where('vanbans.hanxuly', '<>', '')
            ->where('vanbans.hanxuly', '>', date('Y-m-d'))
            ->whereNotNull('vanbans.hanxuly')
            ->where('vanban_xulys.reminder', 0)
            ->whereBetween(\DB::raw("STR_TO_DATE(vanbans.hanxuly,'%Y-%m-%d')"),array($curDate, date('Y-m-d', strtotime( date('Y-m-d'). ' + 3 days'))))
            ->get();
        if (sizeof($vanbans) > 0){
            foreach ($vanbans as $vanban) {
                $vanban['link'] = url('eoffice/vanban/chi-tiet-van-ban-den/' . $vanban['idvanbanden']);
                $vanban['path'] = url('eoffice/vanban/dowload_file');
                $vanban['files'] = [$vanban['file']];
                $d = new SendMailReminder($vanban->toArray());
                dispatch($d);
            }
        }
        $this->info('Sent reminders to users');
    }
}
