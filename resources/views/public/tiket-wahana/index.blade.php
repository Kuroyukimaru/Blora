@extends('public.layouts.app')

@section('title', 'Tiket Wahana')

@section('content')

@php
    $searchValue = request()->query('search', '');
    $searchValue = is_string($searchValue) ? trim($searchValue) : '';

    $sortValue = request()->query('sort', 'price_asc');
    $allowedSortValues = ['price_asc', 'price_desc'];
    $sortValue = is_string($sortValue) && in_array($sortValue, $allowedSortValues, true)
        ? $sortValue
        : 'price_asc';

    $resolveWahanaImage = static function ($wahana): string {
        $fallback = asset('images/no-image.png');
        $rawPath = $wahana->gambar ?? null;
        $storedUrl = $wahana->gambar_url ?? null;

        if (is_string($rawPath) && trim($rawPath) !== '') {
            $path = trim(str_replace('\\', '/', $rawPath));

            if (filter_var($path, FILTER_VALIDATE_URL)) {
                return $path;
            }

            $path = ltrim($path, '/');

            if (str_starts_with($path, 'storage/')) {
                $path = substr($path, strlen('storage/'));
            }

            if (str_starts_with($path, 'public/')) {
                $path = substr($path, strlen('public/'));
            }

            $path = ltrim($path, '/');

            if ($path !== '') {
                if (file_exists(public_path('storage/' . $path))) {
                    return asset('storage/' . $path);
                }

                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
                    return asset('storage/' . $path);
                }

                if (file_exists(public_path($path))) {
                    return asset($path);
                }
            }
        }

        if (is_string($storedUrl) && trim($storedUrl) !== '') {
            $candidate = trim($storedUrl);

            if (filter_var($candidate, FILTER_VALIDATE_URL)) {
                $parsedPath = parse_url($candidate, PHP_URL_PATH);

                if (is_string($parsedPath) && str_contains($parsedPath, '/storage/')) {
                    $relativePath = substr(
                        $parsedPath,
                        strpos($parsedPath, '/storage/') + strlen('/storage/')
                    );

                    if ($relativePath !== '') {
                        return asset('storage/' . ltrim($relativePath, '/'));
                    }
                }

                return $candidate;
            }

            $candidate = ltrim(str_replace('\\', '/', $candidate), '/');

            if (str_starts_with($candidate, 'storage/')) {
                $candidate = substr($candidate, strlen('storage/'));
            }

            if (str_starts_with($candidate, 'public/')) {
                $candidate = substr($candidate, strlen('public/'));
            }

            if ($candidate !== '') {
                if (file_exists(public_path('storage/' . $candidate))) {
                    return asset('storage/' . $candidate);
                }

                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($candidate)) {
                    return asset('storage/' . $candidate);
                }

                if (file_exists(public_path($candidate))) {
                    return asset($candidate);
                }
            }
        }

        return $fallback;
    };
@endphp

<style>
    /* ============================================================
       NOYO GIMBAL — TIKET WAHANA
       STYLE DISELARASKAN DENGAN HALAMAN MENU
       ============================================================ */

    .ng-wahana-page {
        --bg-primary: #0a0a0a;
        --bg-secondary: #151515;
        --bg-soft: #1a1a1a;
        --bg-card: #121212;

        --text-primary: #f8f4ed;
        --text-secondary: #d4c9b5;
        --text-muted: #a89988;
        --text-dim: #7a6f62;

        --accent: #e2c997;
        --accent-hover: #d4b384;
        --accent-dark: #b89a6e;

        --border-soft: rgba(255,255,255,.06);
        --border-gold: rgba(226,201,151,.15);
        --border-gold-strong: rgba(226,201,151,.30);

        --shadow-soft: 0 20px 60px rgba(0,0,0,.40);
        --shadow-hover: 0 25px 70px rgba(0,0,0,.50);
        --transition: .25s cubic-bezier(.4,0,.2,1);

        color: var(--text-primary);
        background: var(--bg-primary);
    }

    .ng-wahana-container {
        width: min(1180px, calc(100% - 48px));
        margin: 0 auto;
    }

    /* ============================================================
       HERO — SAMA DENGAN MENU
       ============================================================ */

    .ng-wahana-hero {
        position: relative;
        overflow: hidden;
        background:
            radial-gradient(
                circle at 15% 25%,
                rgba(226,201,151,.055),
                transparent 32%
            );
    }

    .ng-wahana-hero::after {
        content: "";
        position: absolute;
        width: 500px;
        height: 500px;
        top: -300px;
        right: -180px;
        border-radius: 50%;
        background: rgba(226,201,151,.025);
        filter: blur(20px);
        pointer-events: none;
    }

    .ng-wahana-hero-inner {
        padding: 64px 0 70px;
    }

    .ng-wahana-breadcrumb {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 28px;
        font-size: 12px;
    }

    .ng-wahana-breadcrumb a {
        color: var(--text-muted);
        text-decoration: none;
        transition: color var(--transition);
    }

    .ng-wahana-breadcrumb a:hover {
        color: var(--accent);
    }

    .ng-wahana-breadcrumb-separator {
        color: var(--text-dim);
    }

    .ng-wahana-breadcrumb-current {
        color: var(--text-secondary);
    }

    .ng-wahana-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
        padding: 7px 13px;
        border: 1px solid var(--border-gold);
        border-radius: 999px;
        background: rgba(226,201,151,.055);
        color: var(--accent);
        font-size: 10px;
        font-weight: 600;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .ng-wahana-eyebrow::before {
        content: "";
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: var(--accent);
        box-shadow: 0 0 10px rgba(226,201,151,.5);
    }

    .ng-wahana-heading {
        max-width: 760px;
    }

    .ng-wahana-hero-title {
        margin: 0;
        color: var(--text-primary);
        font-family: 'Playfair Display', Georgia, serif;
        font-size: clamp(42px, 6vw, 72px);
        line-height: 1.04;
        font-weight: 700;
        letter-spacing: -.035em;
    }

    .ng-wahana-hero-title span {
        display: block;
        color: var(--accent);
        font-style: italic;
    }

    .ng-wahana-hero-description {
        max-width: 650px;
        margin-top: 22px;
        color: var(--text-muted);
        font-size: 15px;
        line-height: 1.9;
    }

    /* ============================================================
       FILTER — SAMA DENGAN MENU
       ============================================================ */

    .ng-wahana-filter-section {
        padding: 0 0 28px;
    }

    .ng-wahana-filter-box {
        padding: 18px;
        border: 1px solid var(--border-gold);
        border-radius: 20px;
        background: rgba(255,255,255,.025);
        box-shadow: var(--shadow-soft);
    }

    .ng-wahana-filter-form {
        display: grid;
        grid-template-columns:
            minmax(0, 1.7fr)
            minmax(180px, 1fr);
        gap: 12px;
        align-items: end;
    }

    .ng-wahana-filter-field {
        min-width: 0;
    }

    .ng-wahana-filter-label {
        display: block;
        margin-bottom: 7px;
        color: var(--text-secondary);
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .02em;
    }

    .ng-wahana-search {
        position: relative;
    }

    .ng-wahana-input {
        width: 100%;
        min-height: 48px;
        box-sizing: border-box;
        padding: 0 15px;
        border: 1px solid var(--border-soft);
        border-radius: 12px;
        outline: none;
        background: rgba(255,255,255,.035);
        color: var(--text-primary);
        font-family: inherit;
        font-size: 13px;
        transition:
            border-color var(--transition),
            background var(--transition),
            box-shadow var(--transition);
    }

    .ng-wahana-input::placeholder {
        color: var(--text-dim);
    }

    .ng-wahana-input:hover {
        background: rgba(226,201,151,.045);
        border-color: var(--border-gold);
    }

    .ng-wahana-input:focus {
        background: rgba(226,201,151,.055);
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(226,201,151,.07);
    }

    .ng-wahana-input option {
        background: var(--bg-card);
        color: var(--text-primary);
    }

    .ng-wahana-search-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        width: 18px;
        height: 18px;
        transform: translateY(-50%);
        color: var(--text-dim);
        pointer-events: none;
    }

    .ng-wahana-input-search {
        padding-left: 44px;
        padding-right: 42px;
    }

    .ng-wahana-clear-search {
        position: absolute;
        top: 50%;
        right: 10px;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        transform: translateY(-50%);
        border: 0;
        border-radius: 50%;
        background: transparent;
        color: var(--text-dim);
        opacity: 0;
        visibility: hidden;
        cursor: pointer;
        transition: color .2s ease, background .2s ease, opacity .2s ease;
    }

    .ng-wahana-clear-search.is-visible {
        opacity: 1;
        visibility: visible;
    }

    .ng-wahana-clear-search:hover {
        background: rgba(226,201,151,.08);
        color: var(--accent);
    }

    .ng-wahana-clear-search svg {
        width: 15px;
        height: 15px;
    }

    .ng-wahana-select-wrapper {
        position: relative;
    }

    .ng-wahana-select-wrapper::after {
        content: "";
        position: absolute;
        top: 50%;
        right: 15px;
        width: 7px;
        height: 7px;
        border-right: 1.5px solid var(--accent);
        border-bottom: 1.5px solid var(--accent);
        transform: translateY(-65%) rotate(45deg);
        pointer-events: none;
    }

    .ng-wahana-select-wrapper select {
        appearance: none;
        -webkit-appearance: none;
        padding-right: 40px;
        cursor: pointer;
    }

    /* ============================================================
       RESULT — SAMA DENGAN MENU
       ============================================================ */

    .ng-wahana-result-section {
        padding: 20px 0 25px;
    }

    .ng-wahana-result-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
    }

    .ng-wahana-result-text {
        margin: 0;
        color: var(--text-muted);
        font-size: 13px;
    }

    .ng-wahana-result-count {
        margin: 0 4px;
        color: var(--accent);
        font-weight: 700;
    }

    /* ============================================================
       GRID — SAMA DENGAN MENU
       ============================================================ */

    .ng-wahana-list-section {
        padding: 0 0 110px;
    }

    .ng-wahana-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 22px;
    }

    /* ============================================================
       CARD — SAMA DENGAN MENU
       ============================================================ */

    .ng-wahana-card {
        overflow: hidden;
        display: flex;
        flex-direction: column;
        min-width: 0;
        border: 1px solid var(--border-soft);
        border-radius: 28px;
        background: var(--bg-card);
        transition:
            transform var(--transition),
            border-color var(--transition),
            box-shadow var(--transition),
            background var(--transition);
    }

    .ng-wahana-card:hover {
        transform: translateY(-7px);
        border-color: var(--border-gold-strong);
        background: #151515;
        box-shadow: var(--shadow-hover);
    }

    .ng-wahana-image-link {
        display: block;
        text-decoration: none;
    }

    .ng-wahana-image-wrap {
        position: relative;
        width: 100%;
        height: 245px;
        overflow: hidden;
        background: var(--bg-soft);
    }

    .ng-wahana-image {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        transition:
            transform .55s cubic-bezier(.2,.7,.2,1),
            filter .4s ease;
    }

    .ng-wahana-card:hover .ng-wahana-image {
        transform: scale(1.055);
        filter: saturate(1.04);
    }

    .ng-wahana-image-overlay {
        position: absolute;
        inset: 0;
        background:
            linear-gradient(
                to bottom,
                rgba(10,10,10,.05) 0%,
                transparent 45%,
                rgba(10,10,10,.65) 100%
            );
        pointer-events: none;
    }

    .ng-wahana-image-view {
        position: absolute;
        left: 50%;
        bottom: 18px;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 12px;
        border: 1px solid rgba(226,201,151,.30);
        border-radius: 999px;
        background: rgba(10,10,10,.72);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        color: var(--accent);
        font-size: 10px;
        font-weight: 600;
        transform: translate(-50%, 10px);
        opacity: 0;
        transition: opacity .3s ease, transform .3s ease;
        pointer-events: none;
        white-space: nowrap;
    }

    .ng-wahana-image-view svg {
        width: 13px;
        height: 13px;
    }

    .ng-wahana-card:hover .ng-wahana-image-view {
        opacity: 1;
        transform: translate(-50%, 0);
    }

    .ng-wahana-card-content {
        display: flex;
        flex: 1;
        flex-direction: column;
        padding: 21px;
    }

    .ng-wahana-card-category {
        margin-bottom: 7px;
        color: var(--accent);
        font-size: 10px;
        font-weight: 600;
        letter-spacing: .10em;
        text-transform: uppercase;
    }

    .ng-wahana-name {
        margin: 0;
        color: var(--text-primary);
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 20px;
        line-height: 1.25;
        font-weight: 700;
    }

    .ng-wahana-name a {
        color: inherit;
        text-decoration: none;
        transition: color var(--transition);
    }

    .ng-wahana-name a:hover {
        color: var(--accent);
    }

    .ng-wahana-rule {
        min-height: 48px;
        margin-top: 10px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        color: var(--text-muted);
        font-size: 12px;
        line-height: 1.8;
    }

    .ng-wahana-rule-empty {
        color: var(--text-dim);
        font-style: italic;
    }

    .ng-wahana-card-bottom {
        margin-top: auto;
        padding-top: 20px;
        display: flex;
        flex-direction: row;
        align-items: flex-end;
        justify-content: space-between;
        gap: 10px;
        border-top: 1px solid var(--border-soft);
    }

    .ng-wahana-ticket-wrapper {
        min-width: 0;
        flex: 1 1 auto;
        width: auto;
    }

    .ng-wahana-ticket-label {
        margin: 0 0 3px;
        color: var(--text-dim);
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: .08em;
    }

    .ng-wahana-ticket-price {
        margin: 0;
        color: var(--accent);
        font-size: 17px;
        line-height: 1.2;
        font-weight: 700;
        white-space: normal;
        overflow-wrap: anywhere;
    }

    .ng-wahana-actions {
        width: auto;
        flex: 0 0 auto;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 8px;
    }

    .ng-wahana-cart-form {
        margin: 0;
    }

    .ng-wahana-cart-button,
    .ng-wahana-detail-button {
        min-height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--border-gold);
        border-radius: 12px;
        background: rgba(226,201,151,.07);
        color: var(--accent);
        font-family: inherit;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        transition:
            background var(--transition),
            border-color var(--transition),
            color var(--transition),
            transform var(--transition),
            box-shadow var(--transition);
    }

    .ng-wahana-cart-button {
        width: 42px;
        min-width: 42px;
        height: 42px;
        padding: 0;
        gap: 0;
        flex: 0 0 42px;
    }

    .ng-wahana-cart-button svg {
        width: 17px;
        height: 17px;
        flex-shrink: 0;
    }

    .ng-wahana-cart-button:hover,
    .ng-wahana-detail-button:hover {
        border-color: var(--accent);
        background: var(--accent);
        color: var(--bg-primary);
    }

    .ng-wahana-cart-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(226,201,151,.12);
    }

    .ng-wahana-cart-button:disabled {
        opacity: .62;
        cursor: wait;
        transform: none;
    }

    .ng-wahana-detail-button {
        width: 42px;
        height: 42px;
        flex: 0 0 42px;
    }

    .ng-wahana-detail-button svg {
        width: 18px;
        height: 18px;
        transition: transform var(--transition);
    }

    .ng-wahana-detail-button:hover {
        transform: translateX(3px);
    }

    .ng-wahana-detail-button:hover svg {
        transform: translateX(2px);
    }

    /* ============================================================
       EMPTY — SAMA DENGAN MENU
       ============================================================ */

    .ng-wahana-empty {
        padding: 90px 30px;
        text-align: center;
        border: 1px dashed var(--border-gold);
        border-radius: 28px;
        background: rgba(255,255,255,.02);
    }

    .ng-wahana-empty-icon {
        width: 68px;
        height: 68px;
        margin: 0 auto 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--border-gold);
        border-radius: 20px;
        background: rgba(226,201,151,.055);
        color: var(--accent);
    }

    .ng-wahana-empty-icon svg {
        width: 30px;
        height: 30px;
    }

    .ng-wahana-empty-title {
        margin: 0;
        color: var(--text-primary);
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 27px;
        font-weight: 700;
    }

    .ng-wahana-empty-text {
        max-width: 420px;
        margin: 9px auto 0;
        color: var(--text-muted);
        font-size: 13px;
        line-height: 1.8;
    }

    .ng-wahana-empty-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 46px;
        margin-top: 24px;
        padding: 0 20px;
        border: 1px solid var(--accent);
        border-radius: 999px;
        background: linear-gradient(135deg, var(--accent), var(--accent-hover));
        color: var(--bg-primary);
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        transition: all var(--transition);
    }

    .ng-wahana-empty-link:hover {
        background: linear-gradient(135deg, var(--accent-hover), var(--accent-dark));
        transform: translateY(-2px);
        box-shadow: var(--shadow-soft);
    }

    /* ============================================================
       POPUP
       ============================================================ */

    .ng-wahana-popup {
        position: fixed;
        inset: 0;
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        box-sizing: border-box;
        background: rgba(0,0,0,.76);
        backdrop-filter: blur(11px);
        -webkit-backdrop-filter: blur(11px);
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: opacity .25s ease, visibility .25s ease;
    }

    .ng-wahana-popup.is-visible {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
    }

    .ng-wahana-popup-card {
        width: min(410px, 100%);
        box-sizing: border-box;
        padding: 29px 25px 23px;
        text-align: center;
        border: 1px solid var(--border-gold-strong);
        border-radius: 23px;
        background: var(--bg-card);
        box-shadow: 0 30px 90px rgba(0,0,0,.60);
        transform: translateY(12px) scale(.97);
        transition: transform .28s ease;
    }

    .ng-wahana-popup.is-visible .ng-wahana-popup-card {
        transform: translateY(0) scale(1);
    }

    .ng-wahana-popup-icon {
        width: 56px;
        height: 56px;
        margin: 0 auto 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 17px;
        color: var(--bg-primary);
        background: var(--accent);
    }

    .ng-wahana-popup-icon svg {
        width: 26px;
        height: 26px;
    }

    .ng-wahana-popup-title {
        margin: 0;
        color: var(--text-primary);
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 25px;
        line-height: 1.2;
        font-weight: 700;
    }

    .ng-wahana-popup-message {
        max-width: 320px;
        margin: 9px auto 0;
        color: var(--text-muted);
        font-size: 13px;
        line-height: 1.7;
    }

    .ng-wahana-popup-message strong {
        color: var(--accent);
        font-weight: 600;
    }

    .ng-wahana-popup-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 9px;
        margin-top: 22px;
    }

    .ng-wahana-popup-btn {
        min-height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
        border-radius: 12px;
        font-family: inherit;
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: transform .2s ease, background .2s ease;
    }

    .ng-wahana-popup-continue {
        border: 1px solid var(--border-soft);
        color: var(--text-secondary);
        background: rgba(255,255,255,.055);
    }

    .ng-wahana-popup-continue:hover {
        color: var(--text-primary);
        background: rgba(255,255,255,.09);
    }

    .ng-wahana-popup-cart {
        border: 1px solid var(--accent);
        color: var(--bg-primary);
        background: var(--accent);
    }

    .ng-wahana-popup-cart:hover {
        background: var(--accent-hover);
        transform: translateY(-1px);
    }

    /* ============================================================
       RESPONSIVE — SAMA DENGAN MENU
       ============================================================ */

    @media (max-width: 1200px) {
        .ng-wahana-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 992px) {
        .ng-wahana-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .ng-wahana-filter-form {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .ng-wahana-search-field {
            grid-column: span 2;
        }
    }

    @media (max-width: 768px) {
        .ng-wahana-hero-inner {
            padding: 50px 0 55px;
        }

        .ng-wahana-hero-title {
            font-size: 44px;
        }

        .ng-wahana-hero-description {
            font-size: 13px;
        }

        .ng-wahana-list-section {
            padding-bottom: 80px;
        }

        .ng-wahana-image-wrap {
            height: 225px;
        }
    }

    @media (max-width: 640px) {
        .ng-wahana-filter-box {
            padding: 14px;
        }

        .ng-wahana-filter-form {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .ng-wahana-search-field {
            grid-column: 1 / -1;
        }

        /* Di mobile, Urutkan dibuat full-width seperti field pencarian. */
        .ng-wahana-filter-field:not(.ng-wahana-search-field) {
            grid-column: 1 / -1;
        }

        .ng-wahana-filter-field:not(.ng-wahana-search-field) .ng-wahana-select-wrapper,
        .ng-wahana-filter-field:not(.ng-wahana-search-field) .ng-wahana-input {
            width: 100%;
        }

        .ng-wahana-result-row {
            align-items: flex-start;
            flex-direction: column;
        }

        .ng-wahana-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .ng-wahana-card {
            border-radius: 18px;
        }

        .ng-wahana-image-wrap {
            height: 145px;
        }

        .ng-wahana-card-content {
            padding: 16px;
        }

        .ng-wahana-card-category {
            margin-bottom: 5px;
            font-size: 9px;
        }

        .ng-wahana-name {
            font-size: 18px;
            line-height: 1.25;
        }

        .ng-wahana-rule {
            min-height: 42px;
            margin-top: 8px;
            font-size: 11px;
            line-height: 1.65;
        }

        .ng-wahana-card-bottom {
            padding-top: 14px;
            gap: 10px;
        }

        .ng-wahana-ticket-label {
            font-size: 9px;
        }

        .ng-wahana-ticket-price {
            font-size: 15px;
        }

        .ng-wahana-actions {
            gap: 6px;
        }

        .ng-wahana-cart-button,
        .ng-wahana-detail-button {
            min-height: 40px;
            height: 40px;
            border-radius: 11px;
        }

        .ng-wahana-detail-button {
            width: 40px;
            flex-basis: 40px;
        }

        .ng-wahana-cart-button {
            width: 40px;
            min-width: 40px;
            padding: 0;
            flex-basis: 40px;
        }

        .ng-wahana-cart-button span {
            display: none;
        }

        .ng-wahana-cart-button svg,
        .ng-wahana-detail-button svg {
            width: 17px;
            height: 17px;
        }

        .ng-wahana-hero-title {
            font-size: 39px;
        }

        .ng-wahana-hero-inner {
            padding: 42px 0 48px;
        }

        .ng-wahana-popup-actions {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 420px) {
        .ng-wahana-hero-title {
            font-size: 35px;
        }

        .ng-wahana-eyebrow {
            font-size: 9px;
        }

        .ng-wahana-grid {
            gap: 10px;
        }

        .ng-wahana-card {
            border-radius: 17px;
        }

        .ng-wahana-image-wrap {
            height: 125px;
        }

        .ng-wahana-card-content {
            padding: 12px;
        }

        .ng-wahana-card-category {
            font-size: 8px;
            margin-bottom: 4px;
        }

        .ng-wahana-name {
            font-size: 14px;
            line-height: 1.2;
        }

        .ng-wahana-rule {
            font-size: 9.5px;
            line-height: 1.5;
            min-height: 29px;
            margin-top: 6px;
        }

        .ng-wahana-card-bottom {
            padding-top: 13px;
            gap: 7px;
            display: flex;
            flex-direction: row;
            align-items: flex-end;
            justify-content: space-between;
        }

        .ng-wahana-ticket-wrapper {
            min-width: 0;
            flex: 1 1 auto;
            width: auto;
        }

        .ng-wahana-ticket-price {
            font-size: 15px;
            white-space: normal;
            overflow-wrap: anywhere;
        }

        .ng-wahana-actions {
            width: auto;
            flex: 0 0 auto;
            justify-content: flex-end;
            gap: 6px;
        }
    }

    @media (max-width: 350px) {
        .ng-wahana-grid {
            gap: 8px;
        }

        .ng-wahana-card {
            border-radius: 15px;
        }

        .ng-wahana-image-wrap {
            height: 108px;
        }

        .ng-wahana-card-content {
            padding: 10px;
        }

        .ng-wahana-card-category {
            font-size: 7px;
        }

        .ng-wahana-name {
            font-size: 13px;
        }

        .ng-wahana-rule {
            font-size: 9px;
            min-height: 27px;
        }

        .ng-wahana-card-bottom {
            gap: 9px;
        }

        .ng-wahana-ticket-price {
            font-size: 14px;
        }

        .ng-wahana-actions {
            justify-content: flex-end;
            gap: 5px;
            flex: 0 0 auto;
        }

        .ng-wahana-cart-button,
        .ng-wahana-detail-button {
            min-height: 38px;
            height: 38px;
        }

        .ng-wahana-cart-button {
            width: 39px;
            min-width: 39px;
        }

        .ng-wahana-detail-button {
            width: 39px;
            flex-basis: 39px;
        }
    }
</style>


<div class="ng-wahana-page">

    {{-- ============================================================
         HERO
         ============================================================ --}}
    <section class="ng-wahana-hero">
        <div class="ng-wahana-container">
            <div class="ng-wahana-hero-inner">

            <nav class="ng-wahana-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('public.home') }}">Home</a>
                <span class="ng-wahana-breadcrumb-separator">/</span>
                <span class="ng-wahana-breadcrumb-current">Wahana</span>
            </nav>

            <div class="ng-wahana-heading">
                <span class="ng-wahana-eyebrow">
                    Wahana Noyo Gimbal
                </span>

                <h1 class="ng-wahana-hero-title">
                    Jelajahi
                    <span>Wahana Favoritmu</span>
                </h1>

                <p class="ng-wahana-hero-description">
                    Temukan berbagai wahana yang tersedia di Noyo Gimbal
                    dan pilih pengalaman yang ingin kamu nikmati bersama
                    keluarga maupun teman.
                </p>
            </div>

            </div>
        </div>
    </section>

    {{-- ============================================================
         SEARCH & SORT
         ============================================================ --}}
    <section class="ng-wahana-filter-section">
        <div class="ng-wahana-container">

            @if(session('error'))
                <div role="alert" style="margin-bottom:14px;padding:14px 16px;border:1px solid rgba(217,130,118,.28);border-radius:12px;background:rgba(217,130,118,.07);color:#dfa69e;line-height:1.6;">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div role="status" style="margin-bottom:14px;padding:14px 16px;border:1px solid rgba(226,201,151,.24);border-radius:12px;background:rgba(226,201,151,.06);color:#e2c997;line-height:1.6;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="ng-wahana-filter-box">
                <form
                    action="{{ route('public.tiket-wahana.index') }}"
                    method="GET"
                    class="ng-wahana-filter-form" id="ngWahanaFilterForm"
                >

                    <div class="ng-wahana-filter-field ng-wahana-search-field">
                        <label for="search" class="ng-wahana-filter-label">
                            Cari wahana
                        </label>
                        <div class="ng-wahana-search">
                        <svg
                            class="ng-wahana-search-icon"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.7"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m21 21-4.35-4.35m1.35-5.4a6.75 6.75 0 1 1-13.5 0 6.75 6.75 0 0 1 13.5 0Z"
                            />
                        </svg>

                        <input
                            type="text"
                            id="search"
                            name="search"
                            value="{{ $searchValue }}"
                            placeholder="Cari nama wahana atau ketentuan..."
                            class="ng-wahana-input ng-wahana-input-search"
                            autocomplete="off"
                        >

                        <button
                            type="button"
                            id="clearSearch"
                            class="ng-wahana-clear-search {{ $searchValue !== '' ? 'is-visible' : '' }}"
                            aria-label="Hapus pencarian"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.8"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 18 18 6M6 6l12 12"
                                />
                            </svg>
                        </button>

                        </div>
                    </div>

                    <div class="ng-wahana-filter-field">
                        <label for="sort" class="ng-wahana-filter-label">
                            Urutkan
                        </label>
                        <div class="ng-wahana-select-wrapper">
                    <select
                        id="sort"
                        name="sort"
                        class="ng-wahana-input ng-wahana-auto-submit"
                    >
                        <option value="price_asc" @selected($sortValue === 'price_asc')>
                            Harga Terendah
                        </option>
                        <option value="price_desc" @selected($sortValue === 'price_desc')>
                            Harga Tertinggi
                        </option>
                    </select>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </section>

    {{-- ============================================================
         RESULT INFORMATION
         ============================================================ --}}
    <section class="ng-wahana-result-section">
        <div class="ng-wahana-container">

            <div class="ng-wahana-result-row">

                <p class="ng-wahana-result-text">
                    Menampilkan
                    <span class="ng-wahana-result-count">{{ $tiketWahanas->count() }}</span>
                    wahana
                </p>

            </div>

        </div>
    </section>

    {{-- ============================================================
         WAHANA LIST
         ============================================================ --}}
    <section class="ng-wahana-list-section">
        <div class="ng-wahana-container">

            @if($tiketWahanas->count() > 0)

                <div class="ng-wahana-grid">

                    @foreach($tiketWahanas as $wahana)

                        <article class="ng-wahana-card">

                            {{-- IMAGE --}}
                            <a
                                href="{{ route('public.tiket-wahana.show', $wahana->id_tiket_wahana) }}"
                                class="ng-wahana-image-link"
                            >
                                <div class="ng-wahana-image-wrap">

                                    <img
                                        src="{{ $resolveWahanaImage($wahana) }}"
                                        alt="{{ $wahana->nama_wahana }}"
                                        class="ng-wahana-image"
                                        loading="lazy"
                                        decoding="async"
                                        onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';"
                                    >

                                    <div class="ng-wahana-image-overlay"></div>

                                    <div class="ng-wahana-image-view">
                                        <span>Lihat detail</span>
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="1.7"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"
                                            />
                                        </svg>
                                    </div>

                                </div>
                            </a>

                            {{-- CONTENT --}}
                            <div class="ng-wahana-card-content">

                                <div class="ng-wahana-card-category">
                                    Wahana
                                </div>

                                <h2 class="ng-wahana-name">
                                    <a href="{{ route('public.tiket-wahana.show', $wahana->id_tiket_wahana) }}">
                                        {{ $wahana->nama_wahana }}
                                    </a>
                                </h2>

                                @if($wahana->ketentuan)
                                    <p class="ng-wahana-rule">
                                        {{ $wahana->ketentuan }}
                                    </p>
                                @else
                                    <p class="ng-wahana-rule ng-wahana-rule-empty">
                                        Tidak ada ketentuan khusus.
                                    </p>
                                @endif

                                <div class="ng-wahana-card-bottom">

                                    <div class="ng-wahana-ticket-wrapper">
                                        <p class="ng-wahana-ticket-label">
                                            Harga
                                        </p>
                                        <p class="ng-wahana-ticket-price">
                                            Rp {{ number_format($wahana->harga, 0, ',', '.') }}
                                        </p>
                                    </div>

                                    <div class="ng-wahana-actions">

                                        {{-- TAMBAH KE KERANJANG --}}
                                        <form
                                            action="{{ route('pesanan.keranjang.tambah') }}"
                                            method="POST"
                                            class="ng-wahana-cart-form"
                                            data-wahana-name="{{ $wahana->nama_wahana }}"
                                        >
                                            @csrf

                                            <input type="hidden" name="type" value="wahana">
                                            <input type="hidden" name="id" value="{{ $wahana->id_tiket_wahana }}">
                                            <input type="hidden" name="qty" value="1">

                                            <button
                                                type="submit"
                                                class="ng-wahana-cart-button"
                                                aria-label="Tambah {{ $wahana->nama_wahana }} ke keranjang"
                                            >
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                    stroke-width="1.8"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M2.75 3.75h2.1l1.55 10.1a2 2 0 0 0 1.98 1.7h8.9a2 2 0 0 0 1.94-1.5l1.35-5.3H6.05"
                                                    />
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M9 20.25h.01M17 20.25h.01"
                                                    />
                                                </svg>
                                            </button>
                                        </form>

                                        {{-- DETAIL --}}
                                        <a
                                            href="{{ route('public.tiket-wahana.show', $wahana->id_tiket_wahana) }}"
                                            class="ng-wahana-detail-button"
                                            aria-label="Lihat {{ $wahana->nama_wahana }}"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"
                                                />
                                            </svg>
                                        </a>

                                    </div>

                                </div>

                            </div>

                        </article>

                    @endforeach

                </div>

            @else

                <div class="ng-wahana-empty">

                    <div class="ng-wahana-empty-icon">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 3.75H6.75A2.25 2.25 0 0 0 4.5 6v12a2.25 2.25 0 0 0 2.25 2.25h12A2.25 2.25 0 0 0 21 18V9.75L14.25 3H9Z"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M14.25 3v6.75H21"
                            />
                        </svg>
                    </div>

                    <h2 class="ng-wahana-empty-title">
                        Wahana tidak ditemukan
                    </h2>

                    <p class="ng-wahana-empty-text">
                        @if ($searchValue !== '')
                            Tidak ada wahana yang cocok dengan pencarian “{{ $searchValue }}”. Coba kata kunci lain.
                        @else
                            Saat ini belum ada wahana yang tersedia. Silakan cek kembali nanti.
                        @endif
                    </p>

                    <a
                        href="{{ route('public.tiket-wahana.index') }}"
                        class="ng-wahana-empty-link"
                    >
                        Tampilkan Semua Wahana
                    </a>

                </div>

            @endif

        </div>
    </section>

</div>

{{-- ============================================================
     POPUP TAMBAH KE KERANJANG
     ============================================================ --}}
<div
    id="ngWahanaPopup"
    class="ng-wahana-popup"
    aria-hidden="true"
>
    <div
        class="ng-wahana-popup-card"
        role="dialog"
        aria-modal="true"
        aria-labelledby="ngWahanaPopupTitle"
        onclick="event.stopPropagation()"
    >

        <div class="ng-wahana-popup-icon">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.8"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="m5 12.5 4 4L19 6.5"
                />
            </svg>
        </div>

        <h2 id="ngWahanaPopupTitle" class="ng-wahana-popup-title">
            Berhasil Ditambahkan
        </h2>

        <p id="ngWahanaPopupMessage" class="ng-wahana-popup-message">
            Tiket wahana sudah masuk ke keranjang.
        </p>

        <div class="ng-wahana-popup-actions">

            <button
                type="button"
                id="ngWahanaContinue"
                class="ng-wahana-popup-btn ng-wahana-popup-continue"
            >
                Lanjut Pilih Wahana
            </button>

            <a
                href="{{ route('pesanan.keranjang') }}"
                class="ng-wahana-popup-btn ng-wahana-popup-cart"
            >
                Lihat Keranjang
            </a>

        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const filterForm = document.getElementById('ngWahanaFilterForm');
    const searchInput = document.getElementById('search');
    const sortInput = document.getElementById('sort');
    const clearSearchButton = document.getElementById('clearSearch');

    if (filterForm) {
        let searchTimer = null;
        let lastSubmittedSearch = searchInput ? searchInput.value : '';

        const submitFilter = function () {
            if (searchInput) {
                lastSubmittedSearch = searchInput.value;
            }
            filterForm.requestSubmit ? filterForm.requestSubmit() : filterForm.submit();
        };

        if (searchInput) {
            searchInput.addEventListener('input', function () {
                clearTimeout(searchTimer);
                if (clearSearchButton) {
                    clearSearchButton.classList.toggle('is-visible', searchInput.value.trim() !== '');
                }
                searchTimer = setTimeout(function () {
                    if (searchInput.value !== lastSubmittedSearch) {
                        submitFilter();
                    }
                }, 600);
            });

            searchInput.addEventListener('keydown', function (event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    clearTimeout(searchTimer);
                    if (searchInput.value !== lastSubmittedSearch) {
                        submitFilter();
                    } else if (sortInput) {
                        submitFilter();
                    }
                }
            });
        }

        if (sortInput) {
            sortInput.addEventListener('change', function () {
                clearTimeout(searchTimer);
                submitFilter();
            });
        }

        if (clearSearchButton && searchInput) {
            clearSearchButton.addEventListener('click', function () {
                clearTimeout(searchTimer);
                searchInput.value = '';
                submitFilter();
            });
        }
    }

    const popup = document.getElementById('ngWahanaPopup');
    const popupMessage = document.getElementById('ngWahanaPopupMessage');
    const continueButton = document.getElementById('ngWahanaContinue');
    const cartForms = document.querySelectorAll('.ng-wahana-cart-form');
    const expectedCartUrl = new URL(@json(route('pesanan.keranjang')), window.location.origin);
    const expectedCartPath = expectedCartUrl.pathname.replace(/\/+$/, '') || '/';

    if (!popup || !popupMessage) {
        return;
    }

    let popupTimer = null;
    let lastTrigger = null;

    function escapeHtml(value) {
        const element = document.createElement('span');
        element.textContent = String(value || '');
        return element.innerHTML;
    }

    function closePopup() {
        popup.classList.remove('is-visible');
        popup.setAttribute('aria-hidden', 'true');

        if (popupTimer) {
            clearTimeout(popupTimer);
            popupTimer = null;
        }

        if (lastTrigger && document.contains(lastTrigger)) {
            lastTrigger.focus();
        }
    }

    function openPopup(name, trigger) {
        lastTrigger = trigger || null;
        popupMessage.innerHTML = '<strong>' + escapeHtml(name) + '</strong> sudah masuk ke keranjang.';
        popup.classList.add('is-visible');
        popup.setAttribute('aria-hidden', 'false');

        if (popupTimer) {
            clearTimeout(popupTimer);
        }

        if (continueButton) {
            continueButton.focus();
        }

        popupTimer = setTimeout(closePopup, 4500);
    }

    if (continueButton) {
        continueButton.addEventListener('click', closePopup);
    }

    popup.addEventListener('click', function (event) {
        if (event.target === popup) {
            closePopup();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && popup.classList.contains('is-visible')) {
            closePopup();
        }
    });

    cartForms.forEach(function (form) {
        form.addEventListener('submit', async function (event) {
            event.preventDefault();

            const button = form.querySelector('button[type="submit"]');
            const name = form.dataset.wahanaName || 'Tiket wahana';

            if (!button || button.disabled) {
                return;
            }

            const originalContent = button.innerHTML;
            button.disabled = true;
            button.setAttribute('aria-busy', 'true');
            button.innerHTML = '<span aria-hidden="true">…</span>';

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html'
                    },
                    credentials: 'same-origin',
                    redirect: 'follow'
                });

                let successfulAdd = false;
                const contentType = response.headers.get('content-type') || '';

                if (response.ok && contentType.includes('application/json')) {
                    const result = await response.json();
                    successfulAdd = result.success === true || result.status === 'success';
                } else if (response.ok && response.redirected) {
                    const finalUrl = new URL(response.url, window.location.origin);
                    const finalPath = finalUrl.pathname.replace(/\/+$/, '') || '/';
                    successfulAdd = finalPath === expectedCartPath;
                }

                if (!successfulAdd) {
                    throw new Error('Server tidak mengonfirmasi bahwa tiket berhasil ditambahkan.');
                }

                button.innerHTML = '<span aria-hidden="true">✓</span>';
                openPopup(name, button);
            } catch (error) {
                console.error('Tambah tiket wahana ke keranjang:', error);
                button.innerHTML = originalContent;
                window.alert('Tiket gagal ditambahkan ke keranjang. Silakan coba lagi.');
            } finally {
                button.removeAttribute('aria-busy');
                window.setTimeout(function () {
                    button.disabled = false;
                    button.innerHTML = originalContent;
                }, 900);
            }
        });
    });
});
</script>
@endsection
