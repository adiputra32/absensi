<?php

namespace App\Exports;

use App\DetAbsensiKelas;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AbsensiKelasDosenExport implements FromArray, WithCustomStartCell, WithDrawings, WithStyles
{
    public function __construct(array $array)
    {
        $this->array = $array;
    }

    public function startCell(): string
    {
        return 'A1';
    }

    public function styles(Worksheet $sheet)
    {
        // KOP
        $sheet->getStyle('A1:A2')->getFont()->setBold(true);
        $sheet->getStyle('A9')->getFont()->setBold(true);
        $sheet->getStyle('A1:A2')->getFont()->setSize(14);
        $sheet->getStyle('A9')->getFont()->setSize(16);

        $sheet->mergeCells('A1:O1');
        $sheet->mergeCells('A2:O2');
        $sheet->mergeCells('A3:O3');
        $sheet->mergeCells('A4:O4');
        $sheet->mergeCells('D5:H5');
        $sheet->mergeCells('D6:H6');
        $sheet->mergeCells('I5:M5');
        $sheet->mergeCells('I6:M6');
        $sheet->mergeCells('A9:O9');
        $sheet->mergeCells('A11:C11');
        $sheet->mergeCells('A12:C12');
        $sheet->mergeCells('D11:E11');
        $sheet->mergeCells('D12:E12');
        $sheet->mergeCells('M11:N11');
        $sheet->mergeCells('M12:N12');

        $sheet->getStyle('A1:O9')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:O9')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A7:O7')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);

        // content
        $sheet->mergeCells('A14:A16');
        $sheet->mergeCells('B14:C16');
        $sheet->mergeCells('D14:H16');
        $sheet->mergeCells('I14:M16');
        $sheet->mergeCells('N14:O16');

        $sheet->getStyle('A14:O14')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);        
        $sheet->getStyle('A14:O14')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A14:O14')->getAlignment()->setWrapText(true);

        $sheet->getStyle('A14:A16')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A14:A16')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A14:A16')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A14:A16')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $sheet->getStyle('B14:C16')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('B14:C16')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('B14:C16')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('B14:C16')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $sheet->getStyle('D14:H16')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('D14:H16')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('D14:H16')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('D14:H16')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $sheet->getStyle('I14:M16')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('I14:M16')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('I14:M16')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('I14:M16')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $sheet->getStyle('N14:O16')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('N14:O16')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('N14:O16')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('N14:O16')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        
        $row = 143;
        $loopAbsen = 32;
        for ($i=17; $i <= $row; $i=$i+5) { 
            $sheet->getStyle('A1:O' . $i)->getFont()->setName('Times New Roman');
            if ($i == $loopAbsen) {
                $i3 = $i+3;
                $i5 = $i+5;
                $i7 = $i+7;
                $i8 = $i+8;
                $i10 = $i+10;
                $i12 = $i+12;
                $i13 = $i+13;
                $i17 = $i+17;

                $sheet->getStyle('A' . $i3 . ':O' . $i3)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
                $sheet->getStyle('A' . $i5)->getFont()->setSize(16);
                $sheet->getStyle('A' . $i5)->getFont()->setBold(true);
                $sheet->getStyle('A' . $i5)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);        
                $sheet->getStyle('A' . $i5)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                $sheet->mergeCells('A' . $i5 . ':O' . $i5);
                $sheet->mergeCells('A' . $i7 . ':C' . $i7);
                $sheet->mergeCells('A' . $i8 . ':C' . $i8);
                $sheet->mergeCells('D' . $i7 . ':E' . $i7);
                $sheet->mergeCells('D' . $i8 . ':E' . $i8);
                $sheet->mergeCells('M' . $i7 . ':N' . $i7);
                $sheet->mergeCells('M' . $i8 . ':N' . $i8);

                $sheet->mergeCells('A' . $i10 . ':A' . $i12);
                $sheet->mergeCells('B' . $i10 . ':C' . $i12);
                $sheet->mergeCells('D' . $i10 . ':H' . $i12);
                $sheet->mergeCells('I' . $i10 . ':M' . $i12);
                $sheet->mergeCells('N' . $i10 . ':O' . $i12);

                $sheet->getStyle('A' . $i10 . ':O' . $i10)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);        
                $sheet->getStyle('A' . $i10 . ':O' . $i10)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->getStyle('A' . $i10 . ':O' . $i10)->getAlignment()->setWrapText(true);

                $sheet->getStyle('A' . $i10 . ':A' . $i12)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('A' . $i10 . ':A' . $i12)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('A' . $i10 . ':A' . $i12)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('A' . $i10 . ':A' . $i12)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('B' . $i10 . ':C' . $i12)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('B' . $i10 . ':C' . $i12)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('B' . $i10 . ':C' . $i12)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('B' . $i10 . ':C' . $i12)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('D' . $i10 . ':H' . $i12)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('D' . $i10 . ':H' . $i12)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('D' . $i10 . ':H' . $i12)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('D' . $i10 . ':H' . $i12)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('I' . $i10 . ':M' . $i12)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('I' . $i10 . ':M' . $i12)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('I' . $i10 . ':M' . $i12)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('I' . $i10 . ':M' . $i12)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('N' . $i10 . ':O' . $i12)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('N' . $i10 . ':O' . $i12)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('N' . $i10 . ':O' . $i12)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('N' . $i10 . ':O' . $i12)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);


                // row3
                $sheet->mergeCells('A' . $i13 . ':A' . $i17);
                $sheet->mergeCells('B' . $i13 . ':C' . $i17);
                $sheet->mergeCells('D' . $i13 . ':H' . $i17);
                $sheet->mergeCells('I' . $i13 . ':M' . $i17);
                $sheet->mergeCells('N' . $i13 . ':O' . $i17);

                $sheet->getStyle('A' . $i13 . ':O' . $i13)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);        
                $sheet->getStyle('A' . $i13 . ':O' . $i13)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->getStyle('A' . $i13 . ':O' . $i13)->getAlignment()->setWrapText(true);

                $sheet->getStyle('A' . $i13 . ':A' . $i17)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('A' . $i13 . ':A' . $i17)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('A' . $i13 . ':A' . $i17)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('A' . $i13 . ':A' . $i17)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('B' . $i13 . ':C' . $i17)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('B' . $i13 . ':C' . $i17)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('B' . $i13 . ':C' . $i17)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('B' . $i13 . ':C' . $i17)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('D' . $i13 . ':H' . $i17)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('D' . $i13 . ':H' . $i17)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('D' . $i13 . ':H' . $i17)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('D' . $i13 . ':H' . $i17)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('I' . $i13 . ':M' . $i17)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('I' . $i13 . ':M' . $i17)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('I' . $i13 . ':M' . $i17)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('I' . $i13 . ':M' . $i17)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('N' . $i13 . ':O' . $i17)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('N' . $i13 . ':O' . $i17)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('N' . $i13 . ':O' . $i17)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('N' . $i13 . ':O' . $i17)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $loopAbsen = $loopAbsen+28;
                $i = $i13;
            } else {
                $j = $i+4;
                $sheet->mergeCells('A' . $i . ':A' . $j);
                $sheet->mergeCells('B' . $i . ':C' . $j);
                $sheet->mergeCells('D' . $i . ':H' . $j);
                $sheet->mergeCells('I' . $i . ':M' . $j);
                $sheet->mergeCells('N' . $i . ':O' . $j);

                $sheet->getStyle('A' . $i . ':O' . $j)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A' . $i . ':O' . $j)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->getStyle('A' . $i . ':O' . $j)->getAlignment()->setWrapText(true);

                $sheet->getStyle('A' . $i . ':A' . $j)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('A' . $i . ':A' . $j)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('A' . $i . ':A' . $j)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('A' . $i . ':A' . $j)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('B' . $i . ':C' . $j)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('B' . $i . ':C' . $j)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('B' . $i . ':C' . $j)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('B' . $i . ':C' . $j)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('D' . $i . ':H' . $j)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('D' . $i . ':H' . $j)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('D' . $i . ':H' . $j)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('D' . $i . ':H' . $j)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('I' . $i . ':M' . $j)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('I' . $i . ':M' . $j)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('I' . $i . ':M' . $j)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('I' . $i . ':M' . $j)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('N' . $i . ':O' . $j)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('N' . $i . ':O' . $j)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('N' . $i . ':O' . $j)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('N' . $i . ':O' . $j)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            }
        }

        $sheet->getStyle('A147:O156')->getFont()->setName('Times New Roman');
        $sheet->mergeCells('B149:E149');
        $sheet->mergeCells('B150:E150');
        $sheet->mergeCells('B151:E151');
        $sheet->getStyle('B149:E151')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); 
                
        return $sheet;
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/assets/img/logo.png'));
        $drawing->setHeight(112);
        $drawing->setOffsetX(15);
        $drawing->setOffsetY(5);
        $drawing->setCoordinates('B1');

        return $drawing;
    }

    public function array(): array
    {
        return $this->array;
    }
}
