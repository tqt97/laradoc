<?php

namespace App\Console\Commands;

use App\Support\PrezetCache;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakePost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prezet:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Prezet markdown post with interactive setup';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // 1. Get Title
        $title = $this->ask('What is the title of the post?');

        if (! $title) {
            $this->error('Title is required!');

            return 1;
        }

        // 2. Get Category
        $categories = ['General', 'Tutorials', 'News', 'Features', 'Configuration', 'Testing'];
        $category = $this->choice('Select a category', $categories, 0);

        // 3. Get Author
        $authors = array_keys(config('prezet.authors', ['jane' => []]));
        $author = $this->choice('Select an author', $authors, array_search('jane', $authors) ?: 0);

        // 4. Get Parent Folder (Select or Create New)
        $baseDirectory = base_path('prezet/content');
        $subDirs = collect(File::directories($baseDirectory))
            ->map(fn ($dir) => basename($dir))
            ->prepend('/')
            ->push('[ Create New Folder ]')
            ->toArray();

        $folderChoice = $this->choice('Select parent folder', $subDirs, 0);

        if ($folderChoice === '[ Create New Folder ]') {
            $folder = $this->ask('Enter the name of the new folder');
            if (! $folder) {
                $this->warn('No folder name provided. Using root directory.');
                $folder = '';
            }
        } else {
            $folder = $folderChoice === '/' ? '' : $folderChoice;
        }

        $slug = Str::slug($title);
        $date = now()->format('Y-m-d');

        $targetDirectory = $folder ? $baseDirectory.'/'.trim($folder, '/') : $baseDirectory;

        if (! File::exists($targetDirectory)) {
            File::makeDirectory($targetDirectory, 0755, true);
        }

        $filePath = $targetDirectory.'/'.$slug.'.md';

        if (File::exists($filePath)) {
            $this->error("File already exists at: {$filePath}");

            return 1;
        }

        $frontmatter = <<<EOT
---
title: {$title}
excerpt: Enter a brief description of the post here.
date: {$date}
author: {$author}
category: {$category}
image: /prezet/img/ogimages/{$slug}.png
tags:
  - general
---

# {$title}

Start writing your content here...
EOT;

        File::put($filePath, $frontmatter);

        $this->info("Successfully created new post: {$filePath}");
        $this->info("Slug: {$slug}");
        $this->info("Date: {$date}");
        $this->info("Category: {$category}");
        $this->info("Author: {$author}");

        // 5. Default to update index
        if ($this->confirm('Update the Prezet index?', true)) {
            $this->info('Updating index...');
            $this->call('prezet:index');
            PrezetCache::invalidate();
        }

        return 0;
    }
}
