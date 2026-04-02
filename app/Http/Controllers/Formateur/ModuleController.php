<?php
namespace App\Http\Controllers\Formateur;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use App\Models\Module;
use App\Models\Contenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ModuleController extends Controller
{
    public function index(Formation $formation)
    {
        abort_if($formation->user_id !== Auth::id(), 403);
        $modules = $formation->modules()->with('contenus')->get();
        return view('formateur.modules.index', compact('formation', 'modules'));
    }

    public function store(Request $request, Formation $formation)
    {
        abort_if($formation->user_id !== Auth::id(), 403);
        $request->validate(['titre' => 'required|string|max:255']);

        $formation->modules()->create([
            'titre'       => $request->titre,
            'description' => $request->description,
            'ordre'       => $formation->modules()->count() + 1,
        ]);
        return back()->with('success', 'Module ajouté.');
    }

    public function update(Request $request, Module $module)
    {
        abort_if($module->formation->user_id !== Auth::id(), 403);
        $request->validate(['titre' => 'required|string|max:255']);
        $module->gererModule(['titre' => $request->titre, 'description' => $request->description]);
        return back()->with('success', 'Module modifié.');
    }

    public function destroy(Module $module)
    {
        abort_if($module->formation->user_id !== Auth::id(), 403);
        $module->delete();
        return back()->with('success', 'Module supprimé.');
    }

    public function ajouterContenu(Request $request, Module $module)
    {
        abort_if($module->formation->user_id !== Auth::id(), 403);
        $request->validate([
            'titre'   => 'required|string|max:255',
            'type'    => 'required|in:pdf,video,audio',
            'fichier' => 'required|file|max:51200',
        ]);

        $path = $request->file('fichier')->store('contenus', 'public');
        $module->contenus()->create([
            'titre'   => $request->titre,
            'type'    => $request->type,
            'fichier' => $path,
            'ordre'   => $module->contenus()->count() + 1,
        ]);
        return back()->with('success', 'Contenu ajouté.');
    }

    public function supprimerContenu(Contenu $contenu)
    {
        abort_if($contenu->module->formation->user_id !== Auth::id(), 403);
        Storage::disk('public')->delete($contenu->fichier);
        $contenu->delete();
        return back()->with('success', 'Contenu supprimé.');
    }
}