@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6">Ajouter une nouvelle personne</h1>

        @if ($errors->any())
            <div class="mb-4 p-4 text-red-800 bg-red-100 border border-red-300 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('people.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Prénom</label>
                <input type="text" name="first_name" value="{{ old('first_name') }}" required
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Nom</label>
                <input type="text" name="last_name" value="{{ old('last_name') }}" required
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Nom de naissance</label>
                <input type="text" name="birth_name" value="{{ old('birth_name') }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Autres prénoms</label>
                <input type="text" name="middle_names" value="{{ old('middle_names') }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Date de naissance</label>
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div class="pt-4 flex justify-between items-center">
                <a href="{{ route('people.index') }}"
                   class="text-gray-600 hover:underline">⬅ Retour à la liste</a>

                <button type="submit"
                    class="inline-block bg-indigo-600 hover:bg-green-700 text-black font-semibold px-4 py-2 rounded shadow">
                    Créer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
