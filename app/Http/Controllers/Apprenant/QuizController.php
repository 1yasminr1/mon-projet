<?php
namespace App\Http\Controllers\Apprenant;

use App\Http\Controllers\Controller;
use App\Models\Evaluation;
use App\Models\Resultat;
use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function show(Evaluation $evaluation)
    {
        $inscription = Inscription::where('user_id', Auth::id())
                                  ->where('formation_id', $evaluation->formation_id)
                                  ->where('statut', 'validee')->first();
        abort_if(!$inscription, 403);
        $questions = $evaluation->questions;
        return view('apprenant.quiz.show', compact('evaluation', 'questions'));
    }

    public function soumettre(Request $request, Evaluation $evaluation)
    {
        $reponses = $request->input('reponses', []);
        $note     = $evaluation->calculerNote($reponses);
        $reussi   = $note >= $evaluation->note_min;

        Resultat::create([
            'user_id'       => Auth::id(),
            'evaluation_id' => $evaluation->id,
            'note'          => $note,
            'reussi'        => $reussi,
        ]);

        return redirect()->route('apprenant.quiz.resultat', $evaluation->id)
                         ->with(['note' => $note, 'reussi' => $reussi]);
    }

    public function resultat(Evaluation $evaluation)
    {
        $resultat = Resultat::where('user_id', Auth::id())
                            ->where('evaluation_id', $evaluation->id)
                            ->latest()->first();
        return view('apprenant.quiz.resultat', compact('evaluation', 'resultat'));
    }
}