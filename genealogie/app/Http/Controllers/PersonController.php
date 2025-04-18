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

        // first_name : Majuscule 1ère lettre
        $validated['first_name'] = ucfirst(strtolower($validated['first_name']));

        // last_name : Majuscules
        $validated['last_name'] = strtoupper($validated['last_name']);

        // middle_names : majuscule pour chaque prénom
        if (!empty($validated['middle_names'])) {
            $validated['middle_names'] = collect(explode(',', $validated['middle_names']))
                ->map(function ($name) {
                    return ucfirst(strtolower(trim($name)));
                })->implode(', ');
        } else {
            $validated['middle_names'] = null;
        }

        // birth_name : majuscules ou copie de last_name
        $validated['birth_name'] = !empty($validated['birth_name'])
            ? strtoupper($validated['birth_name'])
            : $validated['last_name'];

        // date_of_birth : null si vide
        if (empty($validated['date_of_birth'])) {
            $validated['date_of_birth'] = null;
        }

        // Enregistrement
        Person::create($validated);

        return redirect()->route('people.index')->with('success', 'Personne créée avec succès !');
    }
}
