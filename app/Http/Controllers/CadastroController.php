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
        // Obtém o valor do parâmetro de consulta 'search' da solicitação HTTP. Se não houver nenhum valor, define uma string vazia como padrão.
        $search = $request->input('search', '');
    
        // Inicia uma consulta no modelo Cadastro. O modelo representa geralmente uma tabela no banco de dados.
        $query = Cadastro::query();
    
        // Verifica se a variável $search não está vazia. Se não estiver vazia, adiciona uma cláusula WHERE à consulta para filtrar os resultados.
        if (!empty($search)) {
            // Converte a pesquisa para minúsculas
            $search = mb_strtolower($search, 'UTF-8');
            // Adiciona a condição de pesquisa à consulta
            $query->whereRaw('lower(name) LIKE ?', ["%$search%"]);
        }
    
        // Executa a consulta, ordena os resultados pelo campo 'id' em ordem decrescente e os pagina em grupos de 10 resultados por página.
        $Allcadastros = $query->orderBy('id', 'desc')->paginate(10);
    
        // Retorna a visão 'welcome' com os resultados da pesquisa, a variável de pesquisa $search e a lista paginada de cadastros $Allcadastros.
        return view('welcome', ['Allcadastros' => $Allcadastros, 'search' => $search]);


        // a variável $search é usada para realizar uma pesquisa no banco de dados.
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
        
        $query = Cadastro::query();  // Faz um busca no CADASTRO
        
        if (!empty($search)) {
            $query->where('name', 'LIKE', "%$search%");
        }
        
        $Allcadastros = $query->get();
        
        $pdf = PDF::loadView('view_pdf', compact('Allcadastros'));
        
        return $pdf->stream('lista_de_dados.pdf');
    }
    

    
}