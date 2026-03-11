<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Filesystem Configuration
    |--------------------------------------------------------------------------
    |
    | This setting determines the filesystem disk used by Prezet to store and
    | retrieve markdown files and images. By default, it uses the 'prezet' disk.
    |
    */

    'filesystem' => [
        'disk' => env('PREZET_FILESYSTEM_DISK', 'prezet'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Slug Configuration
    |--------------------------------------------------------------------------
    |
    | Configure how document slugs are generated. The source can be 'filepath'
    | or 'title'. Note that a slug defined in front matter will take precedence
    | over the generated slug. When 'keyed' is true, the key present in the
    | front matter key will be appended to the slug (e.g., my-post-123).
    |
    */

    'slug' => [
        'source' => 'filepath', // 'filepath' or 'title'
        'keyed' => false, // 'true' or 'false'
    ],

    /*
    |--------------------------------------------------------------------------
    | CommonMark
    |--------------------------------------------------------------------------
    |
    | Configure the CommonMark Markdown parser. You can specify the extensions
    | to be used and their configuration. Extensions are added in the order
    | they are listed.
    |
    */

    'commonmark' => [

        'extensions' => [
            League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension::class,
            League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension::class,
            League\CommonMark\Extension\Table\TableExtension::class,
            League\CommonMark\Extension\Highlight\HighlightExtension::class,
            League\CommonMark\Extension\Autolink\AutolinkExtension::class,
            League\CommonMark\Extension\Attributes\AttributesExtension::class,
            League\CommonMark\Extension\Footnote\FootnoteExtension::class,
            League\CommonMark\Extension\SmartPunct\SmartPunctExtension::class,
            League\CommonMark\Extension\DisallowedRawHtml\DisallowedRawHtmlExtension::class,
            League\CommonMark\Extension\TaskList\TaskListExtension::class,
            League\CommonMark\Extension\Strikethrough\StrikethroughExtension::class,
            League\CommonMark\Extension\ExternalLink\ExternalLinkExtension::class,
            League\CommonMark\Extension\FrontMatter\FrontMatterExtension::class,
            League\CommonMark\Extension\DescriptionList\DescriptionListExtension::class,
            League\CommonMark\Extension\Mention\MentionExtension::class,
            League\CommonMark\Extension\DefaultAttributes\DefaultAttributesExtension::class,
            Prezet\Prezet\Extensions\MarkdownBladeExtension::class,
            Prezet\Prezet\Extensions\MarkdownImageExtension::class,
            Phiki\CommonMark\PhikiExtension::class,
        ],

        'config' => [
            'heading_permalink' => [
                'html_class' => 'prezet-heading',
                'id_prefix' => 'content',
                'apply_id_to_heading' => false,
                'heading_class' => '',
                'fragment_prefix' => 'content',
                'insert' => 'before',
                'min_heading_level' => 2,
                'max_heading_level' => 4,
                'title' => 'Permalink',
                'symbol' => '#',
                'aria_hidden' => false,
            ],
            'mentions' => [
                'github_handle' => [
                    'prefix' => '@',
                    'pattern' => '[a-z\d](?:[a-z\d]|-(?=[a-z\d])){0,38}',
                    'generator' => 'https://github.com/%s',
                ],
            ],
            'external_link' => [
                'internal_hosts' => env('PREZET_EXTERNAL_LINK_HOSTS', env('APP_URL')), // Don't forget to set this!
                'open_in_new_window' => true,
                'html_class' => 'external-link',
                'nofollow' => 'external',
                'noopener' => 'external',
                'noreferrer' => 'external',
            ],
            'phiki' => [
                'theme' => \Phiki\Theme\Theme::Monokai,
                'with_wrapper' => false,
                'with_gutter' => false,
            ],
            'default_language' => 'php',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Images
    |--------------------------------------------------------------------------
    |
    | Configure how image tags are handled when converting from markdown.
    |
    | 'widths' defines the various widths for responsive images.
    | 'sizes' indicates the sizes attribute for responsive images.
    | 'zoomable' determines if images are zoomable.
    */

    'image' => [

        'widths' => [
            480,
            640,
            768,
            960,
            1536,
        ],

        'sizes' => '92vw, (max-width: 1024px) 92vw, 768px',

        'zoomable' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Sitemap
    |--------------------------------------------------------------------------
    | The sitemap origin is used to generate absolute URLs for the sitemap.
    | An origin consists of a scheme/host/port combination, but no path.
    | (e.g., https://example.com:8000) https://www.rfc-editor.org/rfc/rfc6454
    */

    'sitemap' => [
        'origin' => env('PREZET_SITEMAP_ORIGIN', env('APP_URL')),
    ],

    /*
    |--------------------------------------------------------------------------
    | Snippet Languages
    |--------------------------------------------------------------------------
    |
    | Define the languages supported by snippets and their UI colors.
    |
    */
    'snippet_languages' => [
        'php' => [
            'label' => 'PHP',
            'bg' => 'bg-indigo-500/10',
            'text' => 'text-indigo-600 dark:text-indigo-400',
            'border' => 'border-indigo-500/20',
        ],
        'javascript' => [
            'label' => 'JavaScript',
            'bg' => 'bg-yellow-500/10',
            'text' => 'text-yellow-600 dark:text-yellow-400',
            'border' => 'border-yellow-500/20',
        ],
        'html' => [
            'label' => 'HTML',
            'bg' => 'bg-orange-500/10',
            'text' => 'text-orange-600 dark:text-orange-400',
            'border' => 'border-orange-500/20',
        ],
        'css' => [
            'label' => 'CSS',
            'bg' => 'bg-blue-500/10',
            'text' => 'text-blue-600 dark:text-blue-400',
            'border' => 'border-blue-500/20',
        ],
        'sql' => [
            'label' => 'SQL',
            'bg' => 'bg-emerald-500/10',
            'text' => 'text-emerald-600 dark:text-emerald-400',
            'border' => 'border-emerald-500/20',
        ],
        'bash' => [
            'label' => 'Bash',
            'bg' => 'bg-zinc-500/10',
            'text' => 'text-zinc-600 dark:text-zinc-400',
            'border' => 'border-zinc-500/20',
        ],
        'json' => [
            'label' => 'JSON',
            'bg' => 'bg-cyan-500/10',
            'text' => 'text-cyan-600 dark:text-cyan-400',
            'border' => 'border-cyan-500/20',
        ],
        'markdown' => [
            'label' => 'Markdown',
            'bg' => 'bg-pink-500/10',
            'text' => 'text-pink-600 dark:text-pink-400',
            'border' => 'border-pink-500/20',
        ],
        'python' => [
            'label' => 'Python',
            'bg' => 'bg-sky-500/10',
            'text' => 'text-sky-600 dark:text-sky-400',
            'border' => 'border-sky-500/20',
        ],
        'yaml' => [
            'label' => 'YAML',
            'bg' => 'bg-violet-500/10',
            'text' => 'text-violet-600 dark:text-violet-400',
            'border' => 'border-violet-500/20',
        ],
        'txt' => [
            'label' => 'TEXT',
            'bg' => 'bg-gray-500/10',
            'text' => 'text-gray-600 dark:text-gray-400',
            'border' => 'border-gray-500/20',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Structured Data
    |--------------------------------------------------------------------------
    |
    | Prezet uses these values for JSON-LD structured data. 'authors' defines
    | named authors you can reference in front matter, and 'publisher' is used
    | as the default publisher for all content.
    |
    */

    // https://schema.org/publisher
    'publisher' => [
        '@type' => 'Organization',
        'name' => 'TuanTQ',
        'url' => env('APP_URL', 'http://localhost'),
        'logo' => env('APP_URL', 'http://localhost').'/favicon.svg',
        'image' => env('APP_URL', 'http://localhost').'/images/og/ogimage.png',
    ],

    /*
    |--------------------------------------------------------------------------
    | Hero Section Configuration
    |--------------------------------------------------------------------------
    |
    | Configure the headline, description, and feature grid shown in the hero
    | section of the home page.
    |
    */
    'hero' => [
        'headline' => 'Lưu trữ & Chia sẻ kiến thức.',
        'description' => 'Nơi ghi chép sẻ chia và đúc kết kinh nghiệm thực chiến trên hành trình công nghệ.',
        'features' => [
            [
                'label' => 'Bài viết',
                'sub' => 'Kinh nghiệm thực chiến',
                'route' => 'prezet.articles',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />',
            ],
            [
                'label' => 'Chuỗi bài viết',
                'sub' => 'Bài viết theo chủ đề',
                'route' => 'prezet.series.index',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.108 0 0 1 11.186 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M9 7.5h6M9 10.5h6" />',
            ],
            [
                'label' => 'Lưu trữ',
                'sub' => 'Liên kết hữu ích',
                'route' => 'links.index',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />',
            ],
            [
                'label' => 'Snippets',
                'sub' => 'Mã nguồn tái sử dụng',
                'route' => 'snippets.index',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5" />',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | SEO Configuration
    |--------------------------------------------------------------------------
    */
    'seo' => [
        'author' => 'TuanTQ',
        'site_name' => 'tuantq.online',
        'twitter_handle' => '@tuantq',
        'default_description' => 'tuantq.online - Chuyên trang chia sẻ kiến thức lập trình web, kiến trúc hệ thống và kinh nghiệm thực chiến. Nơi đúc kết kỹ thuật phát triển phần mềm hiện đại.',
        'default_title_suffix' => 'Blog Lập trình Web & Kỹ thuật Hệ thống',
        'default_image' => env('APP_URL', 'http://localhost').'/images/og/ogimage.png',
        'default_image_svg' => env('APP_URL', 'http://localhost').'/images/og/ogimage.svg',
        'articles_image' => env('APP_URL', 'http://localhost').'/images/og/og-articles.png',
        'series_image' => env('APP_URL', 'http://localhost').'/images/og/og-series.png',
        'snippets_image' => env('APP_URL', 'http://localhost').'/images/og/og-snippets.png',
        'links_image' => env('APP_URL', 'http://localhost').'/images/og/og-links.png',
    ],
];
