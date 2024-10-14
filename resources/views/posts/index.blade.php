<x-app-layout>
    <x-slot name="header">
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a class="p-2" href="{{ route('posts.create') }}">+ 投稿作成</a>
                    @foreach ($posts as $post)
                        <div class="mt-2 mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                            <div id="restored-content-{{ $post->id }}"></div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">投稿者: {{ $post->user->name }}</p>
                            @if ($post->user_id == auth()->id())
                                <form method="POST" action="{{ route('posts.destroy', $post) }}">
                                    @csrf
                                    @method('DELETE')
                                    <div class="flex justify-end mt-4">
                                        <div
                                            class="bg-red-500 hover:bg-red-700 text-red font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                            <button type="submit">
                                                削除
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        </div>
                        <script>
                            var content_text = '{!! $post->post_content !!}';
                            var json = content_text.replace(/\n/g, '\\n');
                            json = JSON.parse(json);
                            const restoredContent{{ $post->id }} = new Quill('#restored-content-{{ $post->id }}');
                            restoredContent{{ $post->id }}.setContents(json);
                            restoredContent{{ $post->id }}.disable();
                        </script>
                    @endforeach
                </div>
            </div>
        </div>

</x-app-layout>
