<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Curso;
use Illuminate\Http\Request;

class AlunoController extends Controller
{
    public function index()
    {
        return Aluno::all();
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nome' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:alunos',
                'idade' => 'required|integer|min:1',
                'curso_id' => 'required|exists:cursos,id',
                'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $path = $request->file('file')->store('images', 'public');
            $imageUrl = asset('storage/' . $path);

            $aluno = Aluno::create([
                'nome' => $request->nome,
                'email' => $request->email,
                'idade' => $request->idade,
                'curso_id' => $request->curso_id,
                'image' => $imageUrl,
            ]);

            return response()->json($aluno, 201);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'trace' => $th->getTrace()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $aluno = Aluno::findOrFail($id);
        $aluno->delete();

        return response()->json(['message' => 'Aluno deletado com sucesso!'], 200);
    }

    public function update(Request $request, $id)
    {
        $aluno = Aluno::findOrFail($id);
        $aluno->update($request->all());

        return response()->json($aluno, 200);
    }

    public function show($id)
    {
        $aluno = Aluno::findOrFail($id);
        $curso = Curso::findOrFail($aluno->curso_id);

        return response()->json([
            "aluno" => $aluno,
            "curso" => $curso,
        ], 200);
    }

    public function indexWithCursos()
    {
        $alunos = Aluno::all();
        $cursos = Curso::all();

        return response()->json([
            'alunos' => $alunos,
            'cursos' => $cursos,
        ]);
    }
}
