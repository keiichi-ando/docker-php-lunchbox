<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ArrayLearn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'array:learn';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'array key learn';

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
     * @return int
     */
    public function handle()
    {
        $heads = [
            ['DNO' => '123456', 'NAME' => 'Mike davis'],
            ['DNO' => '223456', 'NAME' => 'Joe Maceen'],
            ['DNO' => '323456', 'NAME' => 'Hanae Kumano']
        ];
        $bodys = [
            ['DNO' => '123456', 'GNO'=>'1', 'VA' => 'Green'],
            ['DNO' => '123456', 'GNO'=>'2', 'VA' => 'Blue'],
            ['DNO' => '123456', 'GNO'=>'3', 'VA' => 'Red'],
            ['DNO' => '123456', 'GNO'=>'4', 'VA' => 'Orange'],
            ['DNO' => '123456', 'GNO'=>'5', 'VA' => 'Banana?'],
        ];
        $h = array_column($heads, null, 'DNO');
        foreach($bodys as $k => $v){
            $h[$v['DNO']]['details'][] = $v;
        }

        var_dump($h);

        return 0;
    }
}
