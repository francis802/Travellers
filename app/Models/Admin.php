<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\ReportNotification;
use App\Models\HelpNotification;
use App\Models\GroupCreationNotification;
use App\Models\AppealNotification;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admin';
    public $timestamps  = false;
    protected $primaryKey = 'user_id';

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function reportNotifications(){
        return $this->hasMany('App\Models\ReportNotification', 'notified_id', 'user_id');
    }

    public function helpNotifications(){
        return $this->hasMany('App\Models\HelpNotification', 'notified_id', 'user_id');
    }

    public function groupCreationNotifications(){
        return $this->hasMany('App\Models\GroupCreationNotification', 'notified_id', 'user_id');
    }

    public function appealNotifications(){
        return $this->hasMany('App\Models\AppealNotification', 'notified_id', 'user_id');
    }


    public function getReportNotifications(){
        $this->reportNotifications()->where('opened', false)->update(['opened' => true]);
        return $this->reportNotifications()->orderBy('time', 'desc')->get();
    }

    public function getHelpNotifications(){
        $this->helpNotifications()->where('opened', false)->update(['opened' => true]);
        return $this->helpNotifications()->orderBy('time', 'desc')->get();
    }

    public function getGroupCreationNotifications(){
        $this->groupCreationNotifications()->where('opened', false)->update(['opened' => true]);
        return $this->groupCreationNotifications()->orderBy('time', 'desc')->get();
    }

    public function getAppealNotifications(){
        $this->appealNotifications()->where('opened', false)->update(['opened' => true]);
        return $this->appealNotifications()->orderBy('time', 'desc')->get();
    }
   

    public function unseenNotifications(){
        $report_count = ReportNotification::where('notified_id', Auth::user()->id)->where('opened', false)->count();
        $help_count = HelpNotification::where('notified_id', Auth::user()->id)->where('opened', false)->count();
        
        $appeal_count = AppealNotification::where('notified_id', Auth::user()->id)->where('opened', false)->count();
        $group_creation_count = GroupCreationNotification::where('notified_id', Auth::user()->id)->where('opened', false)->count();

        $total_unseen = $report_count + $help_count + $appeal_count + $group_creation_count;

        return $total_unseen;
    }
}