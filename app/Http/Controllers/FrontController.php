<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\GdeController;
use Illuminate\Support\Str;


class FrontController extends Controller
{
    public function index(Request $request) {
    	$numeroDocumento='';
    	$visibilidad='';
        $docParam['actuacion'] = $docParam['anio'] = $docParam['numero'] = $docParam['ecosistema'] = $docParam['reparticion'] = '';

    	if ($request->is('doc/*')) {
    		// quito la primer ruta del path
    		$path_clean = preg_replace("/doc\//", "", $request->path());

    		// separo el path en los dos o X base64
			$parts = explode('/',$path_clean);

    	if(sizeof($parts)>1) {
    		// tomo el último elemento como "visibilidad"
    		$visibilidad = end($parts);
    		
    		// quito el último elemento
    		array_pop($parts);

    		// unifico las partes del path divididas por '/' porque es un caracter válido base64
    		$numeroDocumento_b64 = implode('/', $parts);
    	} else {
    		$numeroDocumento_b64 = end($parts); 
    	}

    	$numeroDocumento = base64_decode(trim($numeroDocumento_b64));

        $partes = explode('-',$numeroDocumento);
        $docParam['actuacion'] = $partes[0];
        $docParam['anio'] = $partes[1];
        $docParam['numero'] = $partes[2];
        $docParam['ecosistema'] = $partes[3];
        $docParam['reparticion'] = $partes[4];
        $docParam['submit'] = true;

		}
		  //dd($docParam);
    	return view('index', ['docParam'=>$docParam]);
    }

    public function error() {
        return view('error');
    }

    public function consulta(Request $request) {
        //dd($request);
        $nroDocumento = implode('-',[$request->actuacion,$request->anio,str_pad($request->numero,8,'0',STR_PAD_LEFT),$request->ecosistema,$request->reparticion]); 
        $nroDocumento = strtoupper($nroDocumento);

        $reservado = true;// false = no es reservado
        $existe = false;
        $qr = false; // que se puede consultar por QR
        $qrPublico = false; // que no necesita verificacion
        $detalle = null;
        $pdf = null;

        //dump($nroDocumento);

        $GDE = new GdeController;
        $GDE->auth();
        $detalle = $GDE->getDetalleDocumento($nroDocumento);

        //dd($detalle);
        switch ($detalle['status']) {
    
            // existe y no es reservado
            case 200:
                $existe = true;
                $reservado = false;
                break;

            // no existe o es reservado
            case 500:
                // es reservado
                if( strpos($detalle['content']['message'], 'privilegios') !== false  ) {
                    // dd(['privilegios',$detalle['content']['message']]);
                    $existe = true;
                    $reservado = true;
                }

                // no existe
                if( strpos($detalle['content']['message'], 'no existe') !== false  ) {
                    // dd(['privilegios',$detalle['content']['message']]);
                    $existe = false;
                }
                break;
            
        }

        // $pdf = $GDE->getDocument($nroDocumento);
        if ($existe && !$reservado) {

            $pdf = $GDE->getDocument($nroDocumento, false, true); // nro, sin CV, "ping"
            \Log::info([__FUNCTION__,$pdf]);
            switch ($pdf['status']) {
                // consultable por qr y sin codigo
                case 200:
                    $qr = true;
                    $qrPublico = true;
                    break;
                
                // no consultable por qr o solo con código
                case 500:
                    if( strpos($pdf['content']['message'], 'Codigo es obligatorio') !== false  ) {
                        // dd(['privilegios',$detalle['content']['message']]);
                        $qr = true;
                        $qrPublico = false;
                        }

                    if( strpos($pdf['content']['message'], 'no tiene Código QR') !== false  ) {
                        // dd(['privilegios',$detalle['content']['message']]);
                        $qr = false;
                        $qrPublico = false;
                        }

                    if( strpos($pdf['content']['message'], '] incorrecto') !== false  ) {
                        // dd(['privilegios',$detalle['content']['message']]);
                        $qr = true;
                        $qrPublico = false;
                        }
                    break;
                
            }
        }

        $gedo = [
            'existe' => $existe,
            'reservado'=> $reservado,
            'qr' => $qr,
            'qrPublico' => $qrPublico,
            'nroDocumento' => $nroDocumento
        ];
        $gedoDetalle = $detalle;
        $gedoPdf = $pdf;
        
        
        return view('metadata',['gedo' =>$gedo, 'detalle'=>$detalle, 'pdf'=>$pdf]);
    }

    public function verPdf(Request $request) {
        $nroDocumento = $request->nroDocumento;
        $codigoValidacion  = $request->codigoVerificador;
        $GDE = new GdeController;
        $GDE->auth();
        $pdf = $GDE->getDocument($nroDocumento, $codigoValidacion, false);
        $pdf['numeroDocumento'] = $nroDocumento;

        if($pdf['status'] == 500 && (strpos($pdf['content']['message'],'] incorrecto' ) !==false)) {
            $pdf['status'] = 401;

        }
            return view('viewer',['response'=>$pdf]);
    }

}
