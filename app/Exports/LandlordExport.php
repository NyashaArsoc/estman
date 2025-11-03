<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Auth;

class LandlordExport implements FromView
{
    protected $landlords;
    protected $from;
    protected $to;
    protected $landlordType;

    /**
     * Create a new export instance.
     *
     * @param \Illuminate\Support\Collection|array $landlords
     * @param string $from
     * @param string $to
     * @param string $landlordType
     */
    public function __construct($landlords, $from, $to, $landlordType)
    {
        $this->landlords = $landlords;
        $this->from = $from;
        $this->to = $to;
        $this->landlordType = $landlordType;
    }

    /**
     * Return a view for Excel export.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        return view('propman.reporting.landlords.landlords-export', [
            'landlords' => $this->landlords,
            'from' => $this->from,
            'to' => $this->to,
            'landlordType' => $this->landlordType,
            'user' => Auth::user(),
        ]);
    }
}