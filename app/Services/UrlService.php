<?php

namespace App\Services;

use App\Models\ShortUrl;
use App\Repositories\UrlRepository;

class UrlService
{
    protected $urlRepository;

    public function __construct(UrlRepository $urlRepository)
    {
        $this->urlRepository = $urlRepository;
    }


    // Handle redirection logic
    public function handleRedirect($shortCode)
    {
        $url = $this->urlRepository->findByShortCode($shortCode);
        if ($url) {
            $this->urlRepository->incrementClickCount($url);
            return $url->original_url;
        }
        return null;
    }

    // Get user-specific URLs
    public function getUserUrls($userId)
    {
        return $this->urlRepository->getUserUrls($userId);
    }
    /**
     * Get the shortened URLs and their statistics for a specific user.
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserUrlsWithStatistics($userId)
    {
        return $this->urlRepository->getUserUrlsWithStatistics($userId);
    }
    /**
     * Create a shortened URL.
     *
     * @param string $originalUrl
     * @return ShortUrl
     */
    public function createShortUrl(string $originalUrl)
    {
        $shortUrl = new ShortUrl();
        $shortUrl->original_url = $originalUrl;
        $shortUrl->short_code = $this->generateShortCode();
        $shortUrl->user_id = auth()->id(); // Assign to authenticated user
        $shortUrl->click_count = 0; // Initialize click count
        $shortUrl->save();

        return $shortUrl;
    }

    /**
     * Generate a unique short code.
     *
     * @return string
     */
    protected function generateShortCode()
    {
        return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6);
    }
}