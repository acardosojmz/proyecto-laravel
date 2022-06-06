<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Illuminate\Http\Response;
//use mikehaertl\wkhtmlto\Pdf;
//use Barryvdh\DomPDF\Facade\Pdf as PDF;

class PDFController extends Controller
{
    /**
     * Write code on Construct
     *
     * @return \Illuminate\Http\Response
     */
    public function preview()
    {
        return view('chart');
    }
  
    /**
     * Write code on Construct
     *
     * @return \Illuminate\Http\Response
     */
    /*
    public function download()
    {

        $pdf = PDF::loadView('chart', [
            		'title' => 'Frameworks',
            		'description' => 'This is an example for project elecciones ITVO',
            		'footer' => 'by ITVO'
            	]);
        
        
        return $pdf->download('frameworks.pdf');
    }
    */
    /*
    public function download() 
    {
        $render = view('chart')->render();
        $pdf = new Pdf;
        $options=['javascript-delay' => 5000,
        'isJavascriptEnabled'=>true,

        ];
        try {
            //$pdf->addPage(public_path('test.html'));
            $pdf->addPage($render);
            $pdf->setOptions($options);
            $success = $pdf->saveAs(public_path('pdf/frameworks.pdf'));
        }catch(\Exception $ex){
            echo $pdf->getError(); exit;
        }
        if (!$success){
            $message = $pdf->getError();
            return view('message',compact('message','success'));
        }else {
            return response()->download(public_path('pdf/frameworks.pdf'));
        }
    }*/
    public function download(){
        $pdf = \PDF::loadView('chart');
        $pdf->setOption('enable-javascript', true);
        $pdf->setOption('javascript-delay', 5000);
        $pdf->setOption('enable-smart-shrinking', true);
        $pdf->setOption('no-stop-slow-scripts', true);
        return $pdf->download('graph.pdf');
  
    }
}
