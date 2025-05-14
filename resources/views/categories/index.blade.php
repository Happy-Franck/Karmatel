<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Catégories</h2>
    </x-slot>
    

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('categories.create') }}" class="mb-4 inline-block text-white px-4 py-2 rounded bg-blue-600">
            + Nouvelle Catégorie
        </a>

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
            <table class="w-full table-auto">
                <thead>
                    <tr>
                        <th class="text-left px-4 py-2">Nom</th>
                        <th class="text-left px-4 py-2">Image</th>
                        <th class="text-left px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $category->nom }}</td>
                            <td class="px-4 py-2">
                                @if ($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="Image catégorie" style="width: 100px" />
                                @else
                                    <span class="text-gray-400 italic">Pas d'image</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                <a href="{{ route('categories.edit', $category->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">
                                    Modifier
                                </a>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Supprimer cette catégorie ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
