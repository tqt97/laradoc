# Idea-to-Post Notification System: Technical Report & Implementation Plan

## 1. Executive Summary

This report outlines the proposed architecture for automatically notifying users when a blog post is created based on an idea they submitted. The system will bridge the gap between the **Database (Ideas)** and **Markdown Files (Posts)** using a unique identifier stored in the post's frontmatter.

---

## 2. Current State Analysis

- **Ideas (Database)**: Contains `id`, `name`, `user_name`, `email`, and `status`.
- **Posts (Filesystem)**: Markdown files in `prezet/content/blogs/`. Created via `php artisan prezet:make`.
- **Indexing**: `php artisan prezet:index` syncs file data into the `documents` table but does not currently interact with the `ideas` table.
- **Gap**: There is no automated mechanism to link a new Markdown file back to the original database ID of an idea.

---

## 3. Proposed Architecture: "The Linked ID Approach"

### A. Data Schema Changes

We will extend the Markdown Frontmatter to include an optional `idea_id`. When the Prezet indexer runs, this ID will be stored in the `documents` table's JSON `frontmatter` column.

**Target File**: `app/Data/CustomFrontmatterData.php`

- Add `public ?int $idea_id;`
- Update `defaults()` to include `idea_id => null`.

### B. Developer Workflow Enhancement

Update the `php artisan prezet:make` command (`MakePost.php`) to be "Idea Aware":

1. After asking for the title, the command will query the database for "Pending Ideas" (`status = 'submitted'`).
2. If ideas exist, it will present a searchable list to the developer.
3. If an idea is selected, the command will automatically inject `idea_id: [ID]` into the generated Markdown file's frontmatter.

### C. Synchronization & Notification Logic

A new command `php artisan idea:sync-published` will be created to handle the notification lifecycle. This command should be run after `php artisan prezet:index`.

**Logic Flow**:

1. Query `PrezetDocument` where `frontmatter->idea_id` is not null.
2. For each document:
   - Find the corresponding `Idea` record by ID.
   - **Validation**: Ensure the Idea status is still `submitted`.
   - **Update**: Set Idea status to `published` and store the `post_slug`.
   - **Notification**: Dispatch a **Queued Email** (`IdeaPublished` mailable) to the user's email address.

---

## 4. Technical Advantages

1. **Source of Truth in Content**: The link between the idea and the post is stored in the Markdown file. This makes the relationship permanent and version-controllable via Git.
2. **Asynchronous Execution**: Using Laravel's Mail Queue ensures that the indexing and syncing process remains fast and does not fail if the mail server is slow.
3. **Low Overhead**: Does not require complex database triggers or observers on the `documents` table.

---

## 5. Implementation Roadmap

1. [ ] **Phase 1**: Update `CustomFrontmatterData` to support `idea_id`.
2. [ ] **Phase 2**: Enhance `MakePost` command with interactive idea selection.
3. [ ] **Phase 3**: Create the `IdeaPublished` Mailable template.
4. [ ] **Phase 4**: Implement the `idea:sync-published` command for automated notifications.
5. [ ] **Phase 5**: Update deployment scripts (or `composer.json` scripts) to run the sync command after indexing.

---

## 6. Security & Edge Cases

- **Missing Emails**: If an idea was submitted without an email, the status will still be updated to `published`, but the email step will be skipped.
- **Duplicate Links**: If multiple posts link to the same `idea_id`, the notification will only be sent for the first one processed (guarded by the status check).
- **Deleted Ideas**: The sync command will gracefully handle (ignore) cases where an `idea_id` in a post points to a deleted database record.
