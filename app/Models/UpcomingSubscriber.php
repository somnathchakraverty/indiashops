<?php

namespace indiashopps\Models;

use Illuminate\Database\Eloquent\Model;

class UpcomingSubscriber extends Model
{
    const CREATED_AT = 'subscribed_date';
    const UPDATED_AT = 'notification_sent_on';

    const USER_NOT_NOTIFIED = 0;
    const USER_NOTIFIED     = 1;
}
