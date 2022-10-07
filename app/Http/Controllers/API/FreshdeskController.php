<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use DB;

class FreshdeskController extends Controller
{

    public function __construct()
    {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    }
    public function addTicket(Request $request)
    {
        $data = $request->all();
        if($data['freshdesk_webhook']){
            $res        = $data['freshdesk_webhook'];

            $agent_name = $res['ticket_agent_name'];
            $description= $res['ticket_description'];
            $ticket_id  = $res['ticket_id'];
            $priority   = $res['ticket_priority'];
            $source     = $res['ticket_source'];
            $type       = $res['ticket_ticket_type'];
            $name       = $res['ticket_cf_name'];
            $status     = $res['ticket_status'];
            $subject    = $res['ticket_subject'];
            $tags       = $res['ticket_tags'];

            if(!ServiceRequest::where('ticket_id', $ticket_id)->first() && $ticket_id){
                $service    = new ServiceRequest();

                $service->ticket_id = $ticket_id;
                $service->name      = $name;
                $service->description = $description;
                $service->subject   = $subject;
                $service->request_date = date('Y-m-d H:i:s');
                $service->type      = 2;
                $service->source    = 2;
                $service->priority  = 2;
                $service->created_at= date('Y-m-d H:i:s');
                $service->status    = 2;

                $service->save();
            }
        }
    }

    public function updateTicket(Request $request)
    {
        $data = $request->all();
        if($data['freshdesk_webhook']){
            $res = $data['freshdesk_webhook'];
            $agent_name = $res['ticket_agent_name'];
            $description= $res['ticket_description'];
            $ticket_id  = $res['ticket_id'];
            $priority   = $res['ticket_priority'];
            $source     = $res['ticket_source'];
            $type       = $res['ticket_ticket_type'];
            $name       = $res['ticket_cf_name'];
            $status     = $res['ticket_status'];
            $subject    = $res['ticket_subject'];
            $tags       = $res['ticket_tags'];

            $isService  = ServiceRequest::where('ticket_id', $ticket_id)->first();
            if(!$isService && $ticket_id){
                $service    = new ServiceRequest();

                $service->ticket_id = $ticket_id;
                $service->name      = $name;
                $service->description = $description;
                $service->subject   = $subject;
                $service->request_date = date('Y-m-d H:i:s');
                $service->type      = 2;
                $service->source    = 2;
                $service->priority  = 2;
                $service->created_at= date('Y-m-d H:i:s');
                $service->status    = 2;
                $service->save();

            }elseif ($isService && $ticket_id) {
                $service = ServiceRequest::find($isService->id);
                $service->name      = $name;
                $service->description = $description;
                $service->subject   = $subject;
                $service->type      = 2;
                $service->source    = 2;
                $service->priority  = 2;
                $service->status    = 2;
                $service->save();
            }
        }
    }

}
