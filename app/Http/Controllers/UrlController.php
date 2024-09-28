<?php

namespace App\Http\Controllers;

use App\Services\UrlService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UrlController extends Controller
{
    protected $urlService;

    public function __construct(UrlService $urlService)
    {
        $this->urlService = $urlService;
    }

    // Show URL shortening form
    public function index()
    {
        return view('home');
    }

    // Create a new short URL
    public function store(Request $request)
    {
        $request->validate([
            'original_url' => 'required|url|max:255'
        ]);

        $shortUrl = $this->urlService->createShortUrl($request->input('original_url'), Auth::id());

        return redirect()->back()->with('success', "Short URL: " . url('/') . '/' . $shortUrl->short_code);
    }

    // Redirect the short URL
    public function redirect($shortCode)
    {
        $longUrl = $this->urlService->handleRedirect($shortCode);

        if ($longUrl) {
            return redirect($longUrl);
        }

        abort(404, 'URL Not Found');
    }

    // Show statistics for the authenticated user
    public function statistics()
    {
        $urls = $this->urlService->getUserUrls(Auth::id());
        return view('statistics', compact('urls'));
    }
}