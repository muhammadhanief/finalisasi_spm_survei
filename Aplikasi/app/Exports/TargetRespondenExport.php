<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\TargetResponden;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TargetRespondenExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $selectedRoleId;

    public function __construct($selectedRoleId)
    {
        $this->selectedRoleId = $selectedRoleId;
    }

    public function collection()
    {
        // Sesuaikan dengan logika query Anda
        return TargetResponden::select('name', 'email', 'type')->whereIn('role_id', $this->selectedRoleId)->get();
        // return TargetResponden::all();
    }

    public function headings(): array
    {
        return [
            'nama',
            'email',
            'tipe email'
        ];
    }
}
