<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class MarketingController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Welcome', [
            'publishedCount' => \App\Models\WeddingInvitation::published()->count(),
        ]);
    }
}
