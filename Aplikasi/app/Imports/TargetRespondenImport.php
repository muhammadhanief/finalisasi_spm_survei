<?php

namespace App\Imports;

use App\Models\TargetResponden;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Illuminate\Support\Str;

class TargetRespondenImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;
    protected $roleId;
    protected $importType;

    public function __construct($roleId, $importType)
    {
        $this->roleId = $roleId;
        $this->importType = $importType;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $emailParts = explode('@', $row['email']);
        $uniqueId = $emailParts[0] . Str::random(3);

        return new TargetResponden([
            'name' => $row['nama'],
            'email' => $row['email'],
            'role_id' => $this->roleId,
            'unique_code' => $uniqueId,
            'type' => $this->importType,
        ]);
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('target_respondens', 'email'),
            ],
        ];
    }
}
