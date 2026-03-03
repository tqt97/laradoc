# Technical Decision: AJAX Filtering Implementation

This document outlines the technical choice made to improve the user experience of category and tag filtering on the Prezet blog.

## The Problem

Previously, clicking a category or tag triggered a full browser page reload. To direct the user to the results, a CSS anchor (`#articles`) was used. This resulted in:

1. **Jumpy UX:** The browser performed a native, instantaneous jump to the anchor, which felt jarring.
2. **Performance overhead:** Re-loading the entire layout (header, footer, sidebars) for a small content update in the main feed.
3. **Loss of State:** Any temporary UI state (like a partially typed search) would be lost.

## Comparison of Solutions

| Feature | Option A: Alpine.js (Manual Fetch) | Option B: HTMX (Declarative AJAX) |
| :--- | :--- | :--- |
| **Complexity** | High - Requires manual `fetch()`, DOM parsing, and state management. | **Low** - Uses declarative HTML attributes. |
| **Maintenance** | Logic is split between Blade templates and JavaScript files. | **Unified** - Logic stays entirely within the Blade template. |
| **SEO & SSR** | Requires careful handling of the initial state and SEO crawlers. | **Native** - Built on top of standard links, fully SEO-friendly. |
| **URL Handling** | Requires manual use of the `History API`. | **Automatic** - Handled via `hx-push-url`. |
| **Integration** | Requires custom "glue" code. | **Seamless** - Designed specifically for SSR frameworks like Laravel. |

## The Choice: HTMX

We chose **HTMX** as the primary technical solution for filtering.

### Why HTMX?

1. **Locality of Behavior:** We can see exactly what a link does just by looking at its attributes in the Blade file.
2. **Minimal JavaScript:** We avoided writing dozens of lines of imperative JavaScript, replacing them with 4-5 HTML attributes.
3. **Server-Side Rendered (SSR):** HTMX leverages Laravel's existing Blade rendering. The server continues to return full HTML, and HTMX intelligently swaps the relevant part.
4. **Reduced Payload:** While the server still renders the full page, HTMX only swaps the `#articles-content` div, reducing browser paint time.

## Implementation Benefits

### 1. Smooth Transitions
Instead of a jarring jump, we implemented a custom listener `onhtmx:after-settle`. This ensures that once the new articles are loaded into the DOM, the browser performs a **smooth, animated scroll** to the results section.

### 2. Layout Resilience (Minimal Content)
To handle cases where a filter results in only 1 article (which could make the page too short to scroll properly), we added:
-   **`min-h-[60vh]`**: Ensures the articles section always has enough height to allow the viewport to scroll past the hero section.
-   **Calculated Scroll Offsets**: Uses `offsetTop - 100` to perfectly clear the sticky header, ensuring content is never hidden behind the navigation bar.

### 3. "Boosted" Navigation

By using `hx-boost="true"`, we converted standard `<a>` tags into AJAX requests automatically. If a user has JavaScript disabled, the links still work as traditional anchors, maintaining **Progressive Enhancement**.

### 3. Precise DOM Swapping

Using `hx-select` and `hx-target`, we precisely extract the articles grid from the server's response and inject it into the current page. This keeps the header, sidebar, and search state perfectly intact during navigation.

## Future-Proofing

This implementation sets a standard for other interactive elements in the blog (like pagination or search refinements) to use the same declarative, SSR-friendly pattern.
