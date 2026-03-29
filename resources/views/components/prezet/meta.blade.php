@if (seo('title'))
    <title>@seo('title')</title>

    @unless (seo()->hasTag('og:title'))
        {{-- If an og:title tag is provided directly, it's included in the @foreach below --}}
        <meta property="og:title" content="@seo('title')" />
    @endunless
@else
    <title>{{ config('prezet.seo.title') }}</title>
@endif

@if (seo('description'))
    <meta property="og:description" content="@seo('description')" />
    <meta name="description" content="@seo('description')" />
@else
    <meta property="og:description" content="{{ config('prezet.seo.default_description') }}" />
    <meta name="description" content="{{ config('prezet.seo.default_description') }}" />
@endif

<meta name="robots" content="index, follow">

@if (seo('keywords'))
    <meta name="keywords" content="@seo('keywords')" />
@else
    <meta name="keywords" content="{{ config('prezet.seo.keywords') }}" />
@endif

@if (seo('type'))
    <meta property="og:type" content="@seo('type')" />
@else
    <meta property="og:type" content="website" />
@endif

<meta property="og:site_name" content="{{ config('prezet.seo.site_name') }}" />

@if (seo('locale'))
    <meta property="og:locale" content="@seo('locale')" />
@else
    <meta property="og:locale" content="vi_VN" />
@endif

@php
    $ogImage = seo('image') ?? config('prezet.seo.default_image');
    $isSvg = str_ends_with($ogImage, '.svg');

    // Retrieve and decode metadata from the JSON string stored in the Seo service
    $metadataString = seo('metadata');
    $metadata = [];
    if ($metadataString && is_string($metadataString)) {
        $metadata = json_decode($metadataString, true) ?? [];
    }

    $type = $metadata['type'] ?? (seo('type') ?: 'website');
    $author = $metadata['author'] ?? config('prezet.seo.author');
@endphp

<meta property="og:image" content="{{ $ogImage }}" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="630" />
<meta property="og:image:type" content="{{ $isSvg ? 'image/svg+xml' : 'image/png' }}" />
<meta property="og:image:alt" content="@seo('title')" />

@if (seo('url'))
    <meta property="og:url" content="@seo('url')" />
    <link rel="canonical" href="@seo('url')" />
@else
    <meta property="og:url" content="{{ url()->current() }}" />
    <link rel="canonical" href="{{ url()->current() }}" />
@endif

{{-- Article Metadata --}}
@if ($type === 'article')
    @if (isset($metadata['published_time']))
        <meta property="article:published_time" content="{{ $metadata['published_time'] }}" />
    @endif
    @if (isset($metadata['modified_time']))
        <meta property="article:modified_time" content="{{ $metadata['modified_time'] }}" />
    @endif
    <meta property="article:author" content="{{ $author }}" />
    @if (isset($metadata['section']))
        <meta property="article:section" content="{{ $metadata['section'] }}" />
    @endif
    @if (isset($metadata['tags']) && is_array($metadata['tags']))
        @foreach ($metadata['tags'] as $tag)
            <meta property="article:tag" content="{{ $tag }}" />
        @endforeach
    @endif
@endif

@foreach (seo()->tags() as $tag)
    {!! $tag !!}
@endforeach

<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="{{ config('prezet.seo.twitter_handle') }}" />

@if (seo('twitter.creator'))
    <meta name="twitter:creator" content="@seo('twitter.creator')" />
@else
    <meta name="twitter:creator" content="{{ config('prezet.seo.twitter_handle') }}" />
@endif

@if (seo('twitter.title'))
    <meta name="twitter:title" content="@seo('twitter.title')" />
@elseif (seo('title'))
    <meta name="twitter:title" content="@seo('title')" />
@endif

@if (seo('twitter.description'))
    <meta name="twitter:description" content="@seo('twitter.description')" />
@elseif (seo('description'))
    <meta name="twitter:description" content="@seo('description')" />
@else
    <meta name="twitter:description" content="{{ config('prezet.seo.default_description') }}" />
@endif

<meta name="twitter:image" content="{{ $ogImage }}" />
