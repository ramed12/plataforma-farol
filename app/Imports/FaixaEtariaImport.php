<?php

namespace App\Imports;

use Exception;
use App\Models\Grafico;
use Illuminate\Http\Request;
use App\Models\Indicador_theme;
use App\Models\Info_indicadores;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Database\Schema\Blueprint;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FaixaEtariaImport implements ToModel, WithHeadingRow
{
    protected $contactService;
    protected $request;


    public function __construct(Request $request) {
        //$this->contactService = $contactService;
        $this->request        = $request;

        // dd($request->all());
    }

    /**
    * @param array $row
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
            foreach($row as $reck => $value){
                if(in_array($reck, $this->request->input("fields"))){
                    $colunas = Schema::getColumnListing("info_indicadores");
                    if(!in_array($reck, $colunas)){
                        DB::statement("ALTER TABLE `info_indicadores` ADD `{$reck}` VARCHAR(255) NULL AFTER `enum`; ");
                    }
                    $this->request->merge([
                        $reck        => $value,
                    ]);
                }
            }
        return info_indicadores::create($this->request->except(['_token', 'file', 'fields']));
    }

    public function startRow(): int
    {
        return 2;
    }

}
