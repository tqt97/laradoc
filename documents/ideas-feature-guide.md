# Comprehensive Guide: The Ideas Feature

This document provides a detailed overview of the "Ideas" module, including its functionality, technical architecture, and step-by-step usage instructions.

---

## 1. Feature Overview

The Ideas module allows the community to suggest topics for future blog posts. It features a modern, interactive interface where users can submit ideas, vote for their favorites, and receive automated email updates when their ideas are officially published as articles.

### Key Capabilities

- **Async Submission**: Submit ideas via a sleek form without page reloads.
- **Dynamic List**: Search, filter, and sort ideas asynchronously with a 750ms debounce.
- **Toggle Voting**: Community-driven prioritization with IP-based tracking. Users can both vote and unvote.
- **Detail Modals**: Focused view for reading full idea descriptions and references with sticky action buttons.
- **Idea-to-Post Linking**: Direct integration with the Prezet content creation workflow via Frontmatter.
- **Automated Notifications**: Fun and engaging queued emails for submission acknowledgement and publication alerts.

---

## 2. The Lifecycle Flow

1. **Submission**: User fills out the form (Name, Email, Idea, Category, References).
2. **Acknowledgement**: If an email is provided, the system sends a fun "Thank you" email (`IdeaSubmitted`) via the queue.
3. **Community Engagement**: Other users browse the list, search for topics (min 2 chars), and toggle votes. Voted items are highlighted with a soft orange tint.
4. **Content Creation**: An admin uses `php artisan prezet:make` to create a new post, selecting a pending idea from the interactive prompt.
5. **Indexing & Sync**: The admin runs `composer prezet-index`. This syncs the Markdown file to the database and identifies the linked idea ID from the frontmatter.
6. **Publication Notification**: The system updates the idea status to `published`, saves the `post_slug`, and sends a celebratory notification email (`IdeaPublished`) to the original submitter with a direct link to the new article.

---

## 3. Technical Architecture

### Database Schema

- **`ideas` table**:
  - `user_name`, `email`: Submitter info.
  - `name`: The detailed idea content (Textarea).
  - `status`: `submitted` (default) or `published`.
  - `post_slug`: Link to the resulting Prezet article.
  - `votes_count`: Cached count for performance.
- **`idea_votes` table**:
  - `idea_id`: Foreign key.
  - `ip_address`, `user_agent`: Used for unique identification and rate limiting.

### Backend Components

- **`IdeaService`**: Handles business logic, including complex filtering, sorting, and the `toggleVote` mechanism.
- **`IdeaController`**: Manages HTTP requests, returning JSON for votes/submissions and Blade partials for the dynamic list.
- **`SyncPublishedIdeas` Command**: Parsed `idea_id` from `PrezetDocument` frontmatter to close the loop.
- **Mailables**:
  - `IdeaSubmitted`: Subject: `🎯 Một chiếc ý tưởng "triệu đô" vừa hạ cánh! Cảm ơn bạn nhé 🚀`
  - `IdeaPublished`: Subject: `✨ Bùm chíu! Ý tưởng của bạn vừa "lên sóng" rồi đó, xem ngay thôi! 🎊`

### Frontend Components

- **Alpine.js**: Manages state for the form, list filters, detail modal, and AJAX request tracking (preventing race conditions).
- **Blade Partials**: `ideas.partials.list` dynamically re-rendered via AJAX.
- **Local Storage**: Persists user name and email if "Ghi nhớ thông tin" is checked.

---

## 4. How to Use (Step-by-Step)

### A. Submitting an Idea

1. Navigate to `/ideas`.
2. Enter details. Check "Ghi nhớ thông tin" to save typing next time.
3. Submit. A success toast appears, and the list refreshes automatically.

### B. Creating a Post from an Idea

1. Run: `php artisan prezet:make`
2. Answer `yes` to `Does this post relate to an existing idea?`.
3. Select the idea from the list.
4. The file is created with `idea_id: XX` in the header.

### C. Publishing & Notifying

1. Once your Markdown is ready, run:

   ```bash
   composer prezet-index
   ```

2. The system syncs the file, updates the idea status, and emails the user automatically.

---

## 5. Maintenance & Optimization

### Rate Limiting

- **Voting**: 30 requests per minute per IP (`routes/web.php`).
- **Search**: 750ms debounce to protect the server.

### UI/UX Details

- **Loading State**: A top-bar shimmer and list dimming provide feedback during AJAX fetches.
- **Responsive Design**: Filters stack vertically on mobile and horizontally on desktop.
- **Empty State**: Friendly messaging when no ideas match search criteria.

---

## 6. Key Files for Reference

- **Controller**: `app/Http/Controllers/IdeaController.php`
- **Service**: `app/Services/IdeaService.php`
- **Model**: `app/Models/Idea.php`
- **Sync Command**: `app/Console/Commands/SyncPublishedIdeas.php`
- **List Partial**: `resources/views/ideas/partials/list.blade.php`
- **Mail Templates**: `resources/views/emails/ideas/`
