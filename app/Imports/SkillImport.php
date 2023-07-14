<?php

namespace App\Imports;

use App\Models\Admin\Skill;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Auth;

class SkillImport implements ToModel, WithHeadingRow
{
    private $main_functional_area_id;

    public function __construct($main_functional_area_id, $is_active)
    {
        $this->main_functional_area_id = $main_functional_area_id;
        $this->is_active = $is_active;
        
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Skill([
            'name' => $row['name'],
            'main_functional_area_id' => $this->main_functional_area_id,
            'is_active' => $this->is_active,
            'created_by' => Auth::user()->id
        ]);
    }
}
