<?php

namespace App\Http\Controllers;

use App\Services\UrlService;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    protected $UrlService;

    /**
     * Inject UrlService through the constructor.
     *
     * @param UrlService $urlShortenerService
     */
    public function __construct(UrlService $UrlService)
    {
        //$this->middleware('auth');
        $this->UrlService = $UrlService;
    }

    /**
     * Display the user's URL statistics.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch URLs with statistics for the authenticated user
        $urls = $this->UrlService->getUserUrlsWithStatistics(auth()->id());

        // Return the view with URLs
        return view('statistics', compact('urls'));
    }
}