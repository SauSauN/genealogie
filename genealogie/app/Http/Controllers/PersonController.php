<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonController extends Controller
{
    //Affiche la liste des personnes avec le nom de l'utilisateur qui les a créé.
    public function index()
    {
        $people = Person::with('creator')->paginate(20); // ou ->get() pour tout récupérer sans pagination
        return view('people.index', compact('people'));
    }

    //Affiche une personne spécifique avec la liste de ses enfants / parents.
    public function show($id)
    {
        $person = Person::with(['parents', 'children'])->findOrFail($id);
        return view('people.show', compact('person'));
    }

    //Affiche le formulaire de création d'une nouvelle personne.
    public function create()
    {
        return view('people.create');
    }

    //Enregistre une nouvelle personne après validation.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_name' => 'nullable|string|max:255',
            'middle_names' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
        ]);

        // Ajoute l'utilisateur connecté comme créateur
        $validated['created_by'] = Auth::id();

        Person::create($validated);

        return redirect()->route('people.index')->with('success', 'Personne créée avec succès !');
    }
}
