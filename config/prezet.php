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
            480, 640, 768, 960, 1536,
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
    | Structured Data
    |--------------------------------------------------------------------------
    |
    | Prezet uses these values for JSON-LD structured data. 'authors' defines
    | named authors you can reference in front matter, and 'publisher' is used
    | as the default publisher for all content.
    |
    */

    // https://schema.org/author
    'authors' => [
        'bob' => [
            '@type' => 'Person',
            'name' => 'Bob',
            'url' => 'https://prezet.com/authors/prezet',
            'image' => '/prezet/img/bob.webp',
            'bio' => 'Bob là một nhà phát triển Laravel chuyên về công cụ frontend và các phương pháp kiểm thử. Anh ấy thích khám phá Blade, Vite và đảm bảo tính ổn định của ứng dụng thông qua việc kiểm thử mạnh mẽ.',
        ],
        'jane' => [
            '@type' => 'Person',
            'name' => 'Jane',
            'url' => 'https://prezet.com/authors/prezet',
            'image' => '/prezet/img/jane.webp',
            'bio' => 'Jane là một nhà phát triển backend chuyên về kiến trúc Laravel và tương tác cơ sở dữ liệu. Cô ấy thường xuyên viết về Eloquent, routing, queues và cấu trúc ứng dụng.',
        ],
        'prezet' => [
            '@type' => 'Person',
            'name' => 'Prezet',
            'url' => 'https://prezet.com',
            'image' => 'https://prezet.com/favicon.svg',
        ],
    ],

    // https://schema.org/publisher
    'publisher' => [
        '@type' => 'Organization',
        'name' => 'Prezet',
        'url' => 'https://prezet.com',
        'logo' => 'https://prezet.com/favicon.svg',
        'image' => 'https://prezet.com/ogimage.png',
    ],
];
