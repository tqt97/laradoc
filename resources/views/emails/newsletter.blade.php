<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Weekly Laravel News from Laradoc</title>
    <style type="text/css">
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f7;
            color: #51545e;
            margin: 0;
            padding: 0;
            width: 100% !important;
            -webkit-text-size-adjust: none;
        }
        .wrapper {
            background-color: #f4f4f7;
            padding: 40px 0;
        }
        .content {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .header {
            background-color: #18181b;
            padding: 40px 20px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.025em;
        }
        .header p {
            color: #a1a1aa;
            margin: 10px 0 0;
            font-size: 14px;
        }
        .body {
            padding: 40px 30px;
        }
        .welcome-text {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
            color: #3f3f46;
        }
        .article {
            margin-bottom: 40px;
            border-bottom: 1px solid #f4f4f5;
            padding-bottom: 40px;
        }
        .article:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .article-image {
            width: 100%;
            border-radius: 12px;
            margin-bottom: 20px;
        }
        .article h2 {
            margin: 0 0 12px;
            font-size: 20px;
            font-weight: 700;
            color: #18181b;
            line-height: 1.3;
        }
        .article h2 a {
            color: #18181b;
            text-decoration: none;
        }
        .article-excerpt {
            font-size: 15px;
            line-height: 1.6;
            color: #71717a;
            margin-bottom: 20px;
        }
        .button {
            display: inline-block;
            background-color: #18181b;
            color: #ffffff !important;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            text-align: center;
        }
        .meta {
            font-size: 12px;
            color: #a1a1aa;
            margin-top: 15px;
            display: block;
        }
        .footer {
            text-align: center;
            padding: 30px;
            font-size: 12px;
            color: #a1a1aa;
        }
        .footer p {
            margin: 5px 0;
        }
        .footer a {
            color: #71717a;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="content">
            <div class="header">
                <h1>Laradoc Weekly</h1>
                <p>The best of Laravel development, delivered to your inbox.</p>
            </div>
            <div class="body">
                <p class="welcome-text">Hi there! 👋 Here's a curated collection of our latest stories, tutorials, and insights from the past week.</p>

                @foreach($articles as $article)
                    <div class="article">
                        @if($article->frontmatter->image)
                            <img src="{{ url($article->frontmatter->image) }}" alt="{{ $article->frontmatter->title }}" class="article-image" />
                        @endif
                        <h2><a href="{{ route('prezet.show', $article->slug) }}">{{ $article->frontmatter->title }}</a></h2>
                        <p class="article-excerpt">{{ $article->frontmatter->excerpt }}</p>
                        <a href="{{ route('prezet.show', $article->slug) }}" class="button">Read Full Article</a>
                        <span class="meta">{{ $article->createdAt->format('d/m/Y') }}</span>
                    </div>
                @endforeach
            </div>
            <div class="footer">
                <p>&copy; {{ date('Y') }} Laradoc. All rights reserved.</p>
                <p>You're receiving this because you're a valued subscriber to our newsletter.</p>
                <p><a href="#">Unsubscribe</a> • <a href="{{ config('app.url') }}">Visit Website</a></p>
            </div>
        </div>
    </div>
</body>
</html>
