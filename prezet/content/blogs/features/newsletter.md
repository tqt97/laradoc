---
title: Newsletter Subscription
excerpt: Engage your readers with weekly newsletters automatically generated from your latest articles.
author: jane
category: features
date: 2026-03-03
image: /prezet/img/ogimages/blogs-features-newsletter.webp
tags: [newsletter, marketing, engagement]
---

# Newsletter Subscription

Keep your audience engaged with the built-in newsletter system. This feature allows readers to subscribe to your blog and receive weekly updates about your latest Laravel development stories and tutorials.

## Features

- **Compact Footer Integration**: A clean, minimalist subscription form integrated into the footer.
- **Automated Weekly Sending**: A scheduled Artisan command that collects articles from the last 7 days.
- **Queued Mail Delivery**: High-performance mailing system that handles large numbers of subscribers without slowing down the server.
- **Beautiful Email Templates**: Professionally styled, responsive HTML emails with article images and clear call-to-actions.
- **Subscriber Management**: A simple `subscribers` table to manage active and inactive subscribers.

## Subscription Form

The subscription form is located in the global footer. It uses standard Laravel form handling with CSRF protection and validation to ensure only valid email addresses are stored.

## Technical Implementation

### Database Schema

The system uses a simple `subscribers` table:

```php
Schema::create('subscribers', function (Blueprint $table) {
    $table->id();
    $table->string('email')->unique();
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
```

### Queued Mailing System

The system uses Laravel Queues to handle large volumes of email efficiently. The `WeeklyNewsletter` mailable implements the `ShouldQueue` interface, ensuring that email delivery happens in the background.

```php
use Illuminate\Contracts\Queue\ShouldQueue;

class WeeklyNewsletter extends Mailable implements ShouldQueue
{
    // ...
}
```

### Weekly Sending Logic

The newsletter is powered by an Artisan command:

```bash
php artisan newsletter:send-weekly
```

This command:

1. Filters articles published in the last 7 days.
2. Uses the `WeeklyNewsletter` mailable to send HTML emails.
3. Automatically queues the emails for background delivery.

### Scheduling

The command is scheduled to run every **Monday at 9:00 AM** in `routes/console.php`:

```php
use Illuminate\Support\Facades\Schedule;
Schedule::command('newsletter:send-weekly')->weeklyOn(1, '09:00');
```

## Running the Queue

To ensure queued emails are delivered, you must run the queue worker on your server:

```bash
php artisan queue:work
```

## Customization

### Email Template

Edit the look and feel of your newsletter:
`resources/views/emails/newsletter.blade.php`

### Sending Frequency

Modify the schedule in `routes/console.php` to change when the newsletter is sent.
