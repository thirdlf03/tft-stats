<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Result') }}
    </h2>
  </x-slot>
  <style>
    [x-cloak] { display: none !important; }
  </style>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
        @foreach ($results as $result)
        <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
            <div class="flex items-center justify-between">
              <p class="text-gray-800 dark:text-gray-300">{{ $result->data_json }}</p>

              <div x-data="{ open: false }" class="relative text-sm font-normal">
                @if(Session::has('showModal'))
                <div x-data="{ open: true }"  class="relative text-sm font-normal">
                @endif

                <button @click="open = true" class="ml-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700 flex items-center">
                    <span>ブックマークに追加</span>
                    <svg class="w-4 h-4 ml-2 duration-200 ease-out" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>

                <div x-cloak x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 " x-transition>
                  <div x-on:click.away="open = false" class="bg-white dark:bg-gray-800 p-6 rounded-lg w-1/3">
                    <div class="flex justify-between">
                        <h2 class="text-lg font-bold mb-4">Bookmarks</h2>
                        <div x-on:click="open = false" class="text-2xl cursor-pointer">×</div>
                    </div>
                    <div class="items-center mb-4">
                        @foreach ($bookmarks as $bookmark)
                          @if ($result->bookmark_contents->contains($bookmark->id))
                          <form action="{{ route('bookmarkcontents.destroy', [$bookmark, $result]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input id="{{ $bookmark->id }}" onchange="submit(this.form)" checked type="checkbox" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-neutral-900 focus:ring-neutral-900">
                            <label for="{{ $bookmark->id }}" class="ml-2 text-sm font-medium text-gray-900">{{ $bookmark->name }}</label>
                            <br>
                          </form>
                          @else
                          <form action="{{ route('bookmarkcontents.store', $bookmark) }}" method="POST">
                            @csrf 
                            <input type=hidden name="result_id" value="{{ $result->id }}">
                            <input id="{{ $bookmark->id }}" onchange="submit(this.form)" type="checkbox" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-neutral-900 focus:ring-neutral-900">
                            <label for="{{ $bookmark->id }}" class="ml-2 text-sm font-medium text-gray-900">{{ $bookmark->name }}</label>
                            <br>
                          </form>
                          @endif
                        @endforeach
                          <div x-data="{ show: false }" class="p-6 rounded">
                            <button @click="show = !show" class="text-black rounded">
                            + 新規作成
                            </button>

                            <div x-show="show" class="mt-4">
                                <form method="POST" action="{{ route('bookmarks.store') }}">
                                    @csrf
                                    <div class="flex items-center">
                                    <input type="text" name="name" id='name' class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="ブックマーク名を入力">
                                    <button type="submit" @click="show = !show" class="ml-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700">
                                        作成
                                    </button>
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
