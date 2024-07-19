<div class="container grid mx-auto">
    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Jenis Akun</th>
                        <th class="px-4 py-3">Role</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @if ($users)
                        @foreach ($users as $user)
                            <tr wire:key='{{ $user->id }}' class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3 text-sm">
                                    {{ $user->name }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $user->email }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if ($user->google_id != null)
                                        Google
                                    @else
                                        Email
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{-- {{ $user->roles }} --}}
                                    @foreach ($user->roles as $role)
                                        @if ($role->name == 'SuperAdmin')
                                            <span
                                                class="px-2 py-1 font-semibold leading-tight text-orange-700 bg-orange-100 rounded-full dark:text-white dark:bg-orange-600">
                                                {{ $role->name }}</span>
                                        @elseif ($role->name == 'Admin')
                                            <span
                                                class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                                {{ $role->name }}</span>
                                        @elseif ($role->name == 'User')
                                            <span
                                                class="px-2 py-1 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:text-white dark:bg-blue-600">
                                                {{ $role->name }}</span>
                                        @elseif ($role->name == 'Operator')
                                            <span
                                                class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full dark:text-white dark:bg-yellow-600">
                                                {{ $role->name }}</span>
                                        @endif
                                    @endforeach
                                </td>
                                {{-- untuk tombol aksi --}}
                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-4 text-sm">
                                        @if ($user->id != Auth::user()->id)
                                            @foreach ($user->roles as $role)
                                                @role('SuperAdmin|Admin')
                                                    @if ($role->name == 'User' || $role->name == 'Operator')
                                                        <x-button-small wire:click='setAdmin({{ $user->id }})'
                                                            color="green">Jadikan
                                                            Admin</x-button-small>
                                                    @endif
                                                    @if ($role->name == 'Admin' || $role->name == 'User')
                                                        <x-button-small wire:click='setOperator({{ $user->id }})'
                                                            color="yellow">Jadikan
                                                            Operator</x-button-small>
                                                    @endif
                                                    @if ($role->name == 'Admin' || $role->name == 'Operator')
                                                        <x-button-small wire:click='setUser({{ $user->id }})'
                                                            color="blue">Jadikan
                                                            User</x-button-small>
                                                    @endif
                                                @endrole
                                            @endforeach
                                        @else
                                            Anda
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <div class="p-2 ">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
