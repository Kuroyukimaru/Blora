@extends('public.layouts.app')

@section('title', 'Pembayaran - Noyo Gimbal')

@section('content')

<style>

    :root {
        --payment-bg: #0a0a0a;
        --payment-secondary: #151515;
        --payment-soft: #1a1a1a;
        --payment-card: #121212;

        --payment-text: #f8f4ed;
        --payment-text-secondary: #d4c9b5;
        --payment-muted: #a89988;
        --payment-dim: #7a6f62;

        --payment-gold: #e2c997;
        --payment-gold-hover: #d4b384;
        --payment-gold-dark: #b89a6e;

        --payment-border: rgba(226, 201, 151, .15);
        --payment-border-soft: rgba(255, 255, 255, .06);
        --payment-border-strong: rgba(226, 201, 151, .30);

        --payment-danger: #d98276;

        --payment-shadow: 0 20px 60px rgba(0, 0, 0, .40);
        --payment-shadow-hover: 0 25px 70px rgba(0, 0, 0, .50);

        --payment-radius-lg: 28px;
        --payment-radius-md: 16px;
        --payment-radius-sm: 12px;
        --payment-radius-full: 999px;

        --payment-transition: .25s cubic-bezier(.4, 0, .2, 1);
    }

    .payment-page,
    .payment-page *,
    .payment-modal-overlay,
    .payment-modal-overlay * {
        box-sizing: border-box;
    }

    .payment-page {
        width: 100%;
        min-width: 0;
        min-height: 100vh;
        padding: 118px 0 90px;
        color: var(--payment-text);
        background:
            radial-gradient(
                circle at 88% 4%,
                rgba(226, 201, 151, .075),
                transparent 25%
            ),
            radial-gradient(
                circle at 8% 50%,
                rgba(226, 201, 151, .035),
                transparent 24%
            ),
            var(--payment-bg);
        overflow-x: clip;
    }

    .payment-container {
        width: min(1280px, calc(100% - 64px));
        min-width: 0;
        margin: 0 auto;
    }

    .payment-heading {
        margin-bottom: 34px;
    }

    .payment-title {
        margin: 0;
        color: var(--payment-text);
        font-family: "Playfair Display", Georgia, serif;
        font-size: clamp(48px, 6vw, 76px);
        font-weight: 600;
        line-height: 1.02;
        letter-spacing: -.04em;
        text-wrap: balance;
    }

    .payment-description {
        max-width: 760px;
        margin: 16px 0 0;
        color: var(--payment-text-secondary);
        font-size: 17px;
        line-height: 1.8;
    }

    .payment-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.15fr) minmax(0, .85fr);
        gap: 26px;
        align-items: start;
    }

    .payment-panel {
        min-width: 0;
        overflow: hidden;
        border: 1px solid var(--payment-border);
        border-radius: var(--payment-radius-lg);
        background:
            linear-gradient(
                145deg,
                rgba(255, 255, 255, .025),
                rgba(255, 255, 255, .01)
            ),
            var(--payment-card);
        box-shadow: 0 12px 36px rgba(0, 0, 0, .22);
    }

    .payment-panel:hover {
        border-color: rgba(226, 201, 151, .20);
    }

    .payment-panel-header {
        padding: 28px 30px 22px;
        border-bottom: 1px solid var(--payment-border-soft);
        background: rgba(255, 255, 255, .012);
    }

    .payment-panel-title {
        margin: 0;
        color: var(--payment-text);
        font-family: "Playfair Display", Georgia, serif;
        font-size: 24px;
        line-height: 1.25;
        font-weight: 600;
    }

    .payment-panel-subtitle {
        max-width: 720px;
        margin: 8px 0 0;
        color: var(--payment-muted);
        font-size: 15px;
        line-height: 1.75;
    }

    .payment-panel-body {
        padding: 30px;
    }

    .payment-alert {
        margin-bottom: 24px;
        padding: 16px 18px;
        border: 1px solid rgba(217, 130, 118, .23);
        border-radius: var(--payment-radius-sm);
        background: rgba(217, 130, 118, .055);
        color: #dfa69e;
        font-size: 15px;
        line-height: 1.7;
    }

    .payment-form-group {
        margin-bottom: 24px;
    }

    .payment-label {
        display: block;
        margin-bottom: 10px;
        color: var(--payment-text-secondary);
        font-size: 16px;
        font-weight: 800;
        line-height: 1.4;
    }

    .payment-label span {
        color: var(--payment-gold);
    }

    .payment-input {
        width: 100%;
        min-height: 56px;
        padding: 0 17px;
        border: 1px solid var(--payment-border);
        border-radius: 14px;
        outline: none;
        background: #0f0f0f;
        color: var(--payment-text);
        font: inherit;
        font-size: 16px;
        line-height: 1.4;
        transition:
            border-color var(--payment-transition),
            background var(--payment-transition),
            box-shadow var(--payment-transition);
    }

    .payment-input::placeholder {
        color: #756b60;
    }

    .payment-input:hover {
        background: #111111;
        border-color: rgba(226, 201, 151, .21);
    }

    .payment-input:focus {
        border-color: var(--payment-gold-dark);
        background: #111111;
        box-shadow: 0 0 0 4px rgba(226, 201, 151, .09);
    }

    .payment-input:invalid:not(:placeholder-shown) {
        border-color: rgba(217, 130, 118, .50);
    }

    .payment-error {
        margin-top: 8px;
        color: var(--payment-danger);
        font-size: 14px;
        line-height: 1.5;
    }

    .payment-hint {
        margin-top: 8px;
        color: var(--payment-dim);
        font-size: 14px;
        line-height: 1.65;
    }

    .payment-method-heading {
        margin: 30px 0 13px;
        color: var(--payment-text-secondary);
        font-size: 16px;
        font-weight: 800;
    }

    .payment-method-card {
        position: relative;
        min-height: 124px;
        padding: 21px;
        border: 1px solid var(--payment-gold);
        border-radius: var(--payment-radius-md);
        background:
            linear-gradient(
                145deg,
                rgba(226, 201, 151, .09),
                rgba(226, 201, 151, .035)
            );
        box-shadow:
            inset 0 0 0 1px rgba(226, 201, 151, .06),
            0 10px 30px rgba(0, 0, 0, .12);
    }

    .payment-method-check {
        position: absolute;
        top: 17px;
        right: 17px;
        width: 24px;
        height: 24px;
        display: grid;
        place-items: center;
        border-radius: 50%;
        background: var(--payment-gold);
        color: var(--payment-bg);
    }

    .payment-method-icon {
        width: 44px;
        height: 44px;
        display: grid;
        place-items: center;
        margin-bottom: 12px;
        border: 1px solid rgba(226, 201, 151, .20);
        border-radius: 12px;
        color: var(--payment-gold);
        background: #0d0d0d;
    }

    .payment-method-icon svg {
        width: 21px;
        height: 21px;
    }

    .payment-method-name {
        color: var(--payment-text);
        font-size: 17px;
        line-height: 1.35;
        font-weight: 800;
    }

    .payment-method-description {
        max-width: 700px;
        margin-top: 5px;
        color: var(--payment-muted);
        font-size: 14px;
        line-height: 1.65;
    }

    .payment-guide {
        margin-top: 20px;
        padding: 22px;
        border: 1px solid var(--payment-border);
        border-radius: var(--payment-radius-md);
        background: var(--payment-secondary);
    }

    .payment-guide-head {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        margin-bottom: 18px;
    }

    .payment-guide-icon {
        width: 42px;
        height: 42px;
        flex: 0 0 42px;
        display: grid;
        place-items: center;
        border: 1px solid rgba(226, 201, 151, .23);
        border-radius: 12px;
        color: var(--payment-gold);
        background: #0d0d0d;
    }

    .payment-guide-icon svg {
        width: 20px;
        height: 20px;
    }

    .payment-guide-title {
        margin: 0;
        color: var(--payment-text);
        font-size: 17px;
        line-height: 1.35;
        font-weight: 800;
    }

    .payment-guide-description {
        max-width: 760px;
        margin: 5px 0 0;
        color: var(--payment-muted);
        font-size: 14px;
        line-height: 1.7;
    }

    .payment-step-list {
        display: grid;
        gap: 12px;
        margin: 0;
        padding: 0;
        list-style: none;
        counter-reset: payment-step;
    }

    .payment-step {
        display: grid;
        grid-template-columns: 34px minmax(0, 1fr);
        gap: 12px;
        align-items: start;
        color: var(--payment-text-secondary);
        font-size: 15px;
        line-height: 1.7;
        counter-increment: payment-step;
    }

    .payment-step::before {
        content: counter(payment-step);
        width: 34px;
        height: 34px;
        display: grid;
        place-items: center;
        border: 1px solid var(--payment-border);
        border-radius: 50%;
        background: #0c0c0c;
        color: var(--payment-gold);
        font-size: 13px;
        font-weight: 800;
    }

    .payment-step strong {
        color: var(--payment-text);
    }

    .payment-note {
        margin-top: 17px;
        padding: 14px 16px;
        border-left: 3px solid var(--payment-gold);
        border-radius: 0 10px 10px 0;
        background: rgba(226, 201, 151, .045);
        color: var(--payment-muted);
        font-size: 14px;
        line-height: 1.7;
    }

    .payment-note strong {
        color: var(--payment-text-secondary);
    }

    .payment-method-options {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .payment-method-card {
        display: block;
        width: 100%;
        min-width: 0;
        text-align: left;
        font: inherit;
        color: inherit;
        cursor: pointer;
        transition: border-color var(--payment-transition), background var(--payment-transition), transform var(--payment-transition), box-shadow var(--payment-transition);
    }

    .payment-method-card:hover {
        border-color: var(--payment-gold);
        transform: translateY(-2px);
    }

    .payment-method-card.is-selected {
        border-color: var(--payment-gold);
        background: linear-gradient(145deg, rgba(226, 201, 151, .12), rgba(226, 201, 151, .04));
        box-shadow: inset 0 0 0 1px rgba(226, 201, 151, .08), 0 10px 30px rgba(0, 0, 0, .12);
    }

    .payment-method-card .payment-method-check {
        opacity: 0;
        transform: scale(.85);
        transition: opacity var(--payment-transition), transform var(--payment-transition);
    }

    .payment-method-card.is-selected .payment-method-check {
        opacity: 1;
        transform: scale(1);
    }

    .payment-method-icon,
    .payment-method-name,
    .payment-method-description {
        display: block;
    }

    .payment-method-icon svg,
    .payment-method-check svg {
        width: 100%;
        height: 100%;
    }

    .payment-step {
        display: flex;
        gap: 12px;
    }

    .payment-step::before {
        flex: 0 0 34px;
    }

    .payment-guide[hidden] {
        display: none !important;
    }

    .payment-submit-area {
        margin-top: 28px;
        padding-top: 24px;
        border-top: 1px solid var(--payment-border-soft);
    }

    .payment-submit {
        width: 100%;
        min-height: 58px;
        padding: 14px 22px;
        border: 1px solid var(--payment-gold);
        border-radius: 15px;
        background: linear-gradient(
            135deg,
            var(--payment-gold),
            var(--payment-gold-hover)
        );
        color: #11100d;
        font: inherit;
        font-size: 16px;
        font-weight: 900;
        letter-spacing: .01em;
        cursor: pointer;
        transition:
            transform var(--payment-transition),
            box-shadow var(--payment-transition),
            background var(--payment-transition);
    }

    .payment-submit:hover,
    .payment-submit:focus-visible {
        background: linear-gradient(
            135deg,
            var(--payment-gold-hover),
            var(--payment-gold-dark)
        );
        transform: translateY(-2px);
        box-shadow: var(--payment-shadow-hover);
        outline: none;
    }

    .payment-submit:disabled {
        opacity: .68;
        cursor: wait;
        transform: none;
        box-shadow: none;
    }

    .payment-secure-note {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 13px;
        color: var(--payment-dim);
        font-size: 13px;
        line-height: 1.6;
        text-align: center;
    }

    .payment-summary {
        position: sticky;
        top: 104px;
    }

    .payment-summary-header {
        padding: 26px 26px 21px;
        border-bottom: 1px solid var(--payment-border-soft);
    }

    .payment-summary-title {
        margin: 0;
        color: var(--payment-text);
        font-family: "Playfair Display", Georgia, serif;
        font-size: 24px;
        line-height: 1.25;
        font-weight: 600;
    }

    .payment-summary-count {
        margin-top: 6px;
        color: var(--payment-muted);
        font-size: 14px;
        line-height: 1.5;
    }

    .payment-summary-body {
        padding: 23px 26px 26px;
    }

    .payment-item-list {
        display: grid;
        gap: 17px;
    }

    .payment-item {
        display: grid;
        min-width: 0;
        grid-template-columns: 72px minmax(0, 1fr);
        gap: 14px;
        align-items: center;
    }

    .payment-item-image {
        width: 72px;
        height: 72px;
        overflow: hidden;
        border: 1px solid var(--payment-border);
        border-radius: 14px;
        background: #0d0d0d;
    }

    .payment-item-image img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .payment-image-fallback {
        width: 100%;
        height: 100%;
        display: grid;
        place-items: center;
        color: #8b806f;
    }

    .payment-image-fallback svg {
        width: 20px;
        height: 20px;
    }

    .payment-item-name {
        min-width: 0;
        overflow-wrap: anywhere;
        color: var(--payment-text);
        font-size: 15px;
        line-height: 1.45;
        font-weight: 800;
    }

    .payment-item-meta {
        margin-top: 4px;
        color: var(--payment-muted);
        font-size: 13px;
        line-height: 1.5;
    }

    .payment-item-price {
        margin-top: 5px;
        color: var(--payment-gold);
        font-size: 14px;
        line-height: 1.45;
        font-weight: 800;
    }

    .payment-total {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 18px;
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid var(--payment-border-soft);
    }

    .payment-total-label {
        color: var(--payment-muted);
        font-size: 14px;
        line-height: 1.5;
    }

    .payment-total-value {
        min-width: 0;
        overflow-wrap: anywhere;
        color: var(--payment-gold);
        font-size: 24px;
        line-height: 1.25;
        font-weight: 900;
        text-align: right;
    }

    .payment-back {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        min-height: 52px;
        margin-top: 17px;
        padding: 0 16px;
        border: 1px solid var(--payment-border);
        border-radius: 14px;
        color: var(--payment-text-secondary);
        background: rgba(226, 201, 151, .025);
        text-decoration: none;
        font-size: 15px;
        font-weight: 800;
        transition:
            color var(--payment-transition),
            border-color var(--payment-transition),
            background var(--payment-transition),
            transform var(--payment-transition);
    }

    .payment-back:hover,
    .payment-back:focus-visible {
        color: var(--payment-gold);
        border-color: var(--payment-border-strong);
        background: rgba(226, 201, 151, .06);
        transform: translateY(-1px);
        outline: none;
    }

    .payment-modal-overlay {
        position: fixed;
        inset: 0;
        z-index: 99999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 24px;
        background: rgba(0, 0, 0, .76);
        backdrop-filter: blur(9px);
        -webkit-backdrop-filter: blur(9px);
    }

    .payment-modal-overlay.active {
        display: flex;
    }

    .payment-modal {
        width: min(500px, 100%);
        max-height: min(90vh, 720px);
        overflow-y: auto;
        padding: 30px;
        border: 1px solid var(--payment-border-strong);
        border-radius: var(--payment-radius-lg);
        background:
            linear-gradient(
                145deg,
                rgba(255, 255, 255, .025),
                rgba(255, 255, 255, .01)
            ),
            var(--payment-card);
        box-shadow: var(--payment-shadow-hover);
    }

    .payment-modal-icon {
        width: 54px;
        height: 54px;
        display: grid;
        place-items: center;
        margin-bottom: 18px;
        border: 1px solid rgba(226, 201, 151, .25);
        border-radius: 15px;
        color: var(--payment-gold);
        background: rgba(226, 201, 151, .06);
    }

    .payment-modal-icon svg {
        width: 24px;
        height: 24px;
    }

    .payment-modal-title {
        margin: 0;
        color: var(--payment-text);
        font-family: "Playfair Display", Georgia, serif;
        font-size: 30px;
        font-weight: 600;
        line-height: 1.2;
    }

    .payment-modal-text {
        margin: 10px 0 0;
        color: var(--payment-muted);
        font-size: 15px;
        line-height: 1.75;
    }

    .payment-modal-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-top: 25px;
    }

    .payment-modal-button {
        min-height: 52px;
        padding: 12px 18px;
        border-radius: 14px;
        font: inherit;
        font-size: 15px;
        font-weight: 800;
        cursor: pointer;
        transition: all var(--payment-transition);
    }

    .payment-modal-cancel {
        border: 1px solid var(--payment-border);
        color: var(--payment-text-secondary);
        background: #181818;
    }

    .payment-modal-cancel:hover,
    .payment-modal-cancel:focus-visible {
        color: var(--payment-text);
        border-color: var(--payment-border-strong);
        background: #202020;
        outline: none;
    }

    .payment-modal-confirm {
        border: 1px solid var(--payment-gold);
        color: #11100d;
        background: linear-gradient(
            135deg,
            var(--payment-gold),
            var(--payment-gold-hover)
        );
    }

    .payment-modal-confirm:hover,
    .payment-modal-confirm:focus-visible {
        background: linear-gradient(
            135deg,
            var(--payment-gold-hover),
            var(--payment-gold-dark)
        );
        transform: translateY(-1px);
        outline: none;
    }

    .payment-page a:focus-visible,
    .payment-page button:focus-visible,
    .payment-page input:focus-visible,
    .payment-modal-overlay button:focus-visible {
        outline: 3px solid rgba(226, 201, 151, .45);
        outline-offset: 3px;
    }

    @media (min-width: 1500px) {
        .payment-container {
            width: min(1360px, calc(100% - 96px));
        }

        .payment-grid {
            gap: 30px;
        }
    }

    @media (max-width: 1200px) {
        .payment-container {
            width: min(1120px, calc(100% - 56px));
        }

        .payment-grid {
            grid-template-columns: minmax(0, 1fr) 360px;
            gap: 22px;
        }

        .payment-title {
            font-size: clamp(45px, 6vw, 66px);
        }
    }

    @media (max-width: 1000px) {
        .payment-page {
            padding-top: 104px;
        }

        .payment-container {
            width: min(900px, calc(100% - 44px));
        }

        .payment-grid {
            grid-template-columns: 1fr;
        }

        .payment-summary {
            position: static;
        }

        .payment-summary-header,
        .payment-summary-body {
            padding-left: 28px;
            padding-right: 28px;
        }
    }

    @media (max-width: 768px) {
        .payment-page {
            padding: 96px 0 68px;
        }

        .payment-container {
            width: calc(100% - 32px);
        }

        .payment-heading {
            margin-bottom: 26px;
        }

        .payment-title {
            font-size: clamp(38px, 12vw, 50px);
        }

        .payment-description {
            font-size: 15px;
            line-height: 1.75;
        }

        .payment-panel {
            border-radius: 22px;
        }

        .payment-panel-header,
        .payment-panel-body {
            padding: 20px;
        }

        .payment-panel-title,
        .payment-summary-title {
            font-size: 21px;
        }

        .payment-panel-subtitle {
            font-size: 14px;
        }

        .payment-form-group {
            margin-bottom: 21px;
        }

        .payment-label {
            font-size: 15px;
        }

        .payment-input {
            min-height: 56px;
            padding: 0 15px;
            font-size: 16px;
            border-radius: 13px;
        }

        .payment-hint,
        .payment-error {
            font-size: 13px;
        }

        .payment-method-heading {
            font-size: 15px;
        }

        .payment-method-card {
            padding: 18px;
            min-height: 115px;
            border-radius: 14px;
        }

        .payment-method-name {
            font-size: 16px;
        }

        .payment-method-description {
            font-size: 13px;
        }

        .payment-guide {
            padding: 18px;
            border-radius: 14px;
        }

        .payment-guide-title {
            font-size: 16px;
        }

        .payment-guide-description {
            font-size: 13px;
        }

        .payment-step {
            grid-template-columns: 32px minmax(0, 1fr);
            gap: 10px;
            font-size: 14px;
        }

        .payment-step::before {
            width: 32px;
            height: 32px;
            font-size: 12px;
        }

        .payment-note {
            font-size: 13px;
        }

    .payment-submit-area {
            margin-top: 24px;
            padding-top: 20px;
        }

        .payment-submit {
            min-height: 58px;
            border-radius: 13px;
            font-size: 16px;
        }

        .payment-secure-note {
            align-items: flex-start;
            font-size: 12px;
            line-height: 1.55;
        }

        .payment-summary-header {
            padding: 20px 20px 18px;
        }

        .payment-summary-body {
            padding: 20px;
        }

        .payment-summary-count {
            font-size: 13px;
        }

        .payment-item {
            grid-template-columns: 64px minmax(0, 1fr);
            gap: 12px;
        }

        .payment-item-image {
            width: 64px;
            height: 64px;
            border-radius: 12px;
        }

        .payment-item-name {
            font-size: 14px;
        }

        .payment-item-meta,
        .payment-item-price {
            font-size: 13px;
        }

        .payment-total {
            align-items: flex-start;
            flex-direction: column;
            gap: 5px;
        }

        .payment-total-value {
            font-size: 23px;
            text-align: left;
        }

        .payment-back {
            min-height: 52px;
            font-size: 14px;
        }

        .payment-modal-overlay {
            padding: 14px;
        }

        .payment-modal {
            padding: 24px 20px;
            border-radius: 22px;
        }

        .payment-modal-title {
            font-size: 27px;
        }

        .payment-modal-text {
            font-size: 14px;
        }
    }

    @media (max-width: 420px) {
        .payment-method-options {
            grid-template-columns: 1fr;
        }

        .payment-method-card {
            min-height: 104px;
        }

        .payment-container {
            width: calc(100% - 20px);
        }

        .payment-page {
            padding-top: 88px;
        }

        .payment-title {
            font-size: clamp(36px, 12vw, 46px);
        }

        .payment-panel-header,
        .payment-panel-body {
            padding: 18px;
        }

        .payment-input {
            min-height: 54px;
            font-size: 16px;
        }

        .payment-method-card {
            padding: 17px;
        }

        .payment-guide {
            padding: 16px;
        }

        .payment-item {
            grid-template-columns: 58px minmax(0, 1fr);
        }

        .payment-item-image {
            width: 58px;
            height: 58px;
        }

        .payment-modal-actions {
            grid-template-columns: 1fr;
        }

        .payment-modal-button {
            width: 100%;
        }
    }

    @media (max-width: 360px) {
        .payment-container {
            width: calc(100% - 16px);
        }

        .payment-page {
            padding-top: 84px;
        }

        .payment-title {
            font-size: 34px;
        }

        .payment-description {
            font-size: 14px;
        }

        .payment-panel-header,
        .payment-panel-body {
            padding: 16px;
        }

        .payment-input {
            padding: 0 14px;
        }

        .payment-item {
            grid-template-columns: 54px minmax(0, 1fr);
            gap: 10px;
        }

        .payment-item-image {
            width: 54px;
            height: 54px;
        }

        .payment-item-name {
            font-size: 13px;
        }

        .payment-item-meta,
        .payment-item-price {
            font-size: 12px;
        }
    }

    .payment-page button,
    .payment-page a,
    .payment-page input {
        -webkit-tap-highlight-color: transparent;
    }

    .payment-page p,
    .payment-page li,
    .payment-page label,
    .payment-page input,
    .payment-page button {
        overflow-wrap: anywhere;
    }

    .payment-page button,
    .payment-page a {
        touch-action: manipulation;
    }

    @media (min-width: 1600px) {
        .payment-container {
            width: min(1400px, calc(100% - 120px));
        }

        .payment-description,
        .payment-panel-subtitle,
        .payment-guide-description {
            font-size: 18px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .payment-page *,
        .payment-page *::before,
        .payment-page *::after,
        .payment-modal-overlay *,
        .payment-modal-overlay *::before,
        .payment-modal-overlay *::after {
            scroll-behavior: auto !important;
            animation-duration: .01ms !important;
            transition-duration: .01ms !important;
            animation-iteration-count: 1 !important;
        }
    }
</style>

@php
    $cart = $cart ?? session('keranjang', []);

    if ($cart instanceof \Illuminate\Support\Collection) {
        $cart = $cart->toArray();
    }

    $cart = is_array($cart) ? $cart : [];
    $normalizedCart = [];
    $cartQty = 0;
    $cartTotal = 0;

    foreach ($cart as $cartKey => $cartItem) {
        $cartItem = is_array($cartItem) ? $cartItem : (array) $cartItem;
        $qty = max(1, min(99, (int) ($cartItem['qty'] ?? $cartItem['quantity'] ?? 1)));
        $price = max(0, (int) ($cartItem['harga'] ?? $cartItem['price'] ?? 0));
        $cartItem['qty'] = $qty;
        $cartItem['harga'] = $price;
        $cartItem['subtotal'] = $qty * $price;
        $normalizedCart[$cartKey] = $cartItem;
        $cartQty += $qty;
        $cartTotal += $cartItem['subtotal'];
    }

    $cart = $normalizedCart;
@endphp

<div class="payment-page">
    <div class="payment-container">

        <div class="payment-heading">

            <h1 class="payment-title">
                Pembayaran
            </h1>

            <p class="payment-description">
                Lengkapi data pemesan, lalu pilih pembayaran Cash di kasir atau QRIS
                melalui halaman pembayaran Midtrans.
            </p>
        </div>

        <div class="payment-grid">

            <div class="payment-panel">
                <div class="payment-panel-header">
                    <h2 class="payment-panel-title">
                        Data Pemesan
                    </h2>

                    <p class="payment-panel-subtitle">
                        Gunakan nomor WhatsApp yang aktif agar pesanan lebih mudah
                        ditemukan dan digunakan untuk komunikasi pesanan.
                    </p>
                </div>

                <div class="payment-panel-body">

                    @if(session('error'))
                        <div class="payment-alert" role="alert" aria-live="assertive">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="payment-alert" role="alert" aria-live="assertive">
                            <strong>Periksa kembali data kamu.</strong>
                            <div style="margin-top:5px;">
                                {{ $errors->first() }}
                            </div>
                        </div>
                    @endif

                    <form
                        action="{{ route('pesanan.store') }}"
                        method="POST"
                        id="paymentForm"
                    >
                        @csrf

                        <div class="payment-form-group">
                            <label for="nama_pelanggan" class="payment-label">
                                Nama <span>*</span>
                            </label>

                            <input
                                type="text"
                                id="nama_pelanggan"
                                name="nama_pelanggan"
                                class="payment-input"
                                value="{{ old('nama_pelanggan') }}"
                                placeholder="Masukkan nama kamu"
                                maxlength="255"
                                required
                                autocomplete="name"
                            >

                            @error('nama_pelanggan')
                                <div class="payment-error">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="payment-form-group">
                            <label for="no_wa" class="payment-label">
                                Nomor WhatsApp <span>*</span>
                            </label>

                            <input
                                type="tel"
                                id="no_wa"
                                name="no_wa"
                                class="payment-input"
                                value="{{ old('no_wa') }}"
                                placeholder="Contoh: 081234567890"
                                maxlength="20"
                                inputmode="tel"
                                required
                                autocomplete="tel"
                            >

                            <div class="payment-hint">
                                Nomor ini digunakan untuk memudahkan kasir menemukan pesanan
                                dan menghubungi kamu jika diperlukan.
                            </div>

                            @error('no_wa')
                                <div class="payment-error">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="payment-method-heading">
                            Metode Pembayaran
                        </div>

                        <input type="hidden" name="metode_pembayaran" id="paymentMethod" value="{{ old('metode_pembayaran', 'Cash') }}">

                        <div class="payment-method-options" role="radiogroup" aria-label="Pilih metode pembayaran">
                            <button type="button" class="payment-method-card {{ old('metode_pembayaran', 'Cash') === 'Cash' ? 'is-selected' : '' }}" data-payment-method="Cash" role="radio" aria-checked="{{ old('metode_pembayaran', 'Cash') === 'Cash' ? 'true' : 'false' }}" tabindex="{{ old('metode_pembayaran', 'Cash') === 'Cash' ? '0' : '-1' }}">
                                <span class="payment-method-check" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="m5 12 4 4L19 6"></path></svg></span>
                                <span class="payment-method-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><rect x="3" y="6" width="18" height="13" rx="2"></rect><path d="M3 10h18"></path><path d="M7 15h4"></path></svg></span>
                                <span class="payment-method-name">Cash</span>
                                <span class="payment-method-description">Bayar langsung di kasir Noyo Gimbal setelah pesanan dibuat.</span>
                            </button>

                            <button type="button" class="payment-method-card {{ old('metode_pembayaran') === 'QRIS' ? 'is-selected' : '' }}" data-payment-method="QRIS" role="radio" aria-checked="{{ old('metode_pembayaran') === 'QRIS' ? 'true' : 'false' }}" tabindex="{{ old('metode_pembayaran') === 'QRIS' ? '0' : '-1' }}">
                                <span class="payment-method-check" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="m5 12 4 4L19 6"></path></svg></span>
                                <span class="payment-method-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><rect x="3" y="3" width="7" height="7" rx="1"></rect><rect x="14" y="3" width="7" height="7" rx="1"></rect><rect x="3" y="14" width="7" height="7" rx="1"></rect><path d="M14 14h3v3h-3zM20 14v2M17 20h4M20 18v3"></path></svg></span>
                                <span class="payment-method-name">QRIS</span>
                                <span class="payment-method-description">Bayar online dengan memindai kode QR melalui halaman pembayaran Midtrans.</span>
                            </button>
                        </div>

                        <div class="payment-guide" id="cashGuide" {{ old('metode_pembayaran', 'Cash') === 'QRIS' ? 'hidden' : '' }}>
                            <div class="payment-guide-head">
                                <div class="payment-guide-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M20 11a8 8 0 1 1-2.34-5.66"></path><path d="M20 4v7h-7"></path></svg>
                                </div>
                                <div>
                                    <h3 class="payment-guide-title">Panduan Pembayaran Cash</h3>
                                    <p class="payment-guide-description">Pembayaran dilakukan langsung kepada kasir setelah pesanan dibuat.</p>
                                </div>
                            </div>
                            <ol class="payment-step-list">
                                <li class="payment-step">Klik tombol <strong>Buat Pesanan</strong> setelah data nama dan nomor WhatsApp sudah benar.</li>
                                <li class="payment-step">Pesanan akan tercatat dengan status <strong>Menunggu Pembayaran</strong>.</li>
                                <li class="payment-step">Datang ke kasir Noyo Gimbal untuk melakukan pembayaran secara tunai.</li>
                                <li class="payment-step">Sebutkan <strong>nama</strong> atau <strong>nomor WhatsApp</strong> yang dimasukkan saat checkout.</li>
                                <li class="payment-step">Kasir akan mencari dan mengecek pesanan berdasarkan data tersebut.</li>
                                <li class="payment-step">Setelah pembayaran diterima dan diverifikasi, pesanan dapat diproses.</li>
                            </ol>
                            <div class="payment-note"><strong>Catatan:</strong> Pastikan nama dan nomor WhatsApp sudah benar agar pesanan mudah ditemukan oleh kasir.</div>
                        </div>

                        <div class="payment-guide" id="qrisGuide" {{ old('metode_pembayaran', 'Cash') !== 'QRIS' ? 'hidden' : '' }}>
                            <div class="payment-guide-head">
                                <div class="payment-guide-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><rect x="3" y="3" width="7" height="7" rx="1"></rect><rect x="14" y="3" width="7" height="7" rx="1"></rect><rect x="3" y="14" width="7" height="7" rx="1"></rect><path d="M14 14h3v3h-3zM20 14v2M17 20h4M20 18v3"></path></svg>
                                </div>
                                <div>
                                    <h3 class="payment-guide-title">Panduan Pembayaran QRIS</h3>
                                    <p class="payment-guide-description">Setelah pesanan dibuat, kamu akan diarahkan ke halaman Midtrans. Kode QRIS ditampilkan di halaman pembayaran tersebut.</p>
                                </div>
                            </div>
                            <ol class="payment-step-list">
                                <li class="payment-step">Pastikan nama dan nomor WhatsApp sudah benar, lalu klik <strong>Lanjutkan Pembayaran QRIS</strong>.</li>
                                <li class="payment-step">Setelah konfirmasi, sistem membuat transaksi dan membuka halaman pembayaran Midtrans.</li>
                                <li class="payment-step">Ikuti instruksi Midtrans dan pindai kode QR yang ditampilkan menggunakan aplikasi pembayaran yang mendukung QRIS.</li>
                                <li class="payment-step">Selesaikan pembayaran dan tunggu konfirmasi dari penyedia pembayaran.</li>
                            </ol>
                            <div class="payment-note"><strong>Catatan:</strong> Kode QR tidak dibuat oleh halaman checkout ini; kode ditampilkan oleh Midtrans setelah transaksi berhasil dibuat. Jangan tandai pesanan sebagai lunas sebelum status pembayaran dikonfirmasi.</div>
                        </div>

                        <div class="payment-submit-area">
                            <button
                                type="submit"
                                class="payment-submit"
                                id="paymentSubmit"
                            >
                                Buat Pesanan
                            </button>

                            <div class="payment-secure-note">
                                <svg width="13" height="13" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor"
                                     stroke-width="1.7">
                                    <rect x="5" y="10" width="14" height="10" rx="2"></rect>
                                    <path d="M8 10V7a4 4 0 0 1 8 0v3"></path>
                                </svg>

                                Data pemesan digunakan untuk kebutuhan pesanan
                                dan komunikasi melalui WhatsApp.
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <aside class="payment-panel payment-summary">

                <div class="payment-summary-header">
                    <h2 class="payment-summary-title">
                        Ringkasan Pesanan
                    </h2>

                    <div class="payment-summary-count">
                        {{ count($cart) }} jenis produk · {{ $cartQty }} item
                    </div>
                </div>

                <div class="payment-summary-body">

                    <div class="payment-item-list">
                        @foreach($cart as $item)
                            @php
                                $item = is_array($item) ? $item : (array) $item;
                                $itemNama = $item['nama'] ?? $item['name'] ?? $item['nama_menu'] ?? $item['nama_wahana'] ?? $item['nama_paket'] ?? 'Produk';
                                $itemQty = max(1, min(99, (int) ($item['qty'] ?? $item['quantity'] ?? 1)));
                                $itemHarga = max(0, (int) ($item['harga'] ?? $item['price'] ?? 0));
                                $itemSubtotal = $itemHarga * $itemQty;
                                $itemGambar = $item['gambar'] ?? $item['gambar_url'] ?? $item['image'] ?? null;

                                if ($itemGambar && !filter_var($itemGambar, FILTER_VALIDATE_URL)) {
                                    $itemGambar = asset(ltrim($itemGambar, '/'));
                                }
                            @endphp

                            <div class="payment-item">

                                <div class="payment-item-image">
                                    @if($itemGambar)
                                        <img
                                            src="{{ $itemGambar }}"
                                            alt="{{ $itemNama }}"
                                            loading="lazy"
                                            onerror="this.onerror=null;this.style.display='none';this.nextElementSibling.hidden=false;"
                                        >
                                        <div class="payment-image-fallback" hidden>
                                            <svg width="18" height="18"
                                                 viewBox="0 0 24 24"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 stroke-width="1.5">
                                                <rect x="4" y="4" width="16"
                                                      height="16" rx="2"></rect>
                                                <circle cx="9" cy="9" r="1.5"></circle>
                                                <path d="m4 17 4-4 3 3 3-4 6 6"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <div>
                                    <div class="payment-item-name">
                                        {{ $itemNama }}
                                    </div>

                                    <div class="payment-item-meta">
                                        {{ $itemQty }} ×
                                        Rp {{ number_format($itemHarga, 0, ',', '.') }}
                                    </div>

                                    <div class="payment-item-price">
                                        Rp {{ number_format($itemSubtotal, 0, ',', '.') }}
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>

                    <div class="payment-total">
                        <div class="payment-total-label">
                            Total Pembayaran
                        </div>

                        <div class="payment-total-value">
                            Rp {{ number_format($cartTotal, 0, ',', '.') }}
                        </div>
                    </div>

                    <a
                        href="{{ route('pesanan.keranjang') }}"
                        class="payment-back"
                    >
                        <svg width="14" height="14" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor"
                             stroke-width="1.7">
                            <path d="M19 12H5"></path>
                            <path d="m12 19-7-7 7-7"></path>
                        </svg>

                        Kembali ke Keranjang
                    </a>
                </div>
            </aside>

        </div>
    </div>
</div>

<div
    id="paymentConfirmModal"
    class="payment-modal-overlay"
    aria-hidden="true"
    role="presentation"
>
    <div class="payment-modal" role="dialog" aria-modal="true" aria-labelledby="paymentModalTitle" aria-describedby="paymentModalDescription">

        <div class="payment-modal-icon">
            <svg width="21" height="21" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor"
                 stroke-width="1.7">
                <path d="M12 3 2.8 20h18.4L12 3Z"></path>
                <path d="M12 9v5"></path>
                <path d="M12 17h.01"></path>
            </svg>
        </div>

        <h2 class="payment-modal-title" id="paymentModalTitle">
            Konfirmasi Pesanan
        </h2>

        <p class="payment-modal-text" id="paymentModalDescription">
            Pastikan nama dan nomor WhatsApp kamu sudah benar.
            Instruksi pembayaran akan mengikuti metode yang kamu pilih.
        </p>

        <div class="payment-modal-actions">
            <button
                type="button"
                class="payment-modal-button payment-modal-cancel"
                id="paymentModalCancel"
            >
                Periksa Lagi
            </button>

            <button
                type="button"
                class="payment-modal-button payment-modal-confirm"
                id="paymentModalConfirm"
            >
                Konfirmasi dan Lanjutkan
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('paymentForm');
    const modal = document.getElementById('paymentConfirmModal');
    const cancelButton = document.getElementById('paymentModalCancel');
    const confirmButton = document.getElementById('paymentModalConfirm');
    const submitButton = document.getElementById('paymentSubmit');
    const methodInput = document.getElementById('paymentMethod');
    const methodCards = document.querySelectorAll('[data-payment-method]');
    const cashGuide = document.getElementById('cashGuide');
    const qrisGuide = document.getElementById('qrisGuide');

    function setPaymentMethod(method) {
        if (!methodInput || !['Cash', 'QRIS'].includes(method)) return;
        methodInput.value = method;
        methodCards.forEach(function (card) {
            const selected = card.dataset.paymentMethod === method;
            card.classList.toggle('is-selected', selected);
            card.setAttribute('aria-checked', selected ? 'true' : 'false');
            card.tabIndex = selected ? 0 : -1;
        });
        if (cashGuide) cashGuide.hidden = method !== 'Cash';
        if (qrisGuide) qrisGuide.hidden = method !== 'QRIS';
        if (submitButton) submitButton.textContent = method === 'QRIS' ? 'Lanjutkan Pembayaran QRIS' : 'Buat Pesanan';
    }

    methodCards.forEach(function (card) {
        card.addEventListener('click', function () {
            setPaymentMethod(card.dataset.paymentMethod);
        });
        card.addEventListener('keydown', function (event) {
            if (['ArrowRight', 'ArrowDown', 'ArrowLeft', 'ArrowUp', 'Home', 'End'].includes(event.key)) {
                event.preventDefault();
                const method = event.key === 'Home' ? 'Cash' : event.key === 'End' ? 'QRIS' : card.dataset.paymentMethod === 'Cash' ? 'QRIS' : 'Cash';
                setPaymentMethod(method);
                const target = document.querySelector('[data-payment-method="' + method + '"]');
                if (target) target.focus();
            }
        });
    });

    setPaymentMethod(methodInput && ['Cash', 'QRIS'].includes(methodInput.value) ? methodInput.value : 'Cash');

    if (!form || !modal || !cancelButton || !confirmButton) {
        return;
    }

    let previousFocus = null;

    function openModal() {
        previousFocus = document.activeElement;
        modal.classList.add('active');
        modal.setAttribute('aria-hidden', 'false');
        document.body.dataset.paymentPreviousOverflow = document.body.style.overflow;
        document.body.style.overflow = 'hidden';
        cancelButton.focus();
    }

    function closeModal() {
        modal.classList.remove('active');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = document.body.dataset.paymentPreviousOverflow || '';
        delete document.body.dataset.paymentPreviousOverflow;

        if (previousFocus && typeof previousFocus.focus === 'function') {
            previousFocus.focus();
        }
    }

    form.addEventListener('submit', function (event) {
        if (form.dataset.submitting === 'true') {
            event.preventDefault();
            return;
        }

        if (form.dataset.confirmed === 'true') {
            event.preventDefault();
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.textContent = 'Memproses Pesanan...';
            }
            return;
        }

        event.preventDefault();

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const waInput = document.getElementById('no_wa');

        if (waInput) {
            const digits = waInput.value.replace(/[^0-9]/g, '');

            if (digits.length < 10 || digits.length > 15) {
                waInput.setCustomValidity(
                    'Nomor WhatsApp harus berisi 10-15 digit.'
                );
                waInput.reportValidity();
                waInput.setCustomValidity('');
                return;
            }
        }

        const modalText = document.getElementById('paymentModalDescription');
        if (modalText) {
            modalText.textContent = methodInput && methodInput.value === 'QRIS'
                ? 'Pesanan akan dibuat terlebih dahulu, lalu kamu diarahkan ke halaman Midtrans untuk menampilkan dan membayar kode QRIS.'
                : 'Pastikan nama dan nomor WhatsApp sudah benar. Pembayaran dilakukan langsung di kasir Noyo Gimbal.';
        }
        openModal();
    });

    cancelButton.addEventListener('click', function () {
        closeModal();
    });

    confirmButton.addEventListener('click', function () {
        if (form.dataset.confirmed === 'true') {
            return;
        }

        if (!form.checkValidity()) {
            closeModal();
            form.reportValidity();
            return;
        }

        form.dataset.confirmed = 'true';
        form.dataset.submitting = 'true';
        closeModal();

        if (submitButton) {
            submitButton.disabled = true;
            submitButton.textContent = 'Memproses Pesanan...';
        }

        HTMLFormElement.prototype.submit.call(form);
    });

    modal.addEventListener('click', function (event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    modal.addEventListener('keydown', function (event) {
        if (event.key !== 'Tab') return;

        const focusable = Array.from(modal.querySelectorAll(
            'button:not([disabled]), [href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])'
        )).filter(function (element) {
            return element.offsetParent !== null;
        });

        if (!focusable.length) return;

        const first = focusable[0];
        const last = focusable[focusable.length - 1];

        if (event.shiftKey && document.activeElement === first) {
            event.preventDefault();
            last.focus();
        } else if (!event.shiftKey && document.activeElement === last) {
            event.preventDefault();
            first.focus();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && modal.classList.contains('active')) {
            closeModal();
        }
    });
});
</script>

@endsection
