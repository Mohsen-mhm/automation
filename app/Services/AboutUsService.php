<?php

namespace App\Services;

use App\Models\AboutUs;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AboutUsService
{
    /**
     * Get the about us content
     */
    public function getAboutUs(): ?AboutUs
    {
        return AboutUs::first();
    }

    /**
     * Update about us content
     */
    public function updateAboutUs(AboutUs $aboutUs, array $data, ?UploadedFile $image = null): bool
    {
        try {
            // Handle image upload if provided
            if ($image) {
                // Delete old image if exists
                if ($aboutUs->image && Storage::exists($aboutUs->image)) {
                    Storage::delete($aboutUs->image);
                }

                $imagePath = $this->uploadImage($image);
                $data['image'] = $imagePath;
            }

            return $aboutUs->update($data);

        } catch (\Exception $e) {
            \Log::error('Error updating about us: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Upload image and return path
     */
    public function uploadImage(UploadedFile $image): string
    {
        try {
            $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $path = 'about/' . now()->year . '/' . now()->month . '/' . now()->day;

            // Store in storage/app/public
            $fullPath = $image->storeAs($path, $imageName, 'public');

            return 'storage/' . $fullPath;

        } catch (\Exception $e) {
            \Log::error('Error uploading image: ' . $e->getMessage());
            throw new \Exception('خطا در آپلود تصویر');
        }
    }

    /**
     * Get image URL
     */
    public function getImageUrl(?string $imagePath): string
    {
        if (!$imagePath) {
            return "https://placehold.co/600x400/EEE/31343C?text=تصویر+یافت+نشد";
        }

        return asset($imagePath);
    }

    /**
     * Delete image file
     */
    public function deleteImage(string $imagePath): bool
    {
        try {
            if (Storage::exists(str_replace('storage/', '', $imagePath))) {
                return Storage::delete(str_replace('storage/', '', $imagePath));
            }
            return true;
        } catch (\Exception $e) {
            \Log::error('Error deleting image: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Validate and clean HTML content
     */
    public function cleanHtmlContent(string $content): string
    {
        // Allow specific HTML tags for rich text content
        $allowedTags = '<p><br><strong><em><u><ul><ol><li><h1><h2><h3><h4><h5><h6><a><blockquote><code><pre><img><table><tr><td><th><thead><tbody>';

        return strip_tags($content, $allowedTags);
    }

    /**
     * Get content preview (truncated)
     */
    public function getContentPreview(string $content, int $length = 150): string
    {
        $plainText = strip_tags($content);

        if (strlen($plainText) <= $length) {
            return $plainText;
        }

        return substr($plainText, 0, $length) . '...';
    }

    /**
     * Create default about us if none exists
     */
    public function createDefault(): AboutUs
    {
        return AboutUs::create([
            'title' => 'درباره ما',
            'description' => '<p>محتوای درباره ما در اینجا قرار می‌گیرد.</p>',
            'image' => null
        ]);
    }

    /**
     * Get about us data for API
     */
    public function getApiData(): array
    {
        $aboutUs = $this->getAboutUs();

        if (!$aboutUs) {
            return [
                'title' => '',
                'description' => '',
                'image' => null,
                'image_url' => $this->getImageUrl(null)
            ];
        }

        return [
            'id' => $aboutUs->id,
            'title' => $aboutUs->title,
            'description' => $aboutUs->description,
            'image' => $aboutUs->image,
            'image_url' => $this->getImageUrl($aboutUs->image),
            'content_preview' => $this->getContentPreview($aboutUs->description),
            'updated_at' => $aboutUs->updated_at?->format('Y-m-d H:i:s')
        ];
    }
}
