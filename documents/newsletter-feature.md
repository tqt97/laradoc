# Newsletter Feature Technical Documentation

This document provides a comprehensive overview of the Newsletter Feature implementation for other developers to understand, maintain, and extend.

## Table of Contents

- [Newsletter Feature Technical Documentation](#newsletter-feature-technical-documentation)
  - [Table of Contents](#table-of-contents)
  - [1. Overview](#1-overview)
  - [2. Database Schema](#2-database-schema)
  - [3. Model Implementation](#3-model-implementation)
  - [4. Subscription Logic](#4-subscription-logic)
    - [Controller](#controller)
    - [Routes](#routes)
    - [Frontend Component](#frontend-component)
  - [5. Mailing System (Queued)](#5-mailing-system-queued)
    - [Mailable Class](#mailable-class)
    - [Email Template](#email-template)
  - [6. Automated Newsletter Task](#6-automated-newsletter-task)
    - [Artisan Command](#artisan-command)
    - [Scheduling](#scheduling)
  - [7. CLI Commands](#7-cli-commands)
    - [Create a New Post](#create-a-new-post)
    - [Send Weekly Newsletter](#send-weekly-newsletter)
  - [8. Dependencies \& Requirements](#8-dependencies--requirements)

---

## 1. Overview

The Newsletter feature allows users to subscribe to weekly updates. It includes a subscription form in the footer, a database to store subscribers, and an automated command that finds articles from the last 7 days and emails them to active subscribers.

## 2. Database Schema

The system uses a single table `subscribers` to store email addresses and their subscription status.

**Migration:** `database/migrations/2026_03_05_135908_create_subscribers_table.php`

```php
Schema::create('subscribers', function (Blueprint $table) {
    $table->id();
    $table->string('email')->unique();
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
```

## 3. Model Implementation

The `Subscriber` model handles data interaction and fillable attributes.

**Model:** `app/Models/Subscriber.php`

```php
class Subscriber extends Model
{
    protected $fillable = ['email', 'is_active'];
}
```

## 4. Subscription Logic

### Controller

The `NewsletterController` handles the subscription request, performs validation, and stores the new subscriber.

**Controller:** `app/Http/Controllers/NewsletterController.php`

- `subscribe(Request $request)`: Validates that the email is unique in the `subscribers` table and saves it.

### Routes

Two groups of routes are relevant:

1. The **Subscription POST Route**: Handles the form submission.
2. **Main Prezet Routes**: These MUST have `StartSession` and `ShareErrorsFromSession` middleware enabled so that `@error` and `session('success')` work correctly in the footer.

**Routes:** `routes/web.php`

```php
Route::post('newsletter/subscribe', [NewsletterController::class, 'subscribe'])
    ->name('newsletter.subscribe');
```

### Frontend Component

The subscription form is integrated into the global template footer.

**View:** `resources/views/components/prezet/template.blade.php`

- Uses `@csrf` for security.
- Uses `@error('email')` for validation feedback.
- Uses `session('success')` to show a thank-you message.

## 5. Mailing System (Queued)

### Mailable Class

The `WeeklyNewsletter` mailable implements the `ShouldQueue` interface to offload email sending to background processes.

**Mailable:** `app/Mail/WeeklyNewsletter.php`

- Implements: `ShouldQueue`
- Constructor: `public function __construct(public Collection $articles)`
- Subject: "Weekly Laravel News"

### Email Template

A professional HTML template designed for compatibility across email clients.

**Template:** `resources/views/emails/newsletter.blade.php`

- Styles: Professional CSS with Zinc-900 accents.
- Content: Includes article images, titles, excerpts, and "Read Full Article" call-to-action buttons.

## 6. Automated Newsletter Task

### Artisan Command

The `newsletter:send-weekly` command is the engine of the automated system.

**Command:** `app/Console/Commands/SendWeeklyNewsletter.php`

1. Calculates the date for 7 days ago.
2. Queries the `Document` model for articles published within that range.
3. If new articles exist, it fetches all active subscribers.
4. Sends the `WeeklyNewsletter` mailable to each subscriber (automatically queued).

### Scheduling

The command is scheduled to run once a week.

**Schedule:** `routes/console.php`

```php
Schedule::command('newsletter:send-weekly')->weeklyOn(1, '09:00'); // Mondays at 9 AM
```

## 7. CLI Commands

### Create a New Post

A convenience command to create a new markdown post with a fully interactive setup.

```bash
php artisan prezet:make
```

This command will interactively guide you through:

1. **Title**: Prompts for the post title and generates a slug.
2. **Category**: Choose from a list of predefined categories.
3. **Author**: Select from authors configured in `config/prezet.php`.
4. **Parent Folder**: Choose an existing sub-folder, or select **[ Create New Folder ]** to input a new directory name.
5. **Index Update**: Defaults to updating the Prezet index after creation.

### Send Weekly Newsletter

Manually trigger the weekly newsletter sending.

```bash
php artisan newsletter:send-weekly
```

## 8. Dependencies & Requirements

- **Middleware**: The routes displaying the form MUST have session-related middleware enabled (`StartSession`, `ShareErrorsFromSession`). Without these, the `$errors` variable will be undefined in the view.
- **Mail Configuration**: Standard Laravel mail settings in `.env` (SMTP, Mailgun, etc.) must be configured.
- **Queue Worker**: Since emails are queued, a queue worker must be running:
  `php artisan queue:work`
- **Cron Job**: The server must have the Laravel scheduler cron job running:
  `* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1`
