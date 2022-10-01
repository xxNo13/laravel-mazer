<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Funct;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function print($print){
        $functs = Funct::all();

        $data = [
            'number' => 1,
            'functs' => $functs
        ];

        if ($print == 'ipcr') {
            $pdf = PDF::loadView('print.ipcr', $data);
            return $pdf->download('ipcr.pdf');
        } else {
            session()->flash('message', 'Invalid data. Not Found!');
        }
    }

    public function view(){
        $functs = Funct::all();

        return view('print.ipcr',[
            'functs' => $functs,
        ])->with('number', 1);
    }

}
