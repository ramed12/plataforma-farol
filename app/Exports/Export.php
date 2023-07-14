<?php

namespace App\Exports;

use App\Exports\Contracts\ExportInterface;
use Maatwebsite\Excel\Concerns\Exportable;

class Export
{
    use Exportable;

    protected $report;
    protected $name;

    public function __construct(ExportInterface $report, $name = null)
    {
        $this->report = $report;
        $this->name   = $name;
    }

    private function getExtension(): string {

    	return pathinfo($this->getName(), PATHINFO_EXTENSION);
    }

    private function getFormat() {
		$extension = $this->getExtension();
    	switch ($extension) {
    		case 'csv':
    			return \Maatwebsite\Excel\Excel::CSV;
    		break;

    		case 'tsv':
    			return \Maatwebsite\Excel\Excel::TSV;
    		break;

    		case 'ods':
    			return \Maatwebsite\Excel\Excel::ODS;
    		break;

    		case 'html':
    			return \Maatwebsite\Excel\Excel::HTML;
    		break;

    		case 'pdf':
    			return \Maatwebsite\Excel\Excel::DOMPDF;
    		break;

    		default:
    			return \Maatwebsite\Excel\Excel::XLSX;
    		break;
    	}
    }

    private function getName(): string {

    	return  !is_null($this->name) ? $this->name : "relatorio-".date('Y-d-m-H-i-s').'.xlsx';
    }

    public function download() {
    	return ($this->report)->download($this->getName(), $this->getFormat());
    }

	// public function
}
