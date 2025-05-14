<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier la catégorie') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">
                <form action="{{ route('categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="nom" :value="__('Nom de la catégorie')" />
                        <x-text-input id="nom" class="block mt-1 w-full" type="text" name="nom" :value="old('nom', $category->nom)" required />
                        <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="image" :value="__('Image')" />
                        @if ($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="Image actuelle" class="h-20 rounded mb-2" />
                        @endif
                        <x-text-input id="image" class="block mt-1 w-full" type="file" name="image" accept="image/*" />
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-primary-button>{{ __('Mettre à jour') }}</x-primary-button>
                        <a href="{{ route('categories.index') }}" class="ml-4 text-gray-600 hover:text-gray-900">Annuler</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
