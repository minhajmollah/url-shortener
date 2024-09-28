<?php

namespace App\Repositories;

use App\Models\ShortUrl;
use Illuminate\Support\Str;

class UrlRepository
{
    // Create a new short URL in the database
    public function createUrl(array $data)
    {
        $data['short_code'] = $this->generateShortCode();
        return ShortUrl::create($data);
    }

    // Find a URL by short code
    public function findByShortCode(string $shortCode)
    {
        return ShortUrl::where('short_code', $shortCode)
            ->where('is_active', true)
            ->first();
    }

    // Generate unique short code
    private function generateShortCode()
    {
        do {
            $shortCode = Str::random(6);
        } while (ShortUrl::where('short_code', $shortCode)->exists());

        return $shortCode;
    }

    // Increment click count for a short URL
    public function incrementClickCount(ShortUrl $shortUrl)
    {
        $shortUrl->click_count++;
        $shortUrl->save();
    }

    // Fetch all URLs for a user
    public function getUserUrls(int $userId)
    {
        return ShortUrl::where('user_id', $userId)->get();
    }

    /**
     * Get the shortened URLs and their statistics for a specific user.
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserUrlsWithStatistics(int $userId)
    {
        return ShortUrl::where('user_id', $userId)->get();
    }
}
