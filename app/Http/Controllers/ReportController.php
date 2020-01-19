<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JasperPHP\JasperPHP;

class ReportController extends Controller
{
    /**
     * [getDatabaseConfig description]
     * @return [array] [database connection parameters]
     */
    public function getDatabaseConfig()
    {
        return [
            'driver'   =>  env('DB_CONNECTION', 'mysql'),
            'host'     => env('DB_HOST', 'localhost'),
            'port'     => env('DB_PORT', '3306'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', 'root'),
            'database' => env('DB_DATABASE', 'sigalog'),
            'jdbc_dir' => base_path() . env('JDBC_DIR', '/vendor/cossou/jasperphp/src/jasperstarter/jdbc'),
        ];
    }

    /**
     * [getReport description]
     * @param  [string] $jrxmlFile  [source jrxml file]
     * @param  [string] $outputFile [output file]
     * @return [file]             [application/pdf]
     */
    public function getReport($jrxmlFile, $outputFile, $parameter=""){

        $jasper = new JasperPHP;


//      para gerar arquivo jarper
//    	$jasper->compile(base_path('public/reports/pessoas.jrxml'))->execute();

    	$output = public_path() . '/reports/' . time() . '_'.$outputFile;

//        dd($jasper->process(
        $jasper->process(
            //source ireport jrxml file
    		public_path().'/reports/'.$jrxmlFile,
            // nome output file
    		$output,
            // type output file
    		['pdf'],
            // parameters
            [
                'SUBREPORT_DIR' => public_path() . '/reports/', // para relatório master-detail
                'IMG_DIR'   => public_path() .'/img/'.env('LOGO','logo.png'),
                'USER_ID'   => auth()->id(),
            ],
            //database connection parameters
    		$this->getDatabaseConfig()
        )->execute();
//        )->output());



		$file = $output . '.pdf';
        $path = $file;

        // caso o arquivo não tenha sido gerado retorno um erro 404
        if (!file_exists($file)) {
            abort(404);
        }

        //caso tenha sido gerado pego o conteudo
        $file = file_get_contents($file);
        //deleto o arquivo gerado, pois iremos mandar o conteudo para o navegador
        unlink($path);
        // retornamos o conteudo para o navegador que íra abrir o PDF
        return response($file, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="temp.pdf"');

    }


    public function getReportParameter($parameter){

        $jasper = new JasperPHP;

//      para gerar arquivo jarper
//      $jasper->compile(base_path('public/reports/pessoas.jrxml'))->execute();
        
        $output = public_path() . '/reports/' . time() . '_pessoas';

        $jasper->process(
            //source ireport jrxml file
            public_path().'/reports/pessoas-parameter.jrxml',
            // nome output file
            $output,
            // type output file
            ['pdf'],
            // parameters
            [
                'IMG_DIR'   => public_path() .'/img/'.env('LOGO','logo.png'),
                'FILTRO'    => $parameter,
            ],
            //database connection parameters
            $this->getDatabaseConfig()                
        )->execute();


        $file = $output . '.pdf';
        $path = $file;
        
        // caso o arquivo não tenha sido gerado retorno um erro 404
        if (!file_exists($file)) {
            abort(404);
        }
        //caso tenha sido gerado pego o conteudo
        $file = file_get_contents($file);
        //deleto o arquivo gerado, pois iremos mandar o conteudo para o navegador
        unlink($path);
        // retornamos o conteudo para o navegador que íra abrir o PDF
        return response($file, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="temp.pdf"');
            
    }


    /**
     * [jsonToPdf description]
     * @return [file]             [application/pdf]
     */
    public function jsonToPdf(){
        $output = public_path() . '/reports/'.time().'_Contacts';
        $ext = "pdf";
        $driver = 'json';
        $json_query= "contacts.person";
        $data_file = public_path() . '/reports/contacts.json';
            
        $php_jasper = new JasperPHP;
        
        $php_jasper->process(
            public_path() . '/reports/json.jrxml',
            $output,
            array($ext),
            array(
                'IMG_DIR'   => public_path() .'/img/'.env('LOGO','logo.png'),
            ),
            array(
                'data_file' => $data_file, 
                'driver' => $driver, 
                'username' => 'root', 
                'json_query' => $json_query,
            )
        )->execute();        

        $file = $output . '.pdf';
        $path = $file;
        
        // caso o arquivo não tenha sido gerado retorno um erro 404
        if (!file_exists($file)) {
            abort(404);
        }
        //caso tenha sido gerado pego o conteudo
        $file = file_get_contents($file);
        //deleto o arquivo gerado, pois iremos mandar o conteudo para o navegador
        unlink($path);
        // retornamos o conteudo para o navegador que íra abrir o PDF
        return response($file, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="temp.pdf"');        
    }

}