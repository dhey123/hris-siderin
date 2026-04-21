<?php

namespace App\Exports\Sheets;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class MasterSheet implements FromCollection, WithTitle
{
    protected string $title;
    protected Collection $data;

    public function __construct(string $title, Collection $data)
    {
        $this->title = $title;
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data->map(fn ($v) => [$v]);
    }

    public function title(): string
    {
        return $this->title;
    }
}
