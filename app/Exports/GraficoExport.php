<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Exports\Contracts\GraficoExportInterface;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Exports\Contracts\ExportInterface;

class GraficoExport implements GraficoExportInterface, ExportInterface, FromCollection, WithHeadings, WithMapping, WithDrawings, WithCustomStartCell, WithStyles, WithTitle, ShouldAutoSize
{
    use Exportable;

    protected $grafico;

    public function __construct($grafico)
    {
        $this->grafico = $grafico;
    }

    public function collection()
    {
        return $this->grafico;
    }

    public function map($grafico): array
    {

        dd($grafico);
        // return [
        //     $grafico->id,
        //     $grafico->total,
        //     $grafico->homens,
        //     $grafico->mulheres,
        //     $grafico->grupo_idades,
        //     $grafico->estado
        // ];
    }

    public function headings(): array
    {
        return [
            ['RELATÓRIO DE CONTATOS'],
            [''],
            [''],
            [
                'id',
                'Total',
                'Homens',
                'Mulheres',
                'Grupo de idades',
                'Estado'
            ]

        ];
    }

    public function title(): string
    {
        return 'Relatório de Contatos';
    }

    public function drawings()
    {
        $drawings = [];

        $drawing = new Drawing();
        $drawing->setPath(public_path('logo.jpg'));
        $drawing->setHeight(25);
        $drawing->setCoordinates('A1');
        $drawing->setOffsetX(20);
        $drawing->setOffsetY(10);
        $drawings[] = $drawing;

        return $drawings;
    }

    public function startCell(): string
    {
        return 'A1';
    }

    public function styles(Worksheet $sheet)
    {
        //Logo
        $sheet->mergeCellsByColumnAndRow(1,1,3,3);
        $sheet->getStyle('A1:F4')->applyFromArray([
            'fill' => [
                'fillType'   => Fill::FILL_GRADIENT_LINEAR,
                'rotation'   => '180deg',
                'startColor' => [
                    'rgb' => '2b4868'
                ],
                'endColor' => [
                    'rgb' => '0d1620'
                ]
                //0d1620
            ],
            'font' => [
                'bold' => true,
                'color' => [
                    'rgb' => 'FFFFFF'
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                // 'vertical'   => Alignment::VERTICAL_CENTER
            ]
        ]);

        //Cabeçalho Colunas
        $sheet->getStyle('A4:F4')->applyFromArray([
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '2b4868'
                ],
            ],
            'font' => [
                'bold' => true,
                'color' => [
                    'rgb' => 'FFFFFF'
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT
            ]
        ]);
    }
}
