<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrdersSheet;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $od = new OrdersSheet();
        $cal = $od->getCalendar();
        // $cal = array_column($dates, 'orderdate', 'orderdate');

        // $array[0] = array_slice($date, 0, 7); //1週目
        // $array[1] = array_slice($date, 7, 7); // 2週目
        // $array[2] = array_slice($date, 14, 7); // 3週目
        // $array[3] = array_slice($date, 21); // 4週目

        if (\Auth::check()) {
            $orders = Order::select(['id', 'plan_id', 'target_date'])->where('user_id', \Auth::user()->id)->whereDate('target_date', '>=', $cal[0])->orderBy('target_date')->get()->keyBy('target_date')->toArray();
            array_merge($cal, $orders);
        }
        // $cal = [];
        // foreach ($array as $key => $week) {
        //     foreach ($week as $day) {
        //         $cal[$key][] = ['date' => $day, 'ordered_id' => $orders[$day]['id'] ?? '', 'ordered_plan_id' => $orders[$day]['plan_id'] ?? '', 'can_change' => date('Y-m-d') < $day && \Auth::check()];
        //     }
        // }
        return ['calendar' => $cal, 'auth' => \Auth::check()];
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
        \Log::debug(\Auth::user()->name . ',' . json_encode([$request->input('planid'), $request->input('img')], JSON_UNESCAPED_UNICODE));

        $images = $request->input('img');
        // 画像保存
        foreach ($images as $img) {
            @list($type, $src) = explode(';', $img['src']);
            @list(, $src) = explode(',', $src);
            $filename = $request->input('planid') . '/' . $img['id'] . '.' . 'png';
            Storage::disk('public_images')->put($filename, base64_decode($src));
        }
        return ['message' => 'success']; //
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
}
