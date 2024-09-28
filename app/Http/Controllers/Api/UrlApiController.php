<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UrlService;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class UrlApiController extends Controller
{
    protected $UrlService;

    public function __construct(UrlService $UrlService)
    {
        $this->UrlService = $UrlService;
    }

    /**
     * Shorten a given URL.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function shorten(Request $request)
    {
        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'url' => 'required|url',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        // Create shortened URL
        $shortUrl = $this->UrlService->createShortUrl($request->url);

        return response()->json([
            'original_url' => $request->url,
            'shortened_url' => url('r/' . $shortUrl->short_code),
        ], 201);
    }

    /**
     * Get statistics for a user's shortened URLs.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function statistics()
    {
        $urls = $this->UrlService->getUserUrlsWithStatistics(auth()->id());

        return response()->json($urls);
    }
}