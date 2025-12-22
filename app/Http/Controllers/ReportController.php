<?php
namespace App\Http\Controllers;

use PDF;

class ReportController extends Controller
{
    public function export($id)
    {
        $data = [
            'project' => 'Demo Project',
            'criteria' => [
                ['name'=>'Traffic','score'=>8],
                ['name'=>'Visibility','score'=>7],
                ['name'=>'Accessibility','score'=>9],
            ]
        ];

        $pdf = PDF::loadView('reports.evaluation', $data);
        return $pdf->download('evaluation-report.pdf');
    }
}
