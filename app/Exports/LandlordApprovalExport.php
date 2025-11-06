<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LandlordApprovalExport implements FromView
{
    protected $landlords;
    protected $user;
    protected $from;
    protected $to;

    public function __construct($landlords, $user, $from, $to)
    {
        $this->landlords = $landlords;
        $this->user = $user;
        $this->from = $from;
        $this->to = $to;
    }

    public function view(): View
    {
        return view('propman.reporting.diary.landlord.exports.approval-history', [
            'landlords' => $this->landlords,
            'user' => $this->user,
            'from' => $this->from,
            'to' => $this->to,
        ]);
    }
}
