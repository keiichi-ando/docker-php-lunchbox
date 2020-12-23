<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersSheet extends Model
{
    use HasFactory;
    protected $primaryKey = 'orderdate';
    protected $casts = [
        'orderdate' => 'string',
        'ordered' => 'boolean',
    ];

    public function __construct()
    {
        parent::__construct();
        // $this->setCalendar();
    }

    public function getCalendar(): array
    {
        $g = new \DateTime();
        $startAtDayOfWeek = $g->setISODate(date('Y'), date('W'), 0);
        return $orderdates = $this->whereDate('orderdate', '>=', $startAtDayOfWeek)->orderBy('orderdate')->limit(28)->get(['orderdate'])->keyBy('orderdate')->toArray();
    }
}
