<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Aluno;
use Illuminate\Http\Request;

class CursosController extends Controller
{
    public function index()
    {
        return Curso::all();
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nome' => 'required|string|max:255',
                'descricao' => 'required|string|max:1000',
                'professor_id' => 'required|exists:professores,id',
            ]);

            $curso = Curso::create([
                'nome' => $request->nome,
                'descricao' => $request->descricao,
                'professor_id' => $request->professor_id,
            ]);

            return response()->json($curso, 201);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'trace' => $th->getTrace()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $curso = Curso::findOrFail($id);
        $curso->delete();

        return response()->json(['message' => 'Curso deletado com sucesso!'], 200);
    }

    public function update(Request $request, $id)
    {
        $curso = Curso::findOrFail($id);
        $curso->update($request->all());

        return response()->json($curso, 200);
    }

    public function show($id)
    {
        $curso = Curso::findOrFail($id);
        $alunos = Aluno::where('curso_id', $id)->get();

        return response()->json([
            "curso" => $curso,
            "alunos" => $alunos,
        ], 200);
    }

    public function indexWithProfessores()
    {
        $cursos = Curso::all();
        $professores = Professor::all();

        return response()->json([
            'cursos' => $cursos,
            'professores' => $professores,
        ]);
    }
}
