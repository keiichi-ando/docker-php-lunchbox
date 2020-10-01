<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $g = new \DateTime();
        foreach (range(0, 27) as $i) {
            $g->setISODate(date('Y'), date('W'), $i);
            $date[] = $g->format('Y-m-d');
        }
        $array[0] = array_slice($date, 0, 7); //1週目
        $array[1] = array_slice($date, 7, 7); // 2週目
        $array[2] = array_slice($date, 14, 7); // 3週目
        $array[3] = array_slice($date, 21); // 4週目

        $cal = [];
        foreach ($array as $key => $week) {
            foreach ($week as $day) {
                $cal[$key][] = ['date' => $day, 'ordered_menu' => '', 'can_change' => date('Y-m-d') < $day && \Auth::check() ? 'yes' : ''];
            }
        }
        return ["calendar"=> $cal, 'auth'=>\Auth::check()];
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
}
