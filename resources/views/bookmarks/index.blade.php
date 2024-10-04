<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Bookmark') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          @foreach ($bookmarks as $bookmark)
          <div class="mb-2 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
            <p class="text-gray-800 dark:text-gray-300">{{ $bookmark->name }}</p>
          </div>
          <form method="GET" action="{{ route('bookmarkcontents.index', $bookmark->id) }} " class="py-4">
            <button type="submit" class="ml-4 mb-2 px-4 py-3 bg-blue-500 text-white rounded hover:bg-blue-700 flex items-center">
                <span>詳細を表示</span>
                <svg class="w-4 h-4 ml-2 duration-200 ease-out" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </button>
            </form>
          @endforeach
        </div>
      </div>
    </div>
  </div>

</x-app-layout>
