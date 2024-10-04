<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('BookmarkContents') }}
    </h2>
  </x-slot>

   <div class="pt-4 py-2 max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white shadow-sm sm:rounded-lg">
        <p class="ml-5 py-2 font-bold flex justify-center">ブックマーク名 : {{ $content->name }}</p>
    </div>
  </div>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          @foreach ($contents as $content)
          <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
            @php
                $data = json_decode($content->data_json);
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
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>

</x-app-layout>
