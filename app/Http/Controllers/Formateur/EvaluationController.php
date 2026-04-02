<?php
namespace App\Http\Controllers\Formateur;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use App\Models\Evaluation;
use App\Models\Quiz;
use App\Models\Certificat;
use App\Models\Inscription;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    public function index(Formation $formation)
    {
        abort_if($formation->user_id !== Auth::id(), 403);
        $evaluations = $formation->evaluations()->with('questions')->get();
        return view('formateur.evaluations.index', compact('formation', 'evaluations'));
    }

    public function store(Request $request, Formation $formation)
    {
        abort_if($formation->user_id !== Auth::id(), 403);
        $request->validate([
            'titre'    => 'required|string',
            'type'     => 'required|in:quiz,examen',
            'note_min' => 'required|integer|min:1|max:20',
        ]);

        $formation->evaluations()->create($request->only('titre', 'type', 'note_min'));
        return back()->with('success', 'Évaluation créée.');
    }

    public function ajouterQuestion(Request $request, Evaluation $evaluation)
    {
        abort_if($evaluation->formation->user_id !== Auth::id(), 403);
        $request->validate([
            'question'      => 'required|string',
            'reponse_a'     => 'required|string',
            'reponse_b'     => 'required|string',
            'reponse_c'     => 'required|string',
            'reponse_d'     => 'required|string',
            'bonne_reponse' => 'required|in:a,b,c,d',
        ]);

        $evaluation->questions()->create($request->all());
        return back()->with('success', 'Question ajoutée.');
    }

    public function attribuerCertificat(Inscription $inscription)
    {
        abort_if($inscription->formation->user_id !== Auth::id(), 403);

        $existant = Certificat::where('user_id', $inscription->user_id)
                              ->where('formation_id', $inscription->formation_id)
                              ->first();
        if ($existant) {
            return back()->with('error', 'Certificat déjà attribué.');
        }

        Certificat::attribuer($inscription->user_id, $inscription->formation_id);
        Notification::envoyer(
            $inscription->user_id,
            'Certificat obtenu !',
            "Félicitations ! Vous avez obtenu votre certificat pour '{$inscription->formation->titre}'."
        );
        return back()->with('success', 'Certificat attribué.');
    }
}