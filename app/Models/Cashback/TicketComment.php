<?php

namespace indiashopps\Models\Cashback;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TicketComment extends Model
{
    protected $table      = 'tb_ticket_comments';
    public    $timestamps = false;

    public function commentor()
    {
        switch ($this->added_by) {
            case 'admin':
                $user = 'Admin';
                break;

            default:
                $user = 'User';
                break;
        }

        return $user;
    }

    public function time()
    {
        return Carbon::parse($this->comment_time)->diffForHumans(Carbon::now());
    }
}
