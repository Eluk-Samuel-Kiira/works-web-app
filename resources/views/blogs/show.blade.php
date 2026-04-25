@extends('layouts.jobs')

@php
    $blog          = $data['data'] ?? $blog ?? [];
    $author        = $blog['author'] ?? [];
    $authorAvatar  = $author['avatar'] ?? asset('user-2.jpg');
    $readingTime   = $blog['reading_time'] ?? '5 min read';
    $publishedDate = isset($blog['published_at']) ? \Carbon\Carbon::parse($blog['published_at']) : now();
    $canonical     = url('/blog/' . ($blog['slug'] ?? ''));
    $metaDesc      = Str::limit(strip_tags($blog['excerpt'] ?? $blog['content'] ?? ''), 160);
    $ogImage       = $blog['cover_image'] ?? asset('blog-img1.jpg');
    
    if ($ogImage && !filter_var($ogImage, FILTER_VALIDATE_URL)) {
        $ogImage = asset($ogImage);
    }

    $schemaData = [
        '@context'         => 'https://schema.org',
        '@type'            => 'BlogPosting',
        'headline'         => $blog['title'] ?? 'Blog Post',
        'description'      => $metaDesc,
        'image'            => $ogImage,
        'datePublished'    => $publishedDate->toIso8601String(),
        'dateModified'     => isset($blog['updated_at'])
                             ? \Carbon\Carbon::parse($blog['updated_at'])->toIso8601String()
                             : $publishedDate->toIso8601String(),
        'author'           => ['@type' => 'Person', 'name' => $author['name'] ?? 'Stardena Works'],
        'publisher'        => ['@type' => 'Organization', 'name' => 'Stardena Works',
                               'logo'  => ['@type' => 'ImageObject', 'url' => asset('logo.png')]],
        'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => $canonical],
    ];

    $shareBtns = [
        ['id' => 'whatsapp', 'tip' => 'WhatsApp', 'color' => '#25D366',
        'svg' => '<path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.126.554 4.118 1.527 5.845L.057 23.493a.5.5 0 0 0 .613.612l5.701-1.463A11.94 11.94 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 0 1-5.021-1.377l-.36-.214-3.733.957.986-3.643-.234-.374A9.818 9.818 0 1 1 12 21.818z"/>'],
        ['id' => 'facebook', 'tip' => 'Facebook', 'color' => '#1877F2',
        'svg' => '<path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>'],
        ['id' => 'twitter', 'tip' => 'X (Twitter)', 'color' => '#000000',
        'svg' => '<path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.737-8.835L1.254 2.25H8.08l4.253 5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>'],
        ['id' => 'linkedin', 'tip' => 'LinkedIn', 'color' => '#0A66C2',
        'svg' => '<path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>'],
        ['id' => 'telegram', 'tip' => 'Telegram', 'color' => '#229ED9',
        'svg' => '<path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.96 6.504-1.356 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>'],
    ];
@endphp

{{-- Single-line sections need NO @endsection --}}
@section('title',            ($blog['title'] ?? 'Blog Post') . ' | Stardena Works Blog')
@section('meta_description', $metaDesc)
@section('canonical',        $canonical)
@section('robots',           'index, follow')
@section('og_type',          'article')
@section('og_title',         $blog['title'] ?? 'Blog Post')
@section('og_description',   $metaDesc)
@section('og_image',         $ogImage)

{{-- Block section: @endsection REQUIRED --}}
@section('schema')
<script type="application/ld+json">@json($schemaData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)</script>
@endsection

{{-- Block section: @endsection REQUIRED --}}
@section('job-content')

<div class="main-wrapper" style="overflow: visible;">

  {{-- ── Breadcrumb ─────────────────────────────────────────────────── --}}
  <div class="py-2 bg-body-tertiary border-bottom">
    <div class="container-xl px-3 px-md-4">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 small flex-nowrap overflow-x-auto breadcrumb-no-scroll">
          <li class="breadcrumb-item flex-shrink-0"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item flex-shrink-0"><a href="{{ route('blog.index') }}">Blog</a></li>
          @if(isset($blog['category']))
            <li class="breadcrumb-item flex-shrink-0">
              <a href="{{ route('blog.category', $blog['category']) }}">{{ ucfirst($blog['category']) }}</a>
            </li>
          @endif
          <li class="breadcrumb-item active flex-shrink-0" aria-current="page">
            {{ Str::limit($blog['title'] ?? 'Blog Post', 50) }}
          </li>
        </ol>
      </nav>
    </div>
  </div>

  {{-- ── AD SLOT 1 — Top Leaderboard ──────────────────────────────── --}}
  <div class="bg-body border-bottom py-1 text-center">
    <div class="container-xl">
      <p class="text-uppercase text-muted mb-1" style="font-size:9px;letter-spacing:.08em">Advertisement</p>
      <ins class="adsbygoogle" style="display:block"
           data-ad-client="ca-pub-3587587638253109" data-ad-slot="1832373916"
           data-ad-format="auto" data-full-width-responsive="true"></ins>
      <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
    </div>
  </div>

  {{-- ── Two-column layout ──────────────────────────────────────────── --}}
  <div class="container-xl px-3 px-md-4 py-4 py-lg-5" style="overflow: visible;">
    <div class="row g-4 align-items-start">

      {{-- ══════════ LEFT COLUMN ══════════ --}}
      <div class="col-12 col-lg-8" style="min-height: 1px;">

        {{-- Blog Article Card --}}
        <article class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">

          {{-- Cover Image --}}
          @if(!empty($blog['cover_image']))
            <div style="max-height:420px;overflow:hidden;">
              <img src="{{ blogImage($blog['cover_image'], 'cover') ?? asset('blog-img1.jpg') }}"
                class="w-100"
                alt="{{ $blog['cover_image_alt'] ?? $blog['title'] ?? 'Blog cover' }}"
                style="max-height: 450px; object-fit: cover;"
                onerror="this.src=DEFAULT_BLOG_IMG">
              @if(!empty($blog['cover_image_caption']))
                <figcaption class="text-muted small p-2 bg-white bg-opacity-75 position-absolute bottom-0 end-0 m-2 rounded">
                  {{ $blog['cover_image_caption'] }}
                </figcaption>
              @endif
            </div>
          @endif

          <div class="card-body p-3 p-md-5">

            {{-- Category badge --}}
            <div class="mb-3">
              <a href="{{ route('blog.category', $blog['category'] ?? 'general') }}"
                 class="badge bg-primary bg-opacity-10 text-primary text-decoration-none fw-normal px-3 py-2"
                 style="font-size:12px">
                <i class="bi bi-tag me-1"></i>{{ ucfirst($blog['category'] ?? 'General') }}
              </a>
            </div>

            {{-- Title --}}
            <h1 class="fw-bold mb-3" style="font-size:clamp(1.6rem,4vw,2.4rem);line-height:1.25;">
              {{ $blog['title'] ?? 'Blog Post' }}
            </h1>

            {{-- Author meta --}}
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4 pb-3 border-bottom">
              <div class="d-flex align-items-center gap-3">
                @if(!empty($author['avatar']))
                  <img src="{{ $author['avatar'] }}" class="rounded-circle border"
                       width="46" height="46" style="object-fit:cover;" loading="lazy"
                       onerror="this.src='{{ asset('default-avatar.png') }}'">
                @else
                  <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center border"
                       style="width:46px;height:46px">
                    <i class="bi bi-person fs-5 text-primary"></i>
                  </div>
                @endif
                <div>
                  <div class="fw-semibold small">{{ $author['name'] ?? 'Stardena Works' }}</div>
                  <div class="text-muted d-flex flex-wrap gap-2 align-items-center" style="font-size:12px">
                    @if(!empty($author['title']))
                      <span>{{ $author['title'] }}</span><span>·</span>
                    @endif
                    <span><i class="bi bi-calendar3 me-1"></i>{{ $publishedDate->format('M j, Y') }}</span>
                    <span>·</span>
                    <span><i class="bi bi-clock me-1"></i>{{ $readingTime }}</span>
                  </div>
                </div>
              </div>

              {{-- Share buttons --}}
              <div class="d-flex align-items-center gap-1 flex-wrap">
                <span class="text-muted me-1 d-none d-sm-inline" style="font-size:12px">Share:</span>
                @foreach(array_slice($shareBtns, 0, 4) as $s)
                  <button type="button"
                          class="btn btn-light border share-btn d-inline-flex align-items-center justify-content-center p-0"
                          style="width:34px;height:34px;border-radius:8px;"
                          onclick="shareOn('{{ $s['id'] }}')" title="{{ $s['tip'] }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="{{ $s['color'] }}">{!! $s['svg'] !!}</svg>
                  </button>
                @endforeach
                <button type="button"
                        class="btn btn-light border share-btn d-inline-flex align-items-center justify-content-center p-0"
                        style="width:34px;height:34px;border-radius:8px;"
                        onclick="copyBlogLink()" title="Copy link">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                  </svg>
                </button>
              </div>
            </div>

            {{-- Excerpt callout --}}
            @if(!empty($blog['excerpt']))
              <div class="rounded-3 p-4 mb-4"
                   style="background:rgba(var(--bs-primary-rgb),.05);border-left:4px solid var(--bs-primary);">
                <p class="mb-0 fst-italic text-body-secondary" style="font-size:.9375rem;line-height:1.7">
                  {{ $blog['excerpt'] }}
                </p>
              </div>
            @endif

            {{-- Main blog body --}}
            <div class="blog-content">
              {!! $blog['content'] ?? '<p>No content available.</p>' !!}
            </div>

            {{-- Tags --}}
            @if(!empty($blog['tags']) && count($blog['tags']) > 0)
              <div class="mt-4 pt-3 border-top">
                <div class="d-flex flex-wrap align-items-center gap-2">
                  <span class="text-muted small fw-medium">Tags:</span>
                  @foreach($blog['tags'] as $tag)
                    <a href="{{ route('blog.tag', $tag) }}"
                       class="badge rounded-pill text-decoration-none fw-normal px-3 py-2"
                       style="background:rgba(var(--bs-primary-rgb),.08);color:var(--bs-primary);font-size:11px">
                      #{{ $tag }}
                    </a>
                  @endforeach
                </div>
              </div>
            @endif

          </div>
        </article>

        {{-- ── AD SLOT 2 — In-content ─────────────────────────────────── --}}
        <div class="mb-4 text-center">
          <p class="text-uppercase text-muted mb-1" style="font-size:9px;letter-spacing:.08em">Advertisement</p>
          <ins class="adsbygoogle" style="display:block"
               data-ad-client="ca-pub-3587587638253109" data-ad-slot="5328765795"
               data-ad-format="auto" data-full-width-responsive="true"></ins>
          <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
        </div>

        {{-- Author bio --}}
        @if(!empty($author['name']) || !empty($author['title']))
          <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
              <div class="d-flex flex-column flex-sm-row gap-4 align-items-center align-items-sm-start">
                @if(!empty($author['avatar']))
                  <img src="{{ $author['avatar'] }}"
                       class="rounded-circle border flex-shrink-0" width="72" height="72"
                       style="object-fit:cover;"
                       onerror="this.src='{{ asset('default-avatar.png') }}'">
                @else
                  <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0 border"
                       style="width:72px;height:72px">
                    <i class="bi bi-person fs-2 text-primary"></i>
                  </div>
                @endif
                <div class="text-center text-sm-start">
                  <p class="text-uppercase text-muted mb-1" style="font-size:10px;letter-spacing:.08em">About the Author</p>
                  <h3 class="h6 fw-bold mb-1">{{ $author['name'] ?? 'Stardena Works' }}</h3>
                  @if(!empty($author['title']))
                    <p class="text-primary small mb-2">{{ $author['title'] }}</p>
                  @endif
                  <p class="text-body-secondary small mb-0">
                    Sharing insights on careers, job searching, and professional development in Uganda.
                  </p>
                </div>
              </div>
            </div>
          </div>
        @endif

        {{-- Related posts --}}
        @if(!empty($related) && count($related) > 0)
          <div class="mb-4">
            <h2 class="h5 fw-bold mb-3">Related Articles</h2>
            <div class="row g-3">
              @foreach(array_slice($related, 0, 3) as $rel)
                <div class="col-12 col-sm-6 col-md-4">
                  <a href="{{ route('blog.show', $rel['slug'] ?? '#') }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm rounded-3 h-100 related-card">
                      @if(!empty($rel['cover_image']))
                        <img src="{{ $rel['cover_image'] ?? asset('blog-img1.jpg') }}"
                            class="rounded-3 flex-shrink-0"
                            width="60" height="60"
                            style="object-fit: cover;"
                            onerror="this.src=DEFAULT_BLOG_IMG">
                      @endif
                      <div class="card-body p-3">
                        <span class="badge bg-primary bg-opacity-10 text-primary fw-normal mb-2" style="font-size:10px">
                          {{ ucfirst($rel['category'] ?? 'General') }}
                        </span>
                        <p class="small fw-semibold text-body mb-0" style="line-height:1.4">
                          {{ Str::limit($rel['title'] ?? '', 60) }}
                        </p>
                      </div>
                    </div>
                  </a>
                </div>
              @endforeach
            </div>
          </div>
        @endif

      </div>
      {{-- END LEFT COLUMN --}}

      {{-- RIGHT SIDEBAR --}}
      <div class="col-12 col-lg-4">
        <div class="blog-sidebar-sticky">
          {{-- Author Card --}}
          <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
            <div class="card-body p-4 text-center">
              <img src="{{ $authorAvatar }}"
                class="rounded-circle mb-3 border border-3 border-primary"
                width="80" height="80"
                style="object-fit: cover;"
                onerror="this.src=DEFAULT_AVATAR">
              <h3 class="h6 fw-bold mb-1">{{ $author['name'] ?? 'Stardena Works' }}</h3>
              @if(!empty($author['title']))
              <p class="text-primary small mb-2">{{ $author['title'] }}</p>
              @endif
              <p class="text-muted small mb-3">
                Sharing insights on careers, job searching, and professional development in Uganda.
              </p>
              <button class="btn btn-outline-primary btn-sm w-100" onclick="toggleFollow()">
                <i class="bi bi-person-plus me-1"></i>Follow Author
              </button>
            </div>
          </div>

          {{-- Stats Card --}}
          <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
              <div class="row text-center g-0">
                <div class="col-4 border-end">
                  <div class="fw-bold text-primary" style="font-size: 1.5rem;">
                    {{ number_format($blog['view_count'] ?? 0) }}
                  </div>
                  <div class="text-muted small">Views</div>
                </div>
                <div class="col-4 border-end">
                  <div class="fw-bold text-primary" style="font-size: 1.5rem;">
                    {{ number_format($blog['share_count'] ?? 0) }}
                  </div>
                  <div class="text-muted small">Shares</div>
                </div>
                <div class="col-4">
                  <div class="fw-bold text-primary" style="font-size: 1.5rem;">
                    {{ is_numeric($readingTime) ? $readingTime : preg_replace('/[^0-9]/', '', $readingTime) }}
                  </div>
                  <div class="text-muted small">Min Read</div>
                </div>
              </div>
            </div>
          </div>

          {{-- Table of Contents --}}
          <div class="card border-0 shadow-sm rounded-4 mb-4 d-none d-lg-block" id="tocCard">
            <div class="card-body p-4">
              <h3 class="h6 fw-bold mb-3 d-flex align-items-center gap-2">
                <i class="bi bi-list-ul text-primary"></i>Table of Contents
              </h3>
              <nav id="tableOfContents" class="small">
                <ul class="list-unstyled mb-0">
                  <li class="text-muted">Loading...</li>
                </ul>
              </nav>
            </div>
          </div>

          {{-- Newsletter Widget --}}
          <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 bg-primary">
            <div class="card-body p-4 text-center text-white">
              <div class="mb-3">
                <i class="bi bi-envelope fs-1 text-white-50"></i>
              </div>
              <p class="text-white-50 small text-uppercase mb-2" style="letter-spacing:.1em">Never miss an update</p>
              <form id="sidebarNewsletter">
                <div class="d-flex flex-column gap-2">
                  <input type="email" 
                        class="form-control form-control-sm w-100"
                        placeholder="Your email address" 
                        required>
                  <button type="submit" class="btn btn-light btn-sm fw-semibold rounded-pill w-100">
                    Subscribe
                  </button>
                </div>
              </form>
              <small class="d-block mt-2 text-white-50 small">No spam, unsubscribe anytime.</small>
            </div>
          </div>

          {{-- Related Posts --}}
          @if(!empty($related) && count($related) > 0)
          <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
              <h3 class="h6 fw-bold mb-3 d-flex align-items-center gap-2">
                <i class="bi bi-newspaper text-primary"></i>You might also like
              </h3>
              <div class="d-flex flex-column gap-3">
                @foreach(array_slice($related, 0, 4) as $rel)
                <a href="{{ route('blog.show', $rel['slug'] ?? '#') }}"
                  class="text-decoration-none d-flex gap-3 align-items-start">
                  @if(!empty($rel['cover_image']))
                  <img src="{{ $rel['cover_image'] }}"
                      class="rounded-3 flex-shrink-0"
                      width="60" height="60"
                      style="object-fit: cover;"
                      onerror="this.src='{{ asset('default-blog-image.jpg') }}'">
                  @else
                  <div class="rounded-3 bg-light flex-shrink-0 d-flex align-items-center justify-content-center"
                      style="width: 60px; height: 60px;">
                    <i class="bi bi-newspaper text-secondary fs-4"></i>
                  </div>
                  @endif
                  <div>
                    <div class="fw-semibold text-body small mb-1" style="line-height: 1.4;">
                      {{ Str::limit($rel['title'] ?? '', 60) }}
                    </div>
                    <div class="text-muted" style="font-size: 11px;">
                      <i class="bi bi-clock me-1"></i>{{ isset($rel['published_at']) ? \Carbon\Carbon::parse($rel['published_at'])->diffForHumans() : 'Recently' }}
                    </div>
                  </div>
                </a>
                @endforeach
              </div>
            </div>
          </div>
          @endif

        </div>
      </div>

    </div>
  </div>

  {{-- ── AD SLOT 4 — Pre-CTA ────────────────────────────────────────── --}}
  <div class="bg-body border-top border-bottom py-2 text-center">
    <div class="container-xl">
      <p class="text-uppercase text-muted mb-1" style="font-size:9px;letter-spacing:.08em">Advertisement</p>
      <ins class="adsbygoogle" style="display:block"
           data-ad-client="ca-pub-3587587638253109" data-ad-slot="5963190616"
           data-ad-format="auto" data-full-width-responsive="true"></ins>
      <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
    </div>
  </div>

  {{-- ── CTA ──────────────────────────────────────────────────────────── --}}
  <section class="py-5" style="background:linear-gradient(135deg,var(--bs-primary) 0%,#1565c0 100%);">
    <div class="container-xl px-3 px-md-4 text-center">
      <h2 class="text-white fw-bold mb-2" style="font-size:clamp(1.3rem,3vw,1.75rem)">
        Ready to advance your career?
      </h2>
      <p class="text-white-50 mb-4" style="font-size:.9375rem">
        Explore more career advice and job opportunities on Stardena Works.
      </p>
      <div class="d-flex flex-wrap align-items-center justify-content-center gap-3">
        <a href="{{ route('blog.index') }}" class="btn btn-light fw-semibold px-4">
          <i class="bi bi-newspaper me-2"></i>More Articles
        </a>
        <a href="{{ route('jobs.index') }}" class="btn btn-outline-light fw-semibold px-4">
          <i class="bi bi-briefcase me-2"></i>Find Jobs
        </a>
      </div>
    </div>
  </section>

  {{-- ── AD SLOT 5 — Footer ──────────────────────────────────────────── --}}
  <div class="bg-body border-top py-2 text-center">
    <div class="container-xl">
      <p class="text-uppercase text-muted mb-1" style="font-size:9px;letter-spacing:.08em">Advertisement</p>
      <ins class="adsbygoogle" style="display:block"
           data-ad-client="ca-pub-3587587638253109" data-ad-slot="9710863933"
           data-ad-format="auto" data-full-width-responsive="true"></ins>
      <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
    </div>
  </div>

</div>{{-- /.main-wrapper --}}

<script>
  const shareData = {
    id:      @json($blog['id'] ?? null),
    title:   @json($blog['title'] ?? 'Blog Post'),
    excerpt: @json(Str::limit(strip_tags($blog['excerpt'] ?? $blog['content'] ?? ''), 150)),
    url:     window.location.href,
  };

  const buildMsg = () => `${shareData.title}\n\nRead more: ${shareData.url}`;

  async function incrementShareCount(platform) {
    if (!shareData.id) return;
    try {
      await fetch(`/api/v2/blogs/${shareData.id}/increment-share`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({ platform }),
      });
    } catch (e) {}
  }

  function shareOn(platform) {
    incrementShareCount(platform);
    const t   = encodeURIComponent(`${shareData.title}\n\n${shareData.excerpt}...`);
    const msg = encodeURIComponent(buildMsg());
    const u   = encodeURIComponent(shareData.url);
    const map = {
      whatsapp: `https://wa.me/?text=${msg}`,
      facebook: `https://www.facebook.com/sharer/sharer.php?u=${u}`,
      twitter:  `https://twitter.com/intent/tweet?text=${t}&url=${u}`,
      linkedin: `https://www.linkedin.com/sharing/share-offsite/?url=${u}`,
      telegram: `https://t.me/share/url?url=${u}&text=${t}`,
    };
    if (map[platform]) window.open(map[platform], '_blank', 'width=600,height=500,noopener,noreferrer');
  }

  function copyBlogLink() {
    incrementShareCount('copy_link');
    const text = buildMsg();
    navigator.clipboard.writeText(text).catch(() => {
      const ta = document.createElement('textarea');
      ta.value = text;
      document.body.appendChild(ta);
      ta.select();
      document.execCommand('copy');
      document.body.removeChild(ta);
    });
    if (typeof showToast === 'function') showToast('Link copied!', 'success');
  }

  function generateTableOfContents() {
    const content = document.querySelector('.blog-content');
    if (!content) return;
    const headings = content.querySelectorAll('h2, h3');
    if (!headings.length) {
      document.getElementById('tocCard')?.classList.add('d-none');
      return;
    }
    const tocNav = document.getElementById('tableOfContents');
    const ul = document.createElement('ul');
    ul.className = 'list-unstyled mb-0';
    headings.forEach(function(h, i) {
      h.id = 'heading-' + i;
      var li = document.createElement('li');
      li.className = h.tagName === 'H3' ? 'ms-3 mt-1' : 'mt-2';
      var a = document.createElement('a');
      a.href = '#heading-' + i;
      a.textContent = h.textContent;
      a.className = 'text-decoration-none text-body-secondary toc-link';
      a.addEventListener('click', function(e) {
        e.preventDefault();
        h.scrollIntoView({ behavior: 'smooth', block: 'start' });
      });
      li.appendChild(a);
      ul.appendChild(li);
    });
    tocNav.innerHTML = '';
    tocNav.appendChild(ul);
  }

  document.getElementById('sidebarNewsletter')?.addEventListener('submit', function(e) {
    e.preventDefault();
    var btn  = e.target.querySelector('button');
    var orig = btn.textContent;
    btn.disabled = true;
    btn.textContent = 'Subscribing\u2026';
    setTimeout(function() {
      if (typeof showToast === 'function') showToast('Subscribed successfully!', 'success');
      e.target.reset();
      btn.disabled = false;
      btn.textContent = orig;
    }, 900);
  });

  document.addEventListener('DOMContentLoaded', generateTableOfContents);
