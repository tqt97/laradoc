---
title: "Markdown Tutorial: Mastery Guide"
date: 2026-03-07
category: Features
excerpt: A comprehensive guide to using all the Markdown features supported by Prezet, including standard syntax and advanced extensions.
image: /prezet/img/ogimage.webp
author: prezet
tags: ["markdown", "tutorial", "guide"]
---

# Markdown Tutorial: Mastery Guide

This document demonstrates and explains all the Markdown features available in this blog. Prezet uses the [League CommonMark](https://commonmark.thephpleague.com/) parser with several powerful extensions enabled.

[TOC]

## Basic Syntax

### Headings

You can create headings using `#` symbols. The number of `#` corresponds to the heading level.

```markdown
# Heading 1
## Heading 2
### Heading 3
```

### Emphasis

- **Bold**: `**text**` or `__text__`
- *Italic*: `*text*` or `_text_`
- ~~Strikethrough~~: `~~text~~` (Strikethrough Extension)

### Lists

#### Unordered

- Item 1
- Item 2
  - Sub-item 2.1

#### Ordered

1. First item
2. Second item

#### Task Lists (TaskList Extension)

- [x] Completed task
- [ ] Incomplete task

### Links and Images

- [Google](https://www.google.com)
- Autolink: <https://prezet.com> (Autolink Extension)
- Images: `![Alt text](/path/to/image.webp)`

## Advanced Features

### Tables (Table Extension)

| Feature | Supported | Extension |
| :--- | :---: | ---: |
| Tables | Yes | `TableExtension` |
| Task Lists | Yes | `TaskListExtension` |
| TOC | Yes | `TableOfContentsExtension` |

### Footnotes (Footnote Extension)

Here is a simple footnote[^1]. With footnotes, you can provide extra context at the bottom of the page.

[^1]: This is the footnote content.

### Attributes (Attributes Extension)

You can add CSS classes, IDs, or other attributes to elements.

This paragraph has a red color. {.text-red-500}

### Description Lists (DescriptionList Extension)

Term 1
: Definition 1

Term 2
: Definition 2

### Mentions (MentionExtension)

You can mention GitHub users by their handle: @prezet. This will automatically link to their GitHub profile.

### Smart Punctuation (SmartPunctExtension)

- "Smart quotes" and 'single quotes' are automatically handled.
- Dashes: En-dash (--) or Em-dash (---)
- Ellipses: ...

### Table of Contents (TableOfContentsExtension)

Use the `[TOC]` placeholder at the top of your document to automatically generate a nested list of links based on your headings.

### External Links (ExternalLinkExtension)

Links to external sites like [Laravel](https://laravel.com) are automatically opened in a new tab and given `rel="nofollow"` attributes for SEO safety.

## Prezet Specific Features

### Blade Components (MarkdownBladeExtension)

You can use Laravel Blade components directly in your Markdown!

<x-prezet.alert type="info">
    This is a Prezet Alert component rendered inside Markdown!
</x-prezet.alert>

### Code Highlighting (PhikiExtension)

Code blocks are beautifully highlighted using Phiki.

```php
public function hello()
{
    return "Hello Prezet!";
}
```

### Front Matter (FrontMatterExtension)

Metadata for each post is defined at the top of the file in YAML format.

```yaml
---
title: "My Post"
date: 2026-03-07
category: News
---
```

## Tips and Tricks

1. **Line Breaks**: End a line with two or more spaces to create a `<br>`.
2. **Horizontal Rules**: Use `---` on a new line.
3. **Escaping**: Use `\` to escape markdown characters, e.g., \*not italic\*.
