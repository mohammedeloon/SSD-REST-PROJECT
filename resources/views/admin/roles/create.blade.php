<x-admin-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4">
                    <h2 class="text-lg font-semibold text-gray-800">Create New Role</h2>
                    <div class="mt-4">
                        <a href="{{ route('admin.roles.index') }}" class="inline-block px-4 py-2 bg-green-500 hover:bg-green-700 text-white rounded-md">Back to Roles Index</a>
                    </div>
                </div>
                <div class="p-4">
                    <form method="POST" action="{{ route('admin.roles.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Role Name</label>
                            <input type="text" id="name" name="name" class="mt-1 block w-full appearance-none bg-gray-100 border border-gray-300 rounded-md py-2 px-3 text-base leading-normal focus:outline-none focus:bg-white focus:border-blue-500" />
                            @error('name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <button type="submit" class="inline-block px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded-md">Create Role</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
