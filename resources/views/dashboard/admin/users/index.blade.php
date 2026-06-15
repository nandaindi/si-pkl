@extends ('layouts.app')

@section ('content')
    @section ('header')
        <h2 class="font-semibold text-xl text-textMain leading-tight">{{ __('User Management') }}</h2>
    @endsection
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-glass backdrop-blur-md overflow-hidden shadow-glass sm:rounded-xl border border-white/20 p-6"
            >
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-medium text-textMain">Daftar Pengguna</h3>
                    <x-primary-button> + Tambah Pengguna </x-primary-button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="py-3 px-4 text-sm font-semibold text-textMain/80">Nama</th>
                                <th class="py-3 px-4 text-sm font-semibold text-textMain/80">Email</th>
                                <th class="py-3 px-4 text-sm font-semibold text-textMain/80">Peran (Role)</th>
                                <th class="py-3 px-4 text-sm font-semibold text-textMain/80">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($users as $user)
                                <tr class="hover:bg-white/50 transition-colors duration-200">
                                    <td class="py-3 px-4">{{ $user->name }}</td>
                                    <td class="py-3 px-4 text-gray-500">{{ $user->email }}</td>
                                    <td class="py-3 px-4">
                                        @foreach ($user->roles as $role)
                                            <span
                                                class="px-2 py-1 bg-pink-100 text-primary text-xs rounded-full"
                                                >{{ ucfirst($role->name) }}</span
                                            >
                                        @endforeach
                                    </td>
                                    <td class="py-3 px-4">
                                        <button
                                            class="text-sm text-primary hover:text-secondary transition-colors mr-3"
                                        >
                                            Edit
                                        </button>
                                        <button class="text-sm text-red-500 hover:text-red-700 transition-colors">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">{{ $users->links() }}</div>
            </div>
        </div>
    </div>
@endsection
