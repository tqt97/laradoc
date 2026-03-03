<nav class="text-base lg:text-sm">
    <ul role="list" class="space-y-10">
        @foreach ($nav as $section)
            <li>
                <h3 class="text-xs font-bold uppercase tracking-[0.2em] text-zinc-900 dark:text-white mb-6">
                    {{ $section['title'] }}
                </h3>
                <ul role="list"
                    class="mt-4 space-y-3 border-l border-zinc-100 dark:border-zinc-800">
                    @foreach ($section['links'] as $link)
                        <li class="relative">
                            <a @class([
                                'block w-full pl-4 transition-all duration-200',
                                'text-zinc-900 dark:text-white font-bold border-l-2 border-zinc-900 dark:border-white -ml-px' =>
                                    url()->current() === route('prezet.show', ['slug' => $link['slug']]),
                                'text-zinc-500 dark:text-zinc-400 font-semibold hover:text-zinc-900 dark:hover:text-zinc-200 hover:border-l-2 hover:border-zinc-200 dark:hover:border-zinc-700 -ml-px' =>
                                    url()->current() !== route('prezet.show', ['slug' => $link['slug']]),
                            ]) href="{{ route('prezet.show', ['slug' => $link['slug']]) }}">
                                {{ $link['title'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
</nav>
