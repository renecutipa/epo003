<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Afiliado;
use DB;
use Excel;

class ExcelController extends Controller
{
    //

    public function importExport()
    {
        return view('importExport');
    }
 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadExcel($type)
    {
        $data = Item::get()->toArray();
            
        return Excel::create('itsolutionstuff_example', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download($type);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function importExcel(Request $request)
    {
        if($request->hasFile('import_file')){
			$path = $request->file('import_file')->getRealPath();
			$data = Excel::load($path, function($reader) {
			})->get();
			if(!empty($data) && $data->count()){
				foreach ($data as $key => $value) {
					//dd($data);
					$insert[] = [
						'afi_depa' => $value->afi_depa,
						'afi_prov' => $value->afi_prov,
						'afi_dist' => $value->afi_dist,
						'pre_CodEjeAdm' => $value->pre_codejeadm,
						'afi_IdEESSAte' => $value->afi_ideessate,
						'pre_Nombre' => $value->pre_nombre,
						'afi_IdDisa' => $value->afi_iddisa,
						'afi_IdDistrito' => $value->afi_iddistrito,
						'afi_TipoFormato' => $value->afi_tipoformato,
						'afi_NroFormato' => $value->afi_nroformato,
						'afi_IdTipoDocumento' => $value->afi_idtipodocumento,
						'afi_Dni' => $value->afi_dni,
						'afi_FecFormato' => $value->afi_fecformato,
						'afi_ApePaterno' => $value->afi_apepaterno,
						'afi_ApeMaterno' => $value->afi_apematerno,
						'afi_Nombres' => $value->afi_nombres,
						'afi_SegNombre' => $value->afi_segnombre,
						'afi_IdSexo' => $value->afi_idsexo,
						'afi_FecNac' => $value->afi_fecnac,
						'fechaActual' => $value->fechaactual,
						'edad' => $value->edad,
						'afi_IdEstado' => $value->afi_idestado,
						'afi_FecBaja' => $value->afi_fecbaja,
					];
				}
				if(!empty($insert)){
					DB::table('afiliados')->insert($insert);
					dd('Insert Record successfully.');
				}
			}
		}
 
        return back()->with('success', 'Insert Record successfully.');
    }
}
