<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});



// une equipe
$router->get('equipes/{idequipe}', function ($idequipe) {
	$res = DB::select("SELECT COUNT(*) AS nb FROM EQUIPE WHERE idequipe=?",[$idequipe]);
	if ($res[0]->nb == 0) {
		return response()->json(["status"=>false,"message"=>"Equipe inexistante"],200);
	}
	$equipe = DB::select("SELECT * FROM EQUIPE WHERE idequipe=?",[$idequipe]);
	return response()->json(["status"=>true, "equipe"=>$equipe[0]]);
});

// liste des equipes 
$router->get('equipes', function () {
	$equipesArray = array();
	$equipes = DB::select('SELECT * FROM EQUIPE');
	foreach ($equipes as $equipe) {
		$equipesArray[] = get_object_vars($equipe);
	}
	return response()->json($equipesArray);
});

// ajout d'une equipe
$router->post('equipes', function(Request $request) {
    $validator = Validator::make($request->all(), [
            'numequipe' => 'required|integer',
            'detailsequipe' => 'required|string'
            ]);
    
        if ($validator->fails()) {
            $erreurs = json_encode($validator->errors()->all());
            return response()->json(["status"=>false, "message"=>"equipe pas ajoutée ".$erreurs], 200);
        }
        $data = $request->all();
        $id = DB::select("SELECT MAX(idequipe) AS maximum FROM EQUIPE");
        $data["idequipe"] = $id[0]->maximum + 1;
        $result=DB::table('EQUIPE')->insert($data);
        return response()->json(["status"=>true, "equipe"=>$data]);
    });

// supression d'une equipe
$router->delete('equipes/{idequipe}', function ($id) {
	$res = DB::select("SELECT COUNT(*) AS nb FROM EQUIPE WHERE idequipe=?",[$id]);
	if ($res[0]->nb == 0) {
		return response()->json(["status"=>false,"message"=>"Equipe inexistante"],200);
	}
	$result = DB::table('EQUIPE')->where('idequipe','=',$id)->delete();
	return response()->json(["status"=>true,"message"=>"Equipe supprimée"],200);
	
});

// modfication d'une equipe
$router->put('equipes', function(Request $request) {
	$validator = Validator::make($request->all(), [
        'idequipe' => 'required|integer',
		'numequipe' =>'required|integer',
        'detailsequipe' => 'required|string'
        ]);

    if ($validator->fails()) {
		$erreurs = json_encode($validator->errors()->all());
		return response()->json(["status"=>false, "message"=>"Equipe pas modifiée ".$erreurs], 200);
    }
	$data = $request->all();
	$id = $data["idequipe"];
	
	$res = DB::select("SELECT COUNT(*) AS nb FROM EQUIPE WHERE idequipe=?",[$id]);
	if ($res[0]->nb == 0) {
		return response()->json(["status"=>false,"message"=>"Equipe inexistante"],200);
	}
	$result=DB::table('EQUIPE')->where('idequipe',$id)->update($data);
	return response()->json(["status"=>true,"message"=>"Equipe modifiée"]);
});