</script>

@endsection



@push('styles')
<style>
.container-xl { max-width: 1280px; }

.breadcrumb-no-scroll {
  scrollbar-width: none;
  -ms-overflow-style: none;
  white-space: nowrap;
}
.breadcrumb-no-scroll::-webkit-scrollbar { display: none; }

/* Sticky sidebar for desktop */
@media (min-width: 992px) {
  .blog-sidebar-sticky {
    position: sticky;
    top: 90px;
    transition: top 0.3s ease;
  }
}

.share-btn { transition: transform .15s ease, box-shadow .15s ease; }
.share-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,.12); }

.blog-content {
  font-size: 1rem;
  line-height: 1.85;
  color: #2c3e50;
  word-wrap: break-word;
  overflow-wrap: break-word;
}
.blog-content h2 {
  font-size: 1.45rem; font-weight: 700;
  margin-top: 2rem; margin-bottom: .875rem;
  padding-bottom: .5rem; border-bottom: 2px solid #e9ecef; color: #1a1a2e;
}
.blog-content h3 {
  font-size: 1.2rem; font-weight: 600;
  margin-top: 1.5rem; margin-bottom: .75rem; color: #1a1a2e;
}
.blog-content p  { margin-bottom: 1.1rem; }
.blog-content ul,
.blog-content ol { padding-left: 1.5rem; margin-bottom: 1rem; }
.blog-content li { margin-bottom: .35rem; }
.blog-content img {
  max-width: 100%; height: auto;
  border-radius: 12px; margin: 1.25rem 0;
  box-shadow: 0 4px 16px rgba(0,0,0,.08);
}
.blog-content blockquote {
  border-left: 4px solid var(--bs-primary);
  background: rgba(var(--bs-primary-rgb),.05);
  padding: 1rem 1.5rem; margin: 1.25rem 0;
  font-style: italic; border-radius: 0 8px 8px 0; color: #495057;
}
.blog-content a { color: var(--bs-primary); text-decoration: underline; }
.blog-content a:hover { text-decoration: none; }
.blog-content pre {
  background: #1e1e2e; color: #cdd6f4;
  padding: 1.25rem; border-radius: 10px;
  overflow-x: auto; font-size: .875rem; margin: 1.25rem 0;
}
.blog-content code {
  background: rgba(var(--bs-primary-rgb),.08);
  padding: .15em .4em; border-radius: 4px;
  font-size: .875em; color: var(--bs-primary);
}
.blog-content pre code { background: transparent; color: inherit; padding: 0; }

.toc-link { font-size: 13px; display: block; padding: 2px 0; }
.toc-link:hover { color: var(--bs-primary) !important; }

.related-card { transition: transform .15s ease, box-shadow .15s ease; }
.related-card:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(0,0,0,.1) !important; }

@media (max-width: 767.98px) {
  .blog-content    { font-size: .9375rem; }
  .blog-content h2 { font-size: 1.2rem; }
  .blog-content h3 { font-size: 1.05rem; }
}

  @media (min-width: 992px) {
    .blog-sidebar-sticky {
      position: sticky;
      top: 80px; /* Adjust to match your fixed header height */
      z-index: 100;
      max-height: calc(100vh - 100px);
      overflow-y: auto;
      padding-bottom: 2rem;
    }
    /* Hide scrollbar but keep functionality */
    .blog-sidebar-sticky::-webkit-scrollbar {
      width: 4px;
    }
    .blog-sidebar-sticky::-webkit-scrollbar-thumb {
      background: rgba(0,0,0,.2);
      border-radius: 4px;
    }
  }
</style>
@endpush