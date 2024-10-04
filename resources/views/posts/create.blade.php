<x-app-layout>
  <x-slot name="header">
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Post作成') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css" />
          <script src="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.js"></script>
          <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.css" />

          <div id="toolbar-container">
            <span class="ql-formats">
              <select class="ql-font"></select>
              <select class="ql-size"></select>
            </span>
            <span class="ql-formats">
              <button class="ql-bold"></button>
              <button class="ql-italic"></button>
              <button class="ql-underline"></button>
              <button class="ql-strike"></button>
            </span>
            <span class="ql-formats">
              <select class="ql-color"></select>
              <select class="ql-background"></select>
            </span>
            <span class="ql-formats">
              <button class="ql-script" value="sub"></button>
              <button class="ql-script" value="super"></button>
            </span>
            <span class="ql-formats">
              <button class="ql-header" value="1"></button>
              <button class="ql-header" value="2"></button>
              <button class="ql-blockquote"></button>
              <button class="ql-code-block"></button>
            </span>
            <span class="ql-formats">
              <button class="ql-list" value="ordered"></button>
              <button class="ql-list" value="bullet"></button>
              <button class="ql-indent" value="-1"></button>
              <button class="ql-indent" value="+1"></button>
            </span>
            <span class="ql-formats">
              <button class="ql-direction" value="rtl"></button>
              <select class="ql-align"></select>
            </span>
            <span class="ql-formats">
              <button class="ql-link"></button>
              <button class="ql-image"></button>
              <button class="ql-video"></button>
              <button class="ql-formula"></button>
            </span>
            <span class="ql-formats">
              <button class="ql-clean"></button>
            </span>
          </div>

          <!-- Quill editor container -->
          <div id="editor"></div>

          <form method="POST" action="{{ route('posts.store')}}" id="postForm">
              @csrf
              <input type="hidden" name="postContent" id="postContent" value="{1:1}">
                <label for="resultSelect" class="block mt-4 text-gray-700">Select Result:</label>

                <select name="selectedResult" id="resultSelect" class="mt-2 block w-full border-gray-300 rounded-md">
                    <option value="">選択してください</option>
                    @if (count($results) > 0)
                        @foreach ($results as $result)
                            @php
                                $data = json_decode($result->data_json);
                            @endphp
                            <option value="{{ $result->id }}">日付: {{ date('Y-m-d H:i:s', $data->date / 1000) }} 順位:{{ $data->placement }}</option>
                        @endforeach
                    @endif
                </select>
              <div class="flex justify-end mt-4">
                  <button type="submit" id="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                      送信
                  </button>
              </div>
          </form>

          <script>
              const quill = new Quill('#editor', {
                  modules: {
                      syntax: true,
                      toolbar: '#toolbar-container',
                  },
                  placeholder: '内容を入力',
                  theme: 'snow',
              });

            document.getElementById('postForm').addEventListener('submit', function(e) {
                const delta = quill.getContents();
                const jsoncontent = JSON.stringify(delta);
                document.getElementById('postContent').value = jsoncontent;

                console.log('jsoncontent:', jsoncontent);
                console.log('hidden field:', document.getElementById('postContent').value);
            });
          </script>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
