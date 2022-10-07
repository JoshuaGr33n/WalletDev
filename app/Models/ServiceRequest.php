<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'service_request';

    protected $fillable = ['ticket_id','product_id','name','description','subject','request_date','group_id','type','source','priority', 'service_type_id', 'status'];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */

    public static function getDatatable() {
        $service = ServiceRequest::select('id', 'name', 'subject', 'request_date', 'group_id', 'type', 'priority', 'status', 'engineer_id', 'created_at')->orderBy('created_at', 'desc')
            ->get();
        return $service;
    }

    public function groupInfo()
    {
        return $this->hasOne('App\Models\TicketGroup', 'id', 'group_id');
    }
    public function sourceInfo()
    {
        return $this->hasOne('App\Models\TicketSource', 'id', 'source');
    }
    public function priorityInfo()
    {
        return $this->hasOne('App\Models\TicketPriority', 'id', 'priority');
    }
    public function statusInfo()
    {
        return $this->hasOne('App\Models\TicketStatus', 'id', 'status');
    }
}
