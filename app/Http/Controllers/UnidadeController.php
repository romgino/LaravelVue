<?php

namespace App\Http\Controllers;
use App\Unidade;
use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use Response;
use Illuminate\Support\Facades\Input;



class UnidadeController extends Controller
{
    public function vueCrud(){
      return view('unidades.index');
    }
    public function index(){
    $items = Unidade::latest()->paginate(6);

    $response = [
       'pagination' => [
         'total' => $items->total(),
         'per_page' => $items->perPage(),
         'current_page' => $items->currentPage(),
         'last_page' => $items->lastPage(),
         'from' => $items->firstItem(),
         'to' => $items->lastItem()
       ],
       'data' => $items
     ];
     
     return response()->json($response);
   }
   public function store(Request $request)
    {
        $this->validate($request,[
          'nome' => 'required',

        ]);
        $create = Unidade::create($request->all());
        return response()->json($create);
    }

    public function update(Request $request, $id)
    {
      $this->validate($request,[
        'nome' => 'required',

      ]);
      $edit = Unidade::find($id)->update($request->all());
      return response()->json($edit);
    }

    public function destroy($id)
    {
        Unidade::find($id)->delete();
        return response()->json(['done']);
    }
}
