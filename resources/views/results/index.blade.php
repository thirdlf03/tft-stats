<x-app-layout>
    <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Result') }}
    </h2>
    </x-slot>
    <style>
    [x-cloak] { display: none !important; }
    </style>
    <div class="pt-4 py-2 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg">
        <p class="ml-5 py-2 font-bold flex justify-center">ユーザー検索</p>
        <form form method="POST" action="{{ route('results.api') }}" class="py-2 gap-3 space-x-4">
            @csrf
            <div class="flex justify-center gap-2 items-center">
                <p class="text-black font-bold">地域</p>
                <div class="flex items-center space-x-2">
                    <div class="relative">
                        <select name="region" class="bg-transparent text-gray-500 font-bold focus:outline-none border border-gray-300 px-4 py-2">
                            <option>americas</option>
                            <option>asia</option>
                            <option>europe</option>
                        </select>
                    </div>
                </div>
                <p class="pl-3 font-bold align-bottom">ゲーム内ID</p>
                <div class="flex items-center space-x-2 border-gray-300 px-4 py-2 rounded-md">
                    <input name="gameId" type="text" placeholder="ゲーム名 + #" class="bg-transparent text-gray-500 font-bold focus:outline-none">
                </div>
                <button type="submit" class="ml-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700">ユーザー検索</button>
            </div>
        </form>
    </div>
    </div>


    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                @foreach ($results as $result)
                <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                    <div class="flex items-center justify-between">
                        @php
                            $data = json_decode($result->data_json);
                        @endphp

                        <p class="text-gray-800 dark:text-gray-300">
                            日付: {{ date('Y-m-d H:i:s', $data->date / 1000) }}<br>
                            ゲームモード: {{ $data->gameMode }}<br>
                            ゲームタイプ: {{ $data->gameType }}<br>
                            @if ($data->placement <= 4 )
                            <span class="text-red-500">
                                順位: {{ $data->placement }}位<br>
                            </span>
                            @else
                                <span>順位: {{ $data->placement }}位</span><br>
                            @endif
                            レベル: {{ $data->level }}<br>
                            総ダメージ: {{ $data->totalDamage }}
                        </p>

                        <div x-data="{ open: false }" class="relative text-sm font-normal">
                            <button @click="open = true" class="ml-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700 flex items-center">
                                <span>ブックマークに追加</span>
                                <svg class="w-4 h-4 ml-2 duration-200 ease-out" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </button>

                            <div x-cloak x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" x-transition>
                                <div x-on:click.away="open = false" class="bg-white dark:bg-gray-800 p-6 rounded-lg w-1/3">
                                    <div class="flex justify-between">
                                        <h2 class="text-lg font-bold mb-4">Bookmarks</h2>
                                        <div x-on:click="open = false" class="text-2xl cursor-pointer">×</div>
                                    </div>
                                    <div class="items-center mb-4">
                                        @foreach ($bookmarks as $bookmark)
                                            <form action="{{ $result->bookmark_contents->contains($bookmark->id) ? route('bookmarkcontents.destroy', $bookmark) : route('bookmarkcontents.store', $bookmark) }}" method="POST">
                                                @csrf
                                                @if($result->bookmark_contents->contains($bookmark->id))
                                                    @method('DELETE')
                                                    <input type="hidden" name="result_id" value="{{ $result->id }}">
                                                    <input id="{{ $bookmark->id }}" onchange="submit(this.form)" checked type="checkbox" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-neutral-900 focus:ring-neutral-900">
                                                @else
                                                    <input type="hidden" name="result_id" value="{{ $result->id }}">
                                                    <input id="{{ $bookmark->id }}" onchange="submit(this.form)" type="checkbox" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-neutral-900 focus:ring-neutral-900">
                                                @endif
                                                <label for="{{ $bookmark->id }}" class="ml-2 text-sm font-medium text-gray-900">{{ $bookmark->name }}</label>
                                                <br>
                                            </form>
                                        @endforeach
                                        <div x-data="{ show: false }" class="p-6 rounded">
                                            <button @click="show = !show" class="text-black rounded">+ 新規作成</button>
                                            <div x-show="show" class="mt-4">
                                                <form method="POST" action="{{ route('bookmarks.store') }}">
                                                    @csrf
                                                    <div class="flex items-center">
                                                        <input type="text" name="name" id='name' class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="ブックマーク名を入力">
                                                        <button type="submit" @click="show = false" class="ml-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700">作成</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
