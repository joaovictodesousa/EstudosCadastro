<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;
use App\Models\Cadastro;

class CadastroController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function mudar() {
        return view('trolagem');
    } 

    public function index(Request $request)
    {
        $search = $request->input('search', '');
    
        $query = Cadastro::query();
    
        if (!empty($search)) {
            $search = mb_strtolower($search, 'UTF-8'); // Converter pesquisa para minúsculas
            $query->whereRaw('lower(name) LIKE ?', ["%$search%"]);
        }
    
        $Allcadastros = $query->orderBy('id', 'desc')->paginate(10);
    
        return view('welcome', ['Allcadastros' => $Allcadastros, 'search' => $search]);
    }
    
 
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('welcome');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cadastro = new Cadastro;
        $cadastro->fill($request->all());
        $cadastro->save();

        return redirect()->route('welcome.home', ['cadastro' => $cadastro ])->with('success', 'Cadastrado com sucesso. 😁');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cadastro $Cadastro)
    {
        return view('welcomeEdit' , [ 'cadastro' => $Cadastro]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $NewCadastro = [
            'name' => $request->input('name')
        ];

        // Atualização de resultado

        Cadastro::where('id', $id)->update($NewCadastro);

        return redirect()->route('welcome.home')->with('success', 'Alterado com sucesso. 👍');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cadastro $cadastro)
    {
        $cadastro->delete();

        return redirect()->route('welcome.home')->with('danger', 'Excluído com sucesso. 🔥');
    }

    public function exibirPagina()
    {
        $Allcadastros = Cadastro::all();
    
        return view('view_pdf', ['Allcadastros' => $Allcadastros]);
    }
    
    public function gerarPDF(Request $request)
    {
        $search = $request->input('search', '');
        
        $query = Cadastro::query();
        
        if (!empty($search)) {
            $query->where('name', 'LIKE', "%$search%");
        }
        
        $Allcadastros = $query->get();
        
        $pdf = PDF::loadView('view_pdf', compact('Allcadastros'));
        
        return $pdf->stream('lista_de_dados.pdf');
    }
    

    
}