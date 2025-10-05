<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contact Information') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="contact" class="block text-gray-700 text-sm font-bold mb-2">Contact Information:</label>
                            <input type="text" name="contact" id="contact" value="{{ auth()->user()->contact }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <button type="submit" class="bg-primary-500 text-white py-2 px-4 rounded-md hover:bg-primary-600">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
