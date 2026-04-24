<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BlogApiController extends Controller
{
    private string $mainAppUrl;

    public function __construct()
    {
        $this->mainAppUrl = rtrim(config('api.main_app.api_base'), '/');
    }

    private function call(string $endpoint, array $params = []): array
    {
        try {
            $response = Http::withoutVerifying()
                ->timeout(30)
                ->get($this->mainAppUrl . $endpoint, $params);

            if ($response->failed()) {
                \Log::error('API call failed: ' . $endpoint, [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return ['data' => [], 'meta' => []];
            }

            return $response->json() ?? ['data' => []];
        } catch (\Exception $e) {
            \Log::error('API call exception: ' . $e->getMessage());
            return ['data' => [], 'meta' => []];
        }
    }

    // ── GET /api/v2/blogs ─────────────────────────────────────────────────────
    public function index(Request $request): JsonResponse
    {
        $params = $request->only(['page', 'per_page', 'category', 'tag', 'search', 'featured', 'sort']);
        
        // Map sort parameter
        if (isset($params['sort'])) {
            $params['sort'] = match($params['sort']) {
                'oldest' => 'oldest',
                'popular' => 'views',
                default => 'newest',
            };
        }
        
        $data = $this->call('/v1/blogs/public', $params);
        
        // Ensure consistent response structure
        return response()->json([
            'data' => $data['data'] ?? [],
            'meta' => $data['meta'] ?? [
                'current_page' => 1,
                'last_page' => 1,
                'per_page' => 12,
                'total' => 0,
                'from' => null,
                'to' => null,
            ]
        ]);
    }

    // ── GET /api/v2/blogs/featured ────────────────────────────────────────────
    public function featured(): JsonResponse
    {
        $data = $this->call('/v1/blogs/public', ['featured' => 1, 'per_page' => 6]);
        
        return response()->json([
            'data' => $data['data'] ?? []
        ]);
    }

    // ── GET /api/v2/blogs/categories ──────────────────────────────────────────
    public function categories(): JsonResponse
    {
        $data = $this->call('/v1/blogs/categories');
        
        return response()->json([
            'data' => $data['data'] ?? []
        ]);
    }

    // ── GET /api/v2/blogs/related/{slug} ─────────────────────────────────────
    public function related(string $slug): JsonResponse
    {
        $data = $this->call("/v1/blogs/related/{$slug}");
        
        return response()->json([
            'data' => $data['data'] ?? []
        ]);
    }

    // ── GET /api/v2/blogs/{slug} ──────────────────────────────────────────────
    public function show(string $slug): JsonResponse
    {
        \Log::info('Fetching blog with slug: ' . $slug);
        
        $data = $this->call("/v1/blogs/{$slug}");
        
        if (empty($data['data'])) {
            return response()->json(['data' => null, 'message' => 'Blog not found'], 404);
        }
        
        return response()->json(['data' => $data['data']]);
    }

    // ── Web View Routes ───────────────────────────────────────────────────────
    public function blogIndex()
    {
        return view('blogs.index');
    }
    
    public function blogShow(string $slug)
    {
        // Pass with_content=true to force content inclusion
        $data = $this->call("/v1/blogs/{$slug}?with_content=true");
        
        if (empty($data['data'])) {
            abort(404, 'Blog post not found');
        }
        
        $blog = $data['data'];
        
        // Increment view count asynchronously
        try {
            Http::withoutVerifying()
                ->timeout(5)
                ->post($this->mainAppUrl . "/v1/blogs/{$slug}/increment-view");
        } catch (\Exception $e) {
            // Don't fail the page
        }
        
        // Get related posts
        $related = $this->call("/v1/blogs/related/{$slug}");
        
        
        return view('blogs.show', [
            'blog' => $blog,
            'related' => $related['data'] ?? [],
        ]);
    }

    public function blogCategory(string $category)
    {
        // Fetch posts by category from main app API
        $data = $this->call('/v1/blogs/public', ['category' => $category, 'per_page' => 12]);
        
        $blogs = $data['data'] ?? [];
        $meta = $data['meta'] ?? [];
        
        return view('blogs.index', [
            'blogs' => $blogs,
            'meta' => $meta,
            'currentCategory' => $category,
        ]);
    }

    // ── GET /blog/tag/{tag} ──
    public function blogTag(string $tag)
    {
        // Fetch posts by tag from main app API
        $data = $this->call('/v1/blogs/public', ['tag' => $tag, 'per_page' => 12]);
        
        $blogs = $data['data'] ?? [];
        $meta = $data['meta'] ?? [];
        
        return view('blogs.index', [
            'blogs' => $blogs,
            'meta' => $meta,
            'currentTag' => $tag,
        ]);
    }

}