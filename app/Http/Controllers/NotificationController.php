<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationCollection;
use App\Models\DatabaseNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $notification = user()->notifications()
            ->paginate($request->get('rows', 6));
            // $notification = user()->notifications()->get();
           $unread = user()->notifications()->where('read_at','=',null)
            ->get()->count();

        return ["notification"=>$notification,"unread"=>$unread];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function notificationRead($id)
    {
        $data = DatabaseNotification::findOrFail($id);
        $data->update([
            'read_at' => Carbon::now(),
        ]);
        return ['data' => $data];
    }

    public function getAll(Request $request){
        $notification = user()->notifications();

        $notification = $notification->paginate($request->get('rows', 10));

        return NotificationCollection::collection($notification);


        // return ["data" =>$notification];
    }
}
