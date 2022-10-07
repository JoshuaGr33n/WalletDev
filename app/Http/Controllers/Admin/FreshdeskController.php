<?php

namespace App\Http\Controllers\Admin;

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
        $data = json_decode($_REQUEST);
        if($data->freshdesk_webhook){
            $agent_name = $data->freshdesk_webhook->ticket_agent_name;
            $description= $data->freshdesk_webhook->ticket_description;
            $ticket_id  = $data->freshdesk_webhook->ticket_id;
            $priority   = $data->freshdesk_webhook->ticket_priority;
            $source     = $data->freshdesk_webhook->ticket_source;
            $type       = $data->freshdesk_webhook->ticket_ticket_type;
            $name       = $data->freshdesk_webhook->ticket_cf_name;
            $status     = $data->freshdesk_webhook->ticket_status;
            $subject    = $data->freshdesk_webhook->ticket_subject;
            $portal_url = $data->freshdesk_webhook->ticket_portal_url;
            $tags       = $data->freshdesk_webhook->ticket_tags;

            if(!ServiceRequest::where('ticket_id', $ticket_id)->first() && $ticket_id){
                $service    = new ServiceRequest();

                $service->ticket_id = $ticket_id;
                $service->product_id= '';
                $service->name      = $name;
                $service->description = $description;
                $service->subject   = $subject;
                $service->request_date = date('Y-m-d H:i:s');
                $service->group_id  = '';
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
        DB::table('admin_roles')->insert(
            array(
                'name' => 'qwerty', 
                'description' => 'Dayle'
            )
        );
        //$bodyContent = $request->getContent();
        $bodyContent = $request->all();
        $data = json_decode($bodyContent,true);
        //$data = 'Update Ticket';

        file_put_contents(public_path('uploads/test.txt'), $data, FILE_APPEND);

        if($data->freshdesk_webhook){
            $agent_name = $data->freshdesk_webhook->ticket_agent_name;
            $description= $data->freshdesk_webhook->ticket_description;
            $ticket_id  = $data->freshdesk_webhook->ticket_id;
            $priority   = $data->freshdesk_webhook->ticket_priority;
            $source     = $data->freshdesk_webhook->ticket_source;
            $type       = $data->freshdesk_webhook->ticket_ticket_type;
            $name       = $data->freshdesk_webhook->ticket_cf_name;
            $status     = $data->freshdesk_webhook->ticket_status;
            $subject    = $data->freshdesk_webhook->ticket_subject;
            $portal_url = $data->freshdesk_webhook->ticket_portal_url;
            $tags       = $data->freshdesk_webhook->ticket_tags;

            $isService  = ServiceRequest::where('ticket_id', $ticket_id)->first();
            if(!$isService && $ticket_id){
                $service    = new ServiceRequest();

                $service->ticket_id = $ticket_id;
                $service->product_id= '';
                $service->name      = $name;
                $service->description = $description;
                $service->subject   = $subject;
                $service->request_date = date('Y-m-d H:i:s');
                $service->group_id  = '';
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
                $service->group_id  = '';
                $service->type      = 2;
                $service->source    = 2;
                $service->priority  = 2;
                $service->status    = 2;
                $service->save();
            }
        }
    }

}
