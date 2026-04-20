<?php

/**
 * Feature Flag Configuration
 *
 * This file manages the availability and access control for various features
 * within the application. Features are grouped by their primary UI location
 * and further categorized by their access level (Public vs. Restricted).
 *
 * Each feature entry supports:
 * - 'enabled': Global toggle (Boolean or via .env)
 * - 'roles': Array of roles allowed to access (empty for public)
 * - 'show': Whether to display in UI navigation (Boolean)
 * - 'location': UI placement identifier (e.g., 'header-left')
 * - 'description': Brief summary of the feature's purpose
 */

return [

    /*
    |--------------------------------------------------------------------------
    | HEADER NAVIGATION (LEFT)
    |--------------------------------------------------------------------------
    | These features appear in the main application header navigation.
    */

    // --- Public Features ---

    'articles' => [
        'enabled' => env('FEATURE_ARTICLES_ENABLED', true),
        'roles' => [],
        'show' => true,
        'location' => 'header-left',
        'description' => 'Blog posts and technical articles.',
        'ui' => [
            'text' => 'Bài viết',
            'route' => 'prezet.articles',
            'icon' => 'prezet.icon-article',
        ],
    ],

    'knowledge' => [
        'enabled' => env('FEATURE_KNOWLEDGE_ENABLED', true),
        'roles' => [],
        'show' => true,
        'location' => 'header-left',
        'description' => 'Structured knowledge review modules.',
        'ui' => [
            'text' => 'Kiến thức',
            'route' => 'knowledge.index',
            'route_active' => 'knowledge*',
            'icon' => 'prezet.icon-knowledge',
        ],
    ],

    'stories' => [
        'enabled' => env('FEATURE_STORIES_ENABLED', true),
        'roles' => [],
        'show' => true,
        'location' => 'header-left',
        'description' => 'Personal stories and diary entries.',
        'ui' => [
            'text' => 'Nhật ký',
            'route' => 'stories.index',
            'route_active' => 'stories*',
            'icon' => 'prezet.icon-story',
        ],
    ],

    'series' => [
        'enabled' => env('FEATURE_SERIES_ENABLED', true),
        'roles' => [],
        'show' => true,
        'location' => 'header-left',
        'description' => 'Curated collections of related posts.',
        'ui' => [
            'text' => 'Chuỗi bài viết',
            'route' => 'prezet.series.index',
            'route_active' => 'series*',
            'icon' => 'prezet.icon-series',
        ],
    ],

    'links' => [
        'enabled' => env('FEATURE_LINKS_ENABLED', true),
        'roles' => [],
        'show' => true,
        'location' => 'header-left',
        'description' => 'Collection of external resources and links.',
        'ui' => [
            'text' => 'Liên kết',
            'route' => 'links.index',
            'icon' => 'prezet.icon-link',
        ],
    ],

    'snippets' => [
        'enabled' => env('FEATURE_SNIPPETS_ENABLED', true),
        'roles' => [],
        'show' => true,
        'location' => 'header-left',
        'description' => 'Reusable code blocks and tips.',
        'ui' => [
            'text' => 'Snippets',
            'route' => 'snippets.index',
            'icon' => 'prezet.icon-snippet',
        ],
    ],

    'ideas' => [
        'enabled' => env('FEATURE_IDEAS_ENABLED', false),
        'roles' => [],
        'show' => false,
        'location' => 'header-left',
        'description' => 'Community-driven content suggestions.',
        'ui' => [
            'text' => 'Gợi ý bài viết',
            'route' => 'ideas.index',
            'is_special' => true,
        ],
    ],

    // --- Restricted Features ---

    'gallery' => [
        'enabled' => env('FEATURE_GALLERY_ENABLED', true),
        'roles' => ['super-admin'],
        'show' => true,
        'location' => 'header-left',
        'description' => 'Visual media and image gallery.',
        'ui' => [
            'text' => 'Thư viện',
            'route' => 'gallery.index',
            'icon' => 'prezet.icon-gallery',
            'special_classes' => 'bg-primary-50 text-primary-600 dark:bg-primary-900/20 dark:text-primary-400',
        ],
    ],

    'portfolio' => [
        'enabled' => env('FEATURE_PORTFOLIO_ENABLED', true),
        'roles' => ['super-admin'],
        'show' => true,
        'location' => 'header-left',
        'description' => 'Project showcase and professional highlights.',
        'ui' => [
            'text' => 'Portfolio',
            'route' => 'portfolio.index',
            'icon' => 'prezet.icon-portfolio',
            'special_classes' => 'text-pink-600 dark:text-pink-400',
        ],
    ],

];
