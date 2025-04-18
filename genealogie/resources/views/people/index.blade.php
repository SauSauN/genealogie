@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">

    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6">Liste des personnes</h1>

        @if(session('success'))
            <div class="mb-4 p-4 text-green-800 bg-green-100 border border-green-300 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4">
            <a href="{{ route('people.create') }}"
                class="inline-block bg-indigo-600 hover:bg-indigo-700 text-black font-semibold px-4 py-2 rounded shadow">
                ➕ Ajouter une personne
            </a>

        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left px-6 py-3 text-sm font-medium text-gray-600">Nom complet</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-gray-600">Créée par</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($people as $person)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $person->first_name }} {{ $person->last_name }}</td>

                            <td class="px-6 py-4">
                                @php $found = false; @endphp
                                @foreach($people as $person1)
                                    @if($person->created_by == $person1->id)
                                        {{ $person1->first_name }}
                                        @php $found = true; @endphp
                                        @break
                                    @endif
                                @endforeach
                                @if(!$found)
                                    <i class="text-gray-400">Inconnu</i>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <a href="{{ route('people.show', $person->id) }}"
                                   class="text-indigo-600 hover:underline">Voir</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $people->links() }} {{-- pagination --}}
        </div>
    </div>
</div>
@endsection
