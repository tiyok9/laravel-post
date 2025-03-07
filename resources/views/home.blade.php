<x-app-layout>
    @if(session('status'))
        <x-alert-status type="{{ session('status_type', 'info') }}" message="{{ session('status') }}" />
    @endif


    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-10 sm:px-6 lg:px-8">
            @guest
            {{-- for gueset users --}}
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p>Please <a href="{{ route('login') }}" class="text-blue-500">login</a> or
                    <a href="{{ route('register') }}" class="text-blue-500">register</a>.</p>
                </div>
            </div>
            @endguest
            @auth
            {{-- for authenticated users --}}
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="space-y-6 p-6">
                    <h2 class="text-lg font-semibold">Your Posts</h2>
                    @foreach($datas as $data)
                        <div class="rounded-md border p-5 shadow">
                            <div class="flex items-center gap-2">
                                @php
                                    $status = $data->is_draft ? "Draft" : ($data->published_at > now() ? 'Scheduled' : 'Active');

                                    $statusClasses = [
                                        'Draft' => 'bg-gray-100 text-gray-800',
                                        'Scheduled' => 'bg-yellow-100 text-yellow-800',
                                        'Active' => 'bg-green-100 text-green-800'
                                    ];
                                @endphp

                                <span class="flex-none rounded px-2 py-1 {{ $statusClasses[$status] ?? '' }}">
                                    {{ $status }}
                                </span>

                                <h3>
                                    <a href="{{ route('posts.show', ['post' => $data->slug]) }}" class="text-blue-500">{{ $data->title }}</a>
                                </h3>
                            </div>

                            <div class="mt-4 flex items-end justify-between">
                                <div>
                                    <div>Published: {{ \Carbon\Carbon::parse($data->published_at)->format('Y-m-d') }}</div>
                                    <div>Updated: {{ \Carbon\Carbon::parse($data->published_at)->format('Y-m-d') }}</div>
                                </div>
                                <div>
                                    <a href="{{ route('posts.show', ['post' => $data->slug]) }}" class="text-blue-500">Detail</a>/
                                    <a href="{{ route('posts.edit', ['post' => $data->slug])}}" class="text-blue-500">Edit</a> /
                                    <form id="delete-form" method="POST" action="{{ route('posts.destroy', ['id' => encrypt($data->id) ?? '']) }}" x-data @submit.prevent="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'deleteConfirmation' }))" class="inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="text-red-500">Delete</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="mt-6">
                        {{ $datas->links() }}
                    </div>
                </div>
            </div>
            @endauth
        </div>
    </div>
    @auth
    <!-- Modal Konfirmasi -->
    <x-modal name="deleteConfirmation" maxWidth="sm">
        <div class="px-3 py-2">
            <h2 class="text-lg font-bold mb-4">Konfirmasi</h2>
            <p>Apakah Anda yakin ingin menghapus item ini?</p>
            <div class="mt-4 flex justify-end space-x-2 ">
                <button @click="window.dispatchEvent(new CustomEvent('close-modal', { detail: 'deleteConfirmation' }))"
                        class="px-4 py-2 bg-gray-500 text-white rounded">No</button>
                <button
                    @click="window.dispatchEvent(new CustomEvent('close-modal', { detail: 'deleteConfirmation' }));
                        setTimeout(() => document.getElementById('delete-form').submit(), 0);"
                    class="px-4 py-2 bg-red-500 text-white rounded">Yes</button>
            </div>
        </div>
    </x-modal>
    @endauth
</x-app-layout>
