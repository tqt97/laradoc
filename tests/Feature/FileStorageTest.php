<?php

namespace Tests\Feature;

use App\Models\File;
use App\Models\User;
use App\Services\Feature;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class FileStorageTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        // Create super-admin role and user
        Role::create(['name' => 'super-admin']);
        $this->admin = User::factory()->create();
        $this->admin->assignRole('super-admin');

        // Seed features
        $this->artisan('db:seed', ['--class' => 'FeatureSeeder']);

        // Clear feature cache
        app(Feature::class)->clearCache();
    }

    public function test_admin_can_access_files_index()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('files.index'));

        $response->assertStatus(200);
        $response->assertSee('Quản lý tệp tin');
    }

    public function test_admin_can_upload_txt_file()
    {
        $file = UploadedFile::fake()->create('test.txt', 100, 'text/plain');

        $response = $this->actingAs($this->admin)
            ->withoutMiddleware(ValidateCsrfToken::class)
            ->post(route('files.upload'), [
                'file' => $file,
            ]);

        $record = File::first();
        $this->assertNotNull($record, 'File was not created in database');

        $response->assertRedirect(route('files.show', $record));

        Storage::disk('public')->assertExists($record->path);
        $this->assertEquals('test.txt', $record->name);

        // Check activity log
        $this->assertDatabaseHas('activity_log', [
            'subject_id' => $record->id,
            'subject_type' => File::class,
            'description' => "upload file_id={$record->id}",
        ]);
    }

    public function test_admin_can_preview_file()
    {
        $file = File::create([
            'name' => 'test.txt',
            'path' => 'uploads/test.txt',
            'mime_type' => 'text/plain',
            'size' => 100,
            'disk' => 'public',
            'share_token' => 'token123',
        ]);

        Storage::disk('public')->put('uploads/test.txt', 'Hello World');

        $response = $this->actingAs($this->admin)
            ->get(route('files.show', $file));

        $response->assertStatus(200);
        $response->assertSee('Hello World');

        // Check activity log
        $this->assertDatabaseHas('activity_log', [
            'subject_id' => $file->id,
            'subject_type' => File::class,
            'description' => "preview file_id={$file->id}",
        ]);
    }

    public function test_admin_can_set_share_settings()
    {
        $file = File::create([
            'name' => 'test.txt',
            'path' => 'uploads/test.txt',
            'mime_type' => 'text/plain',
            'size' => 100,
            'disk' => 'public',
            'share_token' => 'token123',
        ]);

        $response = $this->actingAs($this->admin)
            ->withoutMiddleware(ValidateCsrfToken::class)
            ->post(route('files.share', $file), [
                'is_public' => true,
                'password' => 'secret123',
            ]);

        $response->assertStatus(200);

        $file->refresh();
        $this->assertTrue($file->is_public);

        // Check activity log
        $this->assertDatabaseHas('activity_log', [
            'subject_id' => $file->id,
            'subject_type' => File::class,
            'description' => "share_update file_id={$file->id}",
        ]);
    }

    public function test_public_can_access_shared_file_with_password()
    {
        $file = File::create([
            'name' => 'test.txt',
            'path' => 'uploads/test.txt',
            'mime_type' => 'text/plain',
            'size' => 100,
            'disk' => 'public',
            'is_public' => true,
            'share_token' => 'token123',
            'password' => Hash::make('secret123'),
        ]);

        Storage::disk('public')->put('uploads/test.txt', 'Hello World');

        // Access with correct password
        $response = $this->get(route('files.shared', ['token' => 'token123', 'password' => 'secret123']));
        $response->assertStatus(200);

        // Check activity log
        $this->assertDatabaseHas('activity_log', [
            'subject_id' => $file->id,
            'subject_type' => File::class,
            'description' => "shared_preview file_id={$file->id}",
        ]);
    }
}
