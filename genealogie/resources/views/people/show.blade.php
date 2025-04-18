@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow-md rounded-lg p-6">

        <h1 class="text-2xl font-bold mb-4">
            {{ $person->first_name }} {{ $person->last_name }}
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <p><strong class="text-gray-700">Nom de naissance :</strong> {{ $person->birth_name ?? 'N/A' }}</p>
                <p><strong class="text-gray-700">Autres prénoms :</strong> {{ $person->middle_names ?? 'N/A' }}</p>
                <p><strong class="text-gray-700">Date de naissance :</strong> {{ $person->date_of_birth ?? 'N/A' }}</p>
            </div>
        </div>

        <hr class="my-6">

        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-2">Parents</h3>
            <ul class="list-disc list-inside text-gray-800">
                @forelse($person->parents as $parent)
                    <li>{{ $parent->first_name }} {{ $parent->last_name }}</li>
                @empty
                    <li class="text-gray-500">Aucun parent renseigné</li>
                @endforelse
            </ul>
        </div>

        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-2">Enfants</h3>
            <ul class="list-disc list-inside text-gray-800">
                @forelse($person->children as $child)
                    <li>{{ $child->first_name }} {{ $child->last_name }}</li>
                @empty
                    <li class="text-gray-500">Aucun enfant renseigné</li>
                @endforelse
            </ul>
        </div>

        <div class="mt-4">
            <a href="{{ route('people.index') }}"
               class="text-indigo-600 hover:underline">⬅ Retour à la liste</a>
        </div>
    </div>
</div>
@endsection
