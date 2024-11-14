<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use App\Models\Curso;
use Illuminate\Http\Request;

class ProfessoresController extends Controller
{
    public function index()
    {
        return Professor::all();
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:professores',
                'file' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'idade' => 'required|integer|min:1',
            ]);

            $path = $request->file('file')->store('images', 'public');
            $imageUrl = asset('storage/' . $path);

            $professor = Professor::create([
                'nome' => $request->nome,
                'email' => $request->email,
                'idade' => $request->idade,
                'image' => $imageUrl,
            ]);

            return response()->json($professor, 201);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'trace' => $th->getTrace()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $professor = Professor::findOrFail($id);
        $professor->delete();

        return response()->json(['message' => 'Professor deletado com sucesso!'], 200);
    }

    public function update(Request $request, $id)
    {
        $professor = Professor::findOrFail($id);
        $professor->update($request->all());

        return response()->json($professor, 200);
    }

    public function show($id)
    {
        $professor = Professor::findOrFail($id);
        $cursos = Curso::where('professor_id', $id)->get();

        return response()->json([
            "professor" => $professor,
            "cursos" => $cursos,
        ], 200);
    }

    public function indexWithCursos()
    {
        $professores = Professor::all();
        $cursos = Curso::all();

        return response()->json([
            'professores' => $professores,
            'cursos' => $cursos,
        ]);
    }
}
