{{-- resources/views/kasir/pesanan-menu/index.blade.php --}}

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Pesanan Menu | Kasir</title>

    {{-- =========================================================
         FONT
    ========================================================== --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >


    <style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

:root {
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
    --border-soft: rgba(255,255,255,.09);
    --border-gold: rgba(226,201,151,.22);
    --shadow-soft: 0 18px 48px rgba(0,0,0,.28);
    --shadow-hover: 0 22px 55px rgba(0,0,0,.38);
    --radius-lg: 24px;
    --radius-md: 16px;
    --radius-sm: 12px;
    --transition: .22s ease;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html {
    scroll-behavior: smooth;
    -webkit-text-size-adjust: 100%;
}

body {
    min-height: 100vh;
    overflow-x: hidden;
    background:
        radial-gradient(ellipse at top right, rgba(226,201,151,.07), transparent 35%),
        var(--bg-primary);
    color: var(--text-primary);
    font-family: 'Inter', sans-serif;
    font-size: 15px;
    line-height: 1.65;
}

a {
    color: inherit;
    text-decoration: none;
}

button,
input,
select {
    font: inherit;
}

button,
a,
select,
input {
    -webkit-tap-highlight-color: transparent;
}

button,
select {
    cursor: pointer;
}

button:focus-visible,
a:focus-visible,
input:focus-visible,
select:focus-visible {
    outline: 3px solid var(--accent);
    outline-offset: 3px;
}

.page-wrapper {
    min-height: 100vh;
}

.main-content {
    min-height: 100vh;
    margin-left: 255px;
    padding: 36px clamp(20px, 3vw, 48px) 48px;
    transition: margin-left var(--transition), padding var(--transition);
}

.content-container {
    width: 100%;
    max-width: 1500px;
    margin: 0 auto;
}

.page-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 24px;
    margin-bottom: 30px;
}

.header-left {
    min-width: 0;
}

.breadcrumb {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 9px;
    margin-bottom: 12px;
    color: var(--text-muted);
    font-size: 13px;
    font-weight: 500;
}

.breadcrumb-current {
    color: var(--accent);
}

.breadcrumb-separator {
    color: var(--text-dim);
}

.page-title {
    color: var(--text-primary);
    font-size: clamp(28px, 2.3vw, 36px);
    font-weight: 800;
    line-height: 1.2;
    letter-spacing: -.8px;
}

.page-description {
    max-width: 680px;
    margin-top: 10px;
    color: var(--text-muted);
    font-size: 15px;
    line-height: 1.7;
}

.header-info {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-shrink: 0;
}

.date-card {
    display: flex;
    align-items: center;
    gap: 11px;
    min-height: 48px;
    padding: 8px 15px;
    border: 1px solid var(--border-gold);
    border-radius: var(--radius-sm);
    background: var(--bg-card);
    color: var(--text-secondary);
    font-size: 14px;
    font-weight: 600;
}

.date-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 34px;
    height: 34px;
    border: 1px solid var(--border-gold);
    border-radius: 10px;
    background: rgba(226,201,151,.1);
    color: var(--accent);
    font-size: 17px;
}

.summary-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 18px;
    margin-bottom: 24px;
}

.summary-card {
    min-width: 0;
    padding: 22px;
    border: 1px solid var(--border-gold);
    border-radius: var(--radius-md);
    background: linear-gradient(145deg, rgba(255,255,255,.035), transparent 70%), var(--bg-card);
    box-shadow: var(--shadow-soft);
    transition: transform var(--transition), border-color var(--transition), box-shadow var(--transition);
}

.summary-card:hover {
    transform: translateY(-3px);
    border-color: rgba(226,201,151,.4);
    box-shadow: var(--shadow-hover);
}

.summary-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 17px;
}

.summary-label {
    color: var(--text-muted);
    font-size: 13px;
    font-weight: 700;
    line-height: 1.5;
    letter-spacing: .35px;
    text-transform: uppercase;
}

.summary-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 42px;
    width: 42px;
    height: 42px;
    border: 1px solid var(--border-gold);
    border-radius: 12px;
    background: rgba(226,201,151,.09);
    color: var(--accent);
    font-size: 20px;
}

.summary-number {
    color: var(--text-primary);
    font-size: clamp(27px, 2.2vw, 34px);
    font-weight: 800;
    line-height: 1.2;
    overflow-wrap: anywhere;
}

.summary-description {
    margin-top: 9px;
    color: var(--text-muted);
    font-size: 13px;
    line-height: 1.55;
}

.order-card {
    width: 100%;
    overflow: hidden;
    border: 1px solid var(--border-gold);
    border-radius: var(--radius-lg);
    background: var(--bg-card);
    box-shadow: var(--shadow-soft);
}

.order-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    padding: 25px 26px;
    border-bottom: 1px solid var(--border-soft);
}

.card-heading {
    min-width: 0;
}

.card-title {
    color: var(--text-primary);
    font-size: 20px;
    font-weight: 800;
    line-height: 1.4;
}

.card-subtitle {
    margin-top: 6px;
    color: var(--text-muted);
    font-size: 14px;
    line-height: 1.6;
}

.filter-area {
    padding: 20px 26px;
    border-bottom: 1px solid var(--border-soft);
    background: rgba(255,255,255,.018);
}

.filter-row {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    width: 100%;
}

.search-wrapper {
    position: relative;
    flex: 1 1 280px;
    min-width: 0;
}

.search-icon {
    position: absolute;
    top: 50%;
    left: 15px;
    transform: translateY(-50%);
    color: var(--text-muted);
    font-size: 20px;
    pointer-events: none;
}

.search-input,
.filter-select {
    width: 100%;
    min-height: 48px;
    border: 1px solid var(--border-soft);
    border-radius: 12px;
    outline: none;
    background: var(--bg-secondary);
    color: var(--text-primary);
    font-size: 15px;
    transition: border-color var(--transition), box-shadow var(--transition), background var(--transition);
}

.search-input {
    padding: 10px 14px 10px 44px;
}

.search-input::placeholder {
    color: var(--text-dim);
    opacity: 1;
}

.search-input:hover,
.filter-select:hover {
    border-color: var(--border-gold);
}

.search-input:focus,
.filter-select:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px rgba(226,201,151,.13);
}

.filter-select {
    flex: 0 1 210px;
    padding: 10px 14px;
}

.filter-select option {
    background: var(--bg-secondary);
    color: var(--text-primary);
}

.filter-button,
.reset-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 48px;
    padding: 10px 20px;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 700;
    transition: transform var(--transition), background var(--transition), border-color var(--transition), color var(--transition);
}

.filter-button {
    border: 1px solid var(--accent);
    background: linear-gradient(135deg, var(--accent), var(--accent-hover));
    color: #17130c;
}

.filter-button:hover {
    transform: translateY(-2px);
    background: linear-gradient(135deg, #f0ddb5, var(--accent));
}

.reset-button {
    border: 1px solid var(--border-gold);
    background: rgba(226,201,151,.07);
    color: var(--text-secondary);
}

.reset-button:hover {
    border-color: var(--accent);
    color: var(--accent);
}

.table-wrapper {
    width: 100%;
    overflow-x: auto;
    scrollbar-color: var(--accent-dark) var(--bg-secondary);
    scrollbar-width: thin;
}

.order-table {
    width: 100%;
    min-width: 900px;
    border-collapse: collapse;
}

.order-table thead {
    background: #191714;
}

.order-table th {
    padding: 17px 20px;
    border-bottom: 1px solid var(--border-gold);
    color: var(--text-muted);
    font-size: 12px;
    font-weight: 800;
    text-align: left;
    text-transform: uppercase;
    letter-spacing: .5px;
    white-space: nowrap;
}

.order-table td {
    padding: 19px 20px;
    border-bottom: 1px solid var(--border-soft);
    color: var(--text-secondary);
    font-size: 14px;
    vertical-align: middle;
}

.order-table tbody tr {
    transition: background var(--transition);
}

.order-table tbody tr:hover {
    background: rgba(226,201,151,.045);
}

.order-table tbody tr:last-child td {
    border-bottom: none;
}

.order-code {
    color: var(--accent);
    font-size: 14px;
    font-weight: 800;
    overflow-wrap: anywhere;
}

.order-date {
    margin-top: 5px;
    color: var(--text-muted);
    font-size: 12px;
}

.customer-wrapper {
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 180px;
}

.customer-avatar {
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 42px;
    width: 42px;
    height: 42px;
    border: 1px solid var(--border-gold);
    border-radius: 12px;
    background: rgba(226,201,151,.1);
    color: var(--accent);
    font-size: 14px;
    font-weight: 800;
    text-transform: uppercase;
}

.customer-name {
    color: var(--text-primary);
    font-size: 14px;
    font-weight: 700;
    overflow-wrap: anywhere;
}

.customer-phone {
    margin-top: 4px;
    color: var(--text-muted);
    font-size: 13px;
    overflow-wrap: anywhere;
}

.payment-badge,
.status-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    min-height: 34px;
    padding: 5px 11px;
    border: 1px solid var(--border-soft);
    border-radius: 10px;
    font-size: 13px;
    font-weight: 700;
    line-height: 1.35;
}

.payment-badge {
    background: rgba(255,255,255,.04);
    color: var(--text-secondary);
}

.payment-badge.qris {
    border-color: rgba(226,201,151,.28);
    background: rgba(226,201,151,.1);
    color: var(--accent);
}

.payment-badge.cash {
    background: rgba(255,255,255,.05);
    color: var(--text-secondary);
}

.total-price {
    color: var(--text-primary);
    font-size: 15px;
    font-weight: 800;
    white-space: nowrap;
}

.total-label {
    margin-top: 4px;
    color: var(--text-muted);
    font-size: 12px;
}

.status-badge {
    white-space: normal;
}

.status-dot {
    flex: 0 0 8px;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: currentColor;
}

.status-waiting-payment {
    border-color: rgba(226,201,151,.25);
    background: rgba(226,201,151,.1);
    color: var(--accent);
}

.status-paid {
    border-color: rgba(120,190,140,.25);
    background: rgba(80,150,100,.12);
    color: #a9dfb4;
}

.status-waiting-pickup {
    border-color: rgba(160,180,220,.2);
    background: rgba(100,130,180,.12);
    color: #c2d2f2;
}

.status-completed {
    border-color: rgba(120,190,140,.22);
    background: rgba(80,150,100,.12);
    color: #a9dfb4;
}

.status-cancelled {
    border-color: rgba(220,130,130,.22);
    background: rgba(170,70,70,.12);
    color: #e9aaaa;
}

.action-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 44px;
    padding: 9px 15px;
    border: 1px solid var(--border-gold);
    border-radius: 11px;
    background: rgba(226,201,151,.08);
    color: var(--accent);
    font-size: 14px;
    font-weight: 700;
    white-space: nowrap;
    transition: transform var(--transition), background var(--transition), border-color var(--transition);
}

.action-button:hover {
    transform: translateY(-1px);
    border-color: var(--accent);
    background: rgba(226,201,151,.15);
}

.empty-state {
    padding: clamp(45px, 7vw, 80px) 24px;
    text-align: center;
}

.empty-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 68px;
    height: 68px;
    margin: 0 auto 18px;
    border: 1px solid var(--border-gold);
    border-radius: 20px;
    background: rgba(226,201,151,.08);
    color: var(--accent);
    font-size: 28px;
}

.empty-title {
    color: var(--text-primary);
    font-size: 19px;
    font-weight: 800;
}

.empty-description {
    max-width: 460px;
    margin: 9px auto 0;
    color: var(--text-muted);
    font-size: 15px;
    line-height: 1.7;
}

.table-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
    min-height: 76px;
    padding: 18px 26px;
    border-top: 1px solid var(--border-soft);
}

.pagination-info {
    color: var(--text-muted);
    font-size: 14px;
    line-height: 1.7;
}

.pagination-info strong {
    color: var(--text-secondary);
}

.pagination {
    display: flex;
    align-items: center;
    gap: 7px;
    flex-wrap: wrap;
}

.pagination nav {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 7px;
}

.pagination a,
.pagination span {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
    min-height: 40px;
    padding: 7px 12px;
    border: 1px solid var(--border-soft);
    border-radius: 10px;
    background: var(--bg-secondary);
    color: var(--text-secondary);
    font-size: 14px;
}

.pagination a:hover {
    border-color: var(--accent);
    color: var(--accent);
}

.pagination [aria-current="page"] span {
    border-color: var(--accent);
    background: var(--accent);
    color: #17130c;
    font-weight: 800;
}

.detail-modal,
.verification-modal {
    position: fixed;
    inset: 0;
    z-index: 9999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px;
    background: rgba(0,0,0,.74);
    backdrop-filter: blur(8px);
}

.detail-modal.show,
.verification-modal.show {
    display: flex;
}

.detail-modal-card,
.verification-modal-card {
    width: min(700px, 100%);
    max-height: min(88vh, 820px);
    overflow: hidden;
    border: 1px solid var(--border-gold);
    border-radius: 22px;
    background: var(--bg-secondary);
    box-shadow: var(--shadow-hover);
    animation: modalIn .2s ease-out;
}

@keyframes modalIn {
    from { opacity: 0; transform: translateY(10px) scale(.985); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}

.detail-modal-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 18px;
    padding: 24px 26px;
    border-bottom: 1px solid var(--border-soft);
    background: rgba(226,201,151,.035);
}

.detail-modal-eyebrow {
    margin-bottom: 6px;
    color: var(--accent);
    font-size: 12px;
    font-weight: 800;
    letter-spacing: .8px;
    text-transform: uppercase;
}

.detail-modal-title {
    color: var(--text-primary);
    font-size: 22px;
    font-weight: 800;
    line-height: 1.35;
    overflow-wrap: anywhere;
}

.detail-modal-code {
    margin-top: 6px;
    color: var(--text-muted);
    font-size: 14px;
    overflow-wrap: anywhere;
}

.detail-modal-close {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 44px;
    width: 44px;
    height: 44px;
    border: 1px solid var(--border-soft);
    border-radius: 12px;
    background: var(--bg-soft);
    color: var(--text-secondary);
    font-size: 26px;
    line-height: 1;
    cursor: pointer;
}

.detail-modal-close:hover {
    border-color: var(--accent);
    color: var(--accent);
}

.detail-modal-body {
    max-height: calc(min(88vh, 820px) - 165px);
    overflow-y: auto;
    padding: 24px 26px;
}

.detail-info-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 12px;
    margin-bottom: 25px;
}

.detail-info-item {
    min-width: 0;
    padding: 16px;
    border: 1px solid var(--border-soft);
    border-radius: 13px;
    background: rgba(255,255,255,.025);
}

.detail-info-label {
    margin-bottom: 6px;
    color: var(--text-muted);
    font-size: 12px;
    font-weight: 700;
    letter-spacing: .4px;
    text-transform: uppercase;
}

.detail-info-value {
    color: var(--text-primary);
    font-size: 15px;
    font-weight: 600;
    line-height: 1.6;
    overflow-wrap: anywhere;
}

.detail-section-title {
    margin-bottom: 13px;
    color: var(--text-primary);
    font-size: 17px;
    font-weight: 800;
}

.detail-items {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.detail-item {
    display: grid;
    grid-template-columns: minmax(0, 1fr) auto;
    align-items: center;
    gap: 16px;
    padding: 16px;
    border: 1px solid var(--border-soft);
    border-radius: 13px;
    background: rgba(255,255,255,.025);
}

.detail-item-name {
    color: var(--text-primary);
    font-size: 15px;
    font-weight: 800;
    overflow-wrap: anywhere;
}

.detail-item-meta {
    margin-top: 6px;
    color: var(--text-muted);
    font-size: 14px;
    line-height: 1.6;
}

.detail-item-subtotal {
    align-self: center;
    color: var(--accent);
    font-size: 15px;
    font-weight: 800;
    white-space: nowrap;
}

.detail-empty {
    padding: 22px;
    border: 1px dashed var(--border-gold);
    border-radius: 13px;
    color: var(--text-muted);
    font-size: 14px;
    text-align: center;
}

.detail-total {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-top: 22px;
    padding-top: 20px;
    border-top: 1px solid var(--border-soft);
}

.detail-total-label {
    color: var(--text-secondary);
    font-size: 15px;
    font-weight: 700;
}

.detail-total-value {
    color: var(--accent);
    font-size: 23px;
    font-weight: 800;
    text-align: right;
}

.detail-modal-footer {
    padding: 18px 26px;
    border-top: 1px solid var(--border-soft);
    background: rgba(255,255,255,.02);
}

.detail-modal-actions {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    flex-wrap: wrap;
    gap: 10px;
    width: 100%;
}

.detail-verify-note {
    flex: 1 1 100%;
    margin-right: auto;
    color: var(--text-muted);
    font-size: 13px;
    line-height: 1.6;
}

.detail-close-button,
.detail-verify-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 46px;
    padding: 10px 18px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 800;
    transition: transform var(--transition), background var(--transition), border-color var(--transition);
}

.detail-close-button {
    border: 1px solid var(--border-soft);
    background: var(--bg-soft);
    color: var(--text-secondary);
}

.detail-close-button:hover {
    border-color: var(--border-gold);
    background: #222;
}

.detail-verify-button {
    border: 1px solid var(--accent);
    background: linear-gradient(135deg, var(--accent), var(--accent-hover));
    color: #17130c;
}

.detail-verify-button:hover {
    transform: translateY(-1px);
    background: linear-gradient(135deg, #f0ddb5, var(--accent));
}

.verification-modal {
    z-index: 100000;
}

.verification-modal-card {
    width: min(480px, 100%);
    max-height: 88vh;
}

.verification-modal-header {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    padding: 24px 24px 16px;
}

.verification-modal-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 48px;
    width: 48px;
    height: 48px;
    border: 1px solid var(--border-gold);
    border-radius: 50%;
    background: rgba(226,201,151,.1);
    color: var(--accent);
    font-size: 23px;
    font-weight: 800;
}

.verification-modal-title {
    margin: 2px 0 6px;
    color: var(--text-primary);
    font-size: 19px;
    font-weight: 800;
}

.verification-modal-subtitle {
    color: var(--text-muted);
    font-size: 14px;
    line-height: 1.6;
}

.verification-modal-body {
    padding: 0 24px 22px;
}

.verification-modal-info {
    padding: 16px;
    border: 1px solid var(--border-gold);
    border-radius: 13px;
    background: rgba(226,201,151,.05);
    color: var(--text-secondary);
    font-size: 14px;
    line-height: 1.7;
    overflow-wrap: anywhere;
}

.verification-modal-info strong {
    display: inline-block;
    margin-bottom: 5px;
    color: var(--accent);
    font-size: 15px;
}

.verification-modal-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding: 18px 24px 24px;
    border-top: 1px solid var(--border-soft);
}

.verification-modal-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 46px;
    padding: 10px 18px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 800;
    transition: transform var(--transition), background var(--transition), border-color var(--transition);
}

.verification-modal-cancel {
    border: 1px solid var(--border-soft);
    background: var(--bg-soft);
    color: var(--text-secondary);
}

.verification-modal-cancel:hover {
    border-color: var(--border-gold);
}

.verification-modal-confirm {
    border: 1px solid var(--accent);
    background: var(--accent);
    color: #17130c;
}

.verification-modal-confirm:hover {
    transform: translateY(-1px);
    background: var(--accent-hover);
}

@media (min-width: 1600px) {
    .main-content {
        padding-right: 54px;
        padding-left: 54px;
    }

    .summary-grid {
        gap: 22px;
    }

    .summary-card {
        padding: 26px;
    }
}

@media (max-width: 1200px) {
    .main-content {
        padding: 28px 24px 40px;
    }

    .summary-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .page-header {
        gap: 18px;
    }
}

@media (max-width: 900px) {
    .main-content {
        margin-left: 0;
        padding: 28px 22px 38px;
    }

    .page-header {
        flex-direction: column;
        align-items: stretch;
    }

    .header-info,
    .date-card {
        width: 100%;
    }

    .date-card {
        justify-content: flex-start;
    }

    .filter-row {
        align-items: stretch;
    }

    .search-wrapper {
        flex-basis: 100%;
    }

    .filter-select {
        flex: 1 1 200px;
    }
}

@media (max-width: 600px) {
    body {
        font-size: 15px;
    }

    .main-content {
        padding: 22px 14px 30px;
    }

    .page-header {
        margin-bottom: 22px;
    }

    .breadcrumb {
        font-size: 13px;
    }

    .page-title {
        font-size: 28px;
    }

    .page-description {
        font-size: 15px;
    }

    .summary-grid {
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 18px;
    }

    .summary-card {
        padding: 16px;
        border-radius: 15px;
    }

    .summary-top {
        align-items: flex-start;
        gap: 8px;
        margin-bottom: 12px;
    }

    .summary-label {
        font-size: 12px;
    }

    .summary-icon {
        flex-basis: 36px;
        width: 36px;
        height: 36px;
        font-size: 17px;
    }

    .summary-number {
        font-size: 27px;
    }

    .summary-description {
        font-size: 13px;
    }

    .order-card {
        border-radius: 18px;
    }

    .order-card-header {
        padding: 20px 17px;
    }

    .card-title {
        font-size: 19px;
    }

    .card-subtitle {
        font-size: 14px;
    }

    .filter-area {
        padding: 16px;
    }

    .search-input,
    .filter-select {
        min-height: 50px;
        font-size: 15px;
    }

    .filter-select {
        flex-basis: 100%;
    }

    .filter-button,
    .reset-button {
        flex: 1 1 120px;
        min-height: 50px;
    }

    .table-wrapper {
        padding: 0;
    }

    .order-table {
        min-width: 850px;
    }

    .table-footer {
        align-items: stretch;
        flex-direction: column;
        padding: 18px 16px;
    }

    .pagination {
        justify-content: flex-start;
    }

    .detail-modal,
    .verification-modal {
        align-items: flex-end;
        padding: 0;
    }

    .detail-modal-card,
    .verification-modal-card {
        width: 100%;
        max-height: 92dvh;
        border-radius: 22px 22px 0 0;
    }

    .detail-modal-header {
        padding: 20px 18px;
    }

    .detail-modal-title {
        font-size: 20px;
    }

    .detail-modal-body {
        max-height: calc(92dvh - 175px);
        padding: 18px;
    }

    .detail-modal-footer {
        padding: 16px 18px calc(16px + env(safe-area-inset-bottom));
    }

    .detail-info-grid {
        grid-template-columns: 1fr;
        gap: 10px;
    }

    .detail-info-item {
        padding: 14px;
    }

    .detail-item {
        grid-template-columns: 1fr;
        gap: 9px;
        padding: 15px;
    }

    .detail-item-subtotal {
        font-size: 16px;
    }

    .detail-total-value {
        font-size: 21px;
    }

    .detail-modal-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
    }

    .detail-verify-note {
        grid-column: 1 / -1;
    }

    .detail-modal-actions form {
        min-width: 0;
    }

    .detail-modal-actions .detail-verify-button,
    .detail-modal-actions .detail-close-button {
        width: 100%;
        min-height: 48px;
        padding: 10px 12px;
        font-size: 13px;
    }

    .verification-modal-header {
        padding: 22px 20px 16px;
    }

    .verification-modal-body {
        padding: 0 20px 20px;
    }

    .verification-modal-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        padding: 16px 20px calc(20px + env(safe-area-inset-bottom));
    }

    .verification-modal-btn {
        width: 100%;
        min-height: 48px;
        padding: 10px 12px;
    }
}

@media (max-width: 380px) {
    .summary-grid {
        grid-template-columns: 1fr;
    }

    .summary-card {
        padding: 18px;
    }

    .detail-modal-actions {
        grid-template-columns: 1fr;
    }

    .detail-verify-note {
        grid-column: auto;
    }

    .verification-modal-actions {
        grid-template-columns: 1fr;
    }
}

@media (prefers-reduced-motion: reduce) {
    *,
    *::before,
    *::after {
        scroll-behavior: auto !important;
        animation-duration: .01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: .01ms !important;
    }
}
</style>

</head>


<body>

@php
    /*
    |--------------------------------------------------------------------------
    | DATA PESANAN MENU
    |--------------------------------------------------------------------------
    | Halaman ini KHUSUS untuk pesanan Menu biasa.
    |
    | Yang ditampilkan:
    | - Detail pesanan dengan id_menu
    | - id_paket_bundling harus kosong
    |
    | Pesanan Paket Bundling ditangani di halaman:
    | resources/views/kasir/pesanan-bundling/index.blade.php
    |
    | Controller Menu sudah melakukan filtering.
    | Blade tidak melakukan filter ulang agar pagination tetap aman.
    |--------------------------------------------------------------------------
    */
    /*
     * SAFETY FILTER:
     * Halaman ini benar-benar hanya boleh menampilkan PESANAN MENU BIASA.
     *
     * Syarat:
     * 1. Minimal punya satu detail Menu biasa.
     * 2. Tidak boleh punya detail Paket Bundling sama sekali.
     *
     * Filter utama tetap wajib dilakukan di Controller.
     * Filter di Blade ini adalah pengaman tambahan agar Bundling
     * tidak pernah nyempil di tabel walaupun data dari controller
     * masih membawa order Bundling.
     */
    $sourceOrders = $orders ?? ($pesanans ?? collect());

    $isMenuBiasaOnly = function ($pesanan) {
        $details = collect($pesanan->details ?? []);

        $hasBundling = $details->contains(function ($detail) {
            return !empty($detail->id_paket_bundling);
        });

        $hasMenuBiasa = $details->contains(function ($detail) {
            return !empty($detail->id_menu)
                && empty($detail->id_paket_bundling)
                && $detail->menu;
        });

        return !$hasBundling && $hasMenuBiasa;
    };

    /*
     * Jika controller sudah mengirim paginator, jangan mengganti
     * paginator menjadi Collection karena pagination akan rusak.
     * Kita hanya menyaring item pada halaman aktif sebagai safety net.
     */
    if (is_object($sourceOrders) && method_exists($sourceOrders, 'getCollection')) {
        $sourceOrders->setCollection(
            $sourceOrders->getCollection()
                ->filter($isMenuBiasaOnly)
                ->values()
        );

        $pesananList = $sourceOrders;
    } else {
        $pesananList = collect($sourceOrders)
            ->filter($isMenuBiasaOnly)
            ->values();
    }
@endphp


<div class="page-wrapper">


    {{-- =========================================================
         SIDEBAR KASIR
    ========================================================== --}}

    @include('kasir.partials.sidebar')


    {{-- =========================================================
         MAIN CONTENT
    ========================================================== --}}

    <main class="main-content">

        <div class="content-container">


            {{-- =================================================
                 PAGE HEADER
            ================================================== --}}

            <div class="page-header">

                <div class="header-left">

                    <div class="breadcrumb">

                        <span>
                            Kasir
                        </span>

                        <span class="breadcrumb-separator">
                            /
                        </span>

                        <span class="breadcrumb-current">
                            Pesanan Menu
                        </span>

                    </div>


                    <h1 class="page-title">
                        Pesanan Menu
                    </h1>


                    <p class="page-description">
                        Kelola dan verifikasi pesanan menu pelanggan yang masuk.
                    </p>

                </div>


                <div class="header-info">

                    <div class="date-card">

                        <div class="date-icon">
                            ▣
                        </div>

                        <span>
                            {{ now()->translatedFormat('d F Y') }}
                        </span>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 SUMMARY
            ================================================== --}}

            @php

                /*
                |--------------------------------------------------------------------------
                | SUMMARY
                |--------------------------------------------------------------------------
                | Utamakan statistik dari controller.
                |
                | menunggu_pembayaran = Cash yang belum diverifikasi
                | menunggu             = sudah diverifikasi, menunggu pengambilan
                | selesai              = seluruh proses selesai
                | batal                = pesanan dibatalkan
                |--------------------------------------------------------------------------
                */

                $totalPesanan = isset($statistics)
                    ? (int) ($statistics['total'] ?? 0)
                    : (
                        $pesananList && method_exists($pesananList, 'total')
                            ? (int) $pesananList->total()
                            : ($pesananList ? $pesananList->count() : 0)
                    );

                $statsCollection = method_exists($pesananList, 'getCollection')
                    ? $pesananList->getCollection()
                    : collect($pesananList ?? []);

                $pesananMenungguPembayaran = isset($statistics)
                    ? (int) ($statistics['menunggu_pembayaran'] ?? 0)
                    : $statsCollection->where('status', 'Menunggu Pembayaran')->count();

                $pesananMenungguPengambilan = isset($statistics)
                    ? (int) ($statistics['menunggu'] ?? 0)
                    : $statsCollection->where('status', 'Menunggu Pengambilan')->count();

                $pesananSelesai = isset($statistics)
                    ? (int) ($statistics['selesai'] ?? 0)
                    : $statsCollection->where('status', 'Selesai')->count();

                $pesananBatal = isset($statistics)
                    ? (int) ($statistics['batal'] ?? 0)
                    : $statsCollection->where('status', 'Batal')->count();

            @endphp


            <div class="summary-grid">


                {{-- TOTAL PESANAN --}}

                <div class="summary-card">

                    <div class="summary-top">

                        <span class="summary-label">
                            Total Pesanan
                        </span>

                        <span class="summary-icon">
                            ≡
                        </span>

                    </div>

                    <div class="summary-number">
                        {{ $totalPesanan }}
                    </div>

                    <div class="summary-description">
                        Seluruh pesanan menu
                    </div>

                </div>


                {{-- MENUNGGU PEMBAYARAN --}}

                <div class="summary-card">

                    <div class="summary-top">

                        <span class="summary-label">
                            Menunggu Pembayaran
                        </span>

                        <span class="summary-icon">
                            ◷
                        </span>

                    </div>

                    <div class="summary-number">
                        {{ $pesananMenungguPembayaran }}
                    </div>

                    <div class="summary-description">
                        Pesanan Cash yang perlu diverifikasi
                    </div>

                </div>


                {{-- SELESAI --}}

                <div class="summary-card">

                    <div class="summary-top">

                        <span class="summary-label">
                            Selesai
                        </span>

                        <span class="summary-icon">
                            ✓
                        </span>

                    </div>

                    <div class="summary-number">
                        {{ $pesananSelesai }}
                    </div>

                    <div class="summary-description">
                        Pesanan telah selesai
                    </div>

                </div>


                {{-- BATAL --}}

                <div class="summary-card">

                    <div class="summary-top">

                        <span class="summary-label">
                            Batal
                        </span>

                        <span class="summary-icon">
                            ×
                        </span>

                    </div>

                    <div class="summary-number">
                        {{ $pesananBatal }}
                    </div>

                    <div class="summary-description">
                        Pesanan dibatalkan
                    </div>

                </div>

            </div>


            {{-- =================================================
                 ORDER CARD
            ================================================== --}}

            <div class="order-card">


                {{-- =================================================
                     CARD HEADER
                ================================================== --}}

                <div class="order-card-header">

                    <div class="card-heading">

                        <h2 class="card-title">
                            Daftar Pesanan
                        </h2>

                        <p class="card-subtitle">
                            Pesanan menu pelanggan yang masuk dan perlu ditangani kasir.
                        </p>

                    </div>

                </div>


                {{-- =================================================
                     FILTER AREA
                ================================================== --}}

                <form
                    action="{{ url()->current() }}"
                    method="GET"
                    class="filter-area"
                >

                    <div class="filter-row">


                        {{-- SEARCH --}}

                        <div class="search-wrapper">

                            <span class="search-icon">
                                ⌕
                            </span>

                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                class="search-input"
                                placeholder="Cari kode pesanan atau nama pelanggan..."
                                autocomplete="off"
                            >

                        </div>


                        {{-- STATUS --}}

                        <select
                            name="status"
                            class="filter-select"
                        >

                            <option value="semua"
                                {{ request('status', 'semua') === 'semua' ? 'selected' : '' }}>
                                Semua Status
                            </option>

                            <option value="pembayaran"
                                {{ request('status') === 'pembayaran' ? 'selected' : '' }}>
                                Menunggu Pembayaran
                            </option>

                            <option value="menunggu"
                                {{ request('status') === 'menunggu' ? 'selected' : '' }}>
                                Menunggu Pengambilan
                            </option>

                            <option value="selesai"
                                {{ request('status') === 'selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>

                            <option value="batal"
                                {{ request('status') === 'batal' ? 'selected' : '' }}>
                                Batal
                            </option>

                        </select>


                        {{-- FILTER --}}

                        <button
                            type="submit"
                            class="filter-button"
                        >
                            Filter
                        </button>


                        {{-- RESET --}}

                        @if(request('search') !== '' || (request()->has('status') && request('status') !== 'semua'))

                            <a
                                href="{{ url()->current() }}"
                                class="reset-button"
                            >
                                Reset
                            </a>

                        @endif

                    </div>

                </form>


                {{-- =================================================
                     TABLE
                ================================================== --}}

                @if($pesananList && $pesananList->count())

                    <div class="table-wrapper">

                        <table class="order-table">

                            <thead>

                                <tr>

                                    <th>
                                        Pesanan
                                    </th>

                                    <th>
                                        Pelanggan
                                    </th>

                                    <th>
                                        Pembayaran
                                    </th>

                                    <th>
                                        Total
                                    </th>

                                    <th>
                                        Status
                                    </th>

                                    <th>
                                        Aksi
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @foreach($pesananList as $pesanan)

                                    @php

                                        /*
                                        |--------------------------------------------------------------------------
                                        | CUSTOMER INITIAL
                                        |--------------------------------------------------------------------------
                                        */

                                        $namaPelanggan =
                                            $pesanan->nama_pelanggan
                                            ?? 'Pelanggan';

                                        $initial =
                                            strtoupper(
                                                substr(
                                                    trim($namaPelanggan),
                                                    0,
                                                    2
                                                )
                                            );


                                        /*
                                        |--------------------------------------------------------------------------
                                        | PAYMENT CLASS
                                        |--------------------------------------------------------------------------
                                        */

                                        $paymentClass =
                                            strtolower(
                                                (string)
                                                ($pesanan->metode_pembayaran ?? '')
                                            );

                                        if (!in_array($paymentClass, ['cash', 'qris'], true)) {
                                            $paymentClass = '';
                                        }


                                        /*
                                        |--------------------------------------------------------------------------
                                        | STATUS CLASS
                                        |--------------------------------------------------------------------------
                                        */

                                        $statusClass =
                                            match($pesanan->status ?? '') {

                                                'Menunggu Pembayaran'
                                                    => 'status-waiting-payment',

                                                'Lunas'
                                                    => 'status-paid',

                                                'Menunggu Pengambilan'
                                                    => 'status-waiting-pickup',

                                                'Selesai'
                                                    => 'status-completed',

                                                'Batal'
                                                    => 'status-cancelled',

                                                default
                                                    => 'status-waiting-payment',

                                            };

                                    @endphp


                                    <tr>


                                        {{-- =================================
                                             PESANAN
                                        ================================== --}}

                                        <td>

                                            <div class="order-code">
                                                {{ $pesanan->kode_pesanan ?? '-' }}
                                            </div>

                                            <div class="order-date">

                                                @if($pesanan->created_at)

                                                    {{ $pesanan->created_at->format('d/m/Y H:i') }}

                                                @else

                                                    -

                                                @endif

                                            </div>

                                        </td>


                                        {{-- =================================
                                             PELANGGAN
                                        ================================== --}}

                                        <td>

                                            <div class="customer-wrapper">

                                                <div class="customer-avatar">
                                                    {{ $initial }}
                                                </div>

                                                <div>

                                                    <div class="customer-name">
                                                        {{ $namaPelanggan }}
                                                    </div>

                                                    <div class="customer-phone">

                                                        {{ $pesanan->no_wa ?? 'Nomor tidak tersedia' }}

                                                    </div>

                                                </div>

                                            </div>

                                        </td>


                                        {{-- =================================
                                             PEMBAYARAN
                                        ================================== --}}

                                        <td>

                                            <span
                                                class="payment-badge {{ $paymentClass }}"
                                            >

                                                {{ $pesanan->metode_pembayaran ?? '-' }}

                                            </span>

                                        </td>


                                        {{-- =================================
                                             TOTAL
                                        ================================== --}}

                                        <td>

                                            <div class="total-price">

                                                Rp
                                                {{ number_format(
                                                    $pesanan->total_harga ?? 0,
                                                    0,
                                                    ',',
                                                    '.'
                                                ) }}

                                            </div>

                                            <div class="total-label">
                                                Total pembayaran
                                            </div>

                                        </td>


                                        {{-- =================================
                                             STATUS
                                        ================================== --}}

                                        <td>

                                            <span
                                                class="status-badge {{ $statusClass }}"
                                            >

                                                <span class="status-dot"></span>

                                                {{ $pesanan->status ?? '-' }}

                                            </span>

                                        </td>


                                        {{-- =================================
                                             ACTION
                                        ================================== --}}

                                        <td>
                                            <button
                                                type="button"
                                                class="action-button"
                                                onclick="openOrderDetail({{ $pesanan->id_pesanan }})"
                                            >
                                                Lihat Detail
                                            </button>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>


                    {{-- =================================================
                         DETAIL PESANAN MENU - POPUP
                         Khusus pesanan Menu biasa.
                         Paket Bundling ditangani di halaman Pesanan Bundling.
                    ================================================== --}}

                    @foreach($pesananList as $pesananDetail)

                        @php
                            $detailMenuItems = collect($pesananDetail->details ?? [])
                                ->filter(function ($detail) {
                                    return !empty($detail->id_menu)
                                        && empty($detail->id_paket_bundling)
                                        && $detail->menu;
                                })
                                ->values();

                            $hasDetailMenu = $detailMenuItems->isNotEmpty();
                        @endphp

                        <div
                            id="orderDetailModal{{ $pesananDetail->id_pesanan }}"
                            class="detail-modal"
                            aria-hidden="true"
                            onclick="handleDetailModalBackdrop(event, {{ $pesananDetail->id_pesanan }})"
                        >
                            <div
                                class="detail-modal-card"
                                role="dialog"
                                aria-modal="true"
                                aria-labelledby="detailModalTitle{{ $pesananDetail->id_pesanan }}"
                                onclick="event.stopPropagation()"
                            >

                                <div class="detail-modal-header">
                                    <div>
                                        <div class="detail-modal-eyebrow">
                                            Detail Pesanan Menu
                                        </div>

                                        <div
                                            id="detailModalTitle{{ $pesananDetail->id_pesanan }}"
                                            class="detail-modal-title"
                                        >
                                            {{ $pesananDetail->nama_pelanggan ?? 'Pelanggan' }}
                                        </div>

                                        <div class="detail-modal-code">
                                            {{ $pesananDetail->kode_pesanan ?? '-' }}
                                        </div>
                                    </div>

                                    <button
                                        type="button"
                                        class="detail-modal-close"
                                        onclick="closeOrderDetail({{ $pesananDetail->id_pesanan }})"
                                        aria-label="Tutup detail"
                                    >×</button>
                                </div>

                                <div class="detail-modal-body">

                                    <div class="detail-info-grid">

                                        <div class="detail-info-item">
                                            <div class="detail-info-label">
                                                Pelanggan
                                            </div>

                                            <div class="detail-info-value">
                                                {{ $pesananDetail->nama_pelanggan ?? '-' }}
                                            </div>
                                        </div>

                                        <div class="detail-info-item">
                                            <div class="detail-info-label">
                                                No. WhatsApp
                                            </div>

                                            <div class="detail-info-value">
                                                {{ $pesananDetail->no_wa ?? '-' }}
                                            </div>
                                        </div>

                                        <div class="detail-info-item">
                                            <div class="detail-info-label">
                                                Pembayaran
                                            </div>

                                            <div class="detail-info-value">
                                                {{ $pesananDetail->metode_pembayaran ?? '-' }}
                                            </div>
                                        </div>

                                        <div class="detail-info-item">
                                            <div class="detail-info-label">
                                                Status Pesanan
                                            </div>

                                            <div class="detail-info-value">
                                                {{ $pesananDetail->status ?? '-' }}
                                            </div>
                                        </div>

                                    </div>

                                    <div class="detail-section-title">
                                        Item Menu
                                    </div>

                                    @if($hasDetailMenu)

                                        <div class="detail-items">

                                            @foreach($detailMenuItems as $detailItem)

                                                @php
                                                    $namaMenu = optional($detailItem->menu)->nama
                                                        ?? optional($detailItem->menu)->nama_menu
                                                        ?? 'Menu';

                                                    $hargaMenu = (int) (
                                                        $detailItem->harga
                                                        ?? optional($detailItem->menu)->harga
                                                        ?? 0
                                                    );

                                                    $qtyMenu = max(
                                                        1,
                                                        (int) ($detailItem->qty ?? 1)
                                                    );

                                                    $subtotalMenu = (int) (
                                                        $detailItem->subtotal
                                                        ?? ($hargaMenu * $qtyMenu)
                                                    );

                                                    $statusItem =
                                                        $detailItem->status_item
                                                        ?? 'Menunggu';
                                                @endphp

                                                <div class="detail-item">

                                                    <div>
                                                        <div class="detail-item-name">
                                                            {{ $namaMenu }}
                                                        </div>

                                                        <div class="detail-item-meta">
                                                            {{ $qtyMenu }}
                                                            × Rp
                                                            {{ number_format(
                                                                $hargaMenu,
                                                                0,
                                                                ',',
                                                                '.'
                                                            ) }}

                                                            &nbsp;•&nbsp;

                                                            Status item:
                                                            {{ $statusItem }}
                                                        </div>
                                                    </div>

                                                    <div class="detail-item-subtotal">
                                                        Rp
                                                        {{ number_format(
                                                            $subtotalMenu,
                                                            0,
                                                            ',',
                                                            '.'
                                                        ) }}
                                                    </div>

                                                </div>

                                            @endforeach

                                        </div>

                                    @else

                                        <div class="detail-empty">
                                            Tidak ada item Menu yang perlu diproses oleh Kasir Menu.
                                        </div>

                                    @endif

                                    <div class="detail-total">

                                        <span class="detail-total-label">
                                            Total Pesanan
                                        </span>

                                        <span class="detail-total-value">
                                            Rp
                                            {{ number_format(
                                                (int) ($pesananDetail->total_harga ?? 0),
                                                0,
                                                ',',
                                                '.'
                                            ) }}
                                        </span>

                                    </div>

                                </div>

                                <div class="detail-modal-footer">

                                    <div class="detail-modal-actions">

                                        @if(in_array(
                                            ($pesananDetail->status ?? ''),
                                            ['Menunggu Pembayaran', 'Lunas', 'Menunggu Pengambilan'],
                                            true
                                        ))

                                            <span class="detail-verify-note">

                                                @if(($pesananDetail->status ?? '') === 'Menunggu Pembayaran')

                                                    Pembayaran Cash belum diverifikasi. Pastikan uang sudah diterima sebelum melanjutkan.

                                                @elseif(($pesananDetail->status ?? '') === 'Lunas')

                                                    Pembayaran QRIS sudah dikonfirmasi Midtrans. Verifikasi pembayaran ini untuk melanjutkan pesanan ke tahap Menunggu Pengambilan.

                                                @else

                                                    Pastikan seluruh item Menu pada pesanan sudah diperiksa.

                                                @endif

                                            </span>

                                            <form
                                                action="{{ route(
                                                    'kasir.menu.pesanan.verify',
                                                    $pesananDetail->id_pesanan
                                                ) }}"
                                                method="POST"
                                            >

                                                @csrf

                                                <input
                                                    type="hidden"
                                                    name="confirmation"
                                                    value="1"
                                                >

                                                <button
                                                    type="button"
                                                    class="detail-verify-button"
                                                    onclick="openVerificationModal(
                                                        this.closest('form'),
                                                        @js($pesananDetail->kode_pesanan ?? '')
                                                    )"
                                                >
                                                    @if(($pesananDetail->status ?? '') === 'Menunggu Pembayaran')
                                                        Verifikasi Pembayaran Cash
                                                    @elseif(($pesananDetail->status ?? '') === 'Lunas')
                                                        Verifikasi Pembayaran QRIS
                                                    @else
                                                        Verifikasi Menu
                                                    @endif
                                                </button>

                                            </form>

                                        @endif

                                        <button
                                            type="button"
                                            class="detail-close-button"
                                            onclick="closeOrderDetail({{ $pesananDetail->id_pesanan }})"
                                        >
                                            Tutup
                                        </button>

                                    </div>

                                </div>

                            </div>
                        </div>

                    @endforeach

                    {{-- =================================================
                         PAGINATION
                    ================================================== --}}

                    <div class="table-footer">


                        <div class="pagination-info">

                            @if(method_exists($pesananList, 'firstItem'))

                                Menampilkan
                                <strong>
                                    {{ $pesananList->firstItem() ?? 0 }}
                                </strong>

                                -
                                <strong>
                                    {{ $pesananList->lastItem() ?? 0 }}
                                </strong>

                                dari
                                <strong>
                                    {{ $pesananList->total() }}
                                </strong>
                                pesanan

                            @else

                                Menampilkan
                                <strong>
                                    {{ $pesananList->count() }}
                                </strong>
                                pesanan

                            @endif

                        </div>


                        @if(method_exists($pesananList, 'links'))

                            <div class="pagination">

                                {{ $pesananList->onEachSide(1)->links('pagination::simple-tailwind') }}

                            </div>

                        @endif

                    </div>


                @else


                    {{-- =================================================
                         EMPTY STATE
                    ================================================== --}}

                    <div class="empty-state">

                        <div class="empty-icon">
                            ≡
                        </div>

                        <div class="empty-title">
                            Belum ada pesanan
                        </div>

                        <div class="empty-description">
                            Belum terdapat pesanan Menu yang memiliki
                            komponen Menu untuk ditampilkan pada halaman ini.
                        </div>

                    </div>

                @endif

            </div>

        </div>

    </main>

</div>



<script>
    function openOrderDetail(id) {
        const modal = document.getElementById('orderDetailModal' + id);

        if (!modal) return;

        modal.classList.add('show');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeOrderDetail(id) {
        const modal = document.getElementById('orderDetailModal' + id);

        if (!modal) return;

        modal.classList.remove('show');
        modal.setAttribute('aria-hidden', 'true');

        if (!document.querySelector('.detail-modal.show')) {
            document.body.style.overflow = '';
        }
    }

    function handleDetailModalBackdrop(event, id) {
        if (event.target === event.currentTarget) {
            closeOrderDetail(id);
        }
    }

    document.addEventListener('keydown', function (event) {
        if (event.key !== 'Escape') return;

        const modal = document.querySelector('.detail-modal.show');

        if (!modal) return;

        const id = modal.id.replace('orderDetailModal', '');
        closeOrderDetail(id);
    });
</script>



<!-- =========================================================
     CUSTOM VERIFICATION CONFIRMATION MODAL
========================================================== -->
<div id="verificationConfirmModal" class="verification-modal" aria-hidden="true">
    <div
        class="verification-modal-card"
        role="dialog"
        aria-modal="true"
        aria-labelledby="verificationModalTitle"
        onclick="event.stopPropagation()"
    >
        <div class="verification-modal-header">
            <div class="verification-modal-icon">✓</div>

            <div>
                <h3 id="verificationModalTitle" class="verification-modal-title">
                    Verifikasi Pesanan
                </h3>

                <p class="verification-modal-subtitle">
                    Pastikan informasi pesanan sudah sesuai sebelum melanjutkan.
                </p>
            </div>
        </div>

        <div class="verification-modal-body">
            <div class="verification-modal-info">
                <strong id="verificationModalOrderCode">Pesanan yang dipilih</strong>
                <br>
                <span id="verificationModalMessage">
                    Apakah kamu yakin ingin memverifikasi pesanan ini?
                </span>
            </div>
        </div>

        <div class="verification-modal-actions">
            <button
                type="button"
                class="verification-modal-btn verification-modal-cancel"
                onclick="closeVerificationModal()"
            >
                Batal
            </button>

            <button
                type="button"
                class="verification-modal-btn verification-modal-confirm"
                onclick="submitVerification()"
            >
                Ya, Verifikasi
            </button>
        </div>
    </div>
</div>

<script>
    let verificationForm = null;
    let verificationOrderCode = '';

    function openVerificationModal(form, orderCode = '') {
        if (!form) return;

        verificationForm = form;
        verificationOrderCode = orderCode || '';

        const modal = document.getElementById('verificationConfirmModal');
        const codeElement = document.getElementById('verificationModalOrderCode');
        const messageElement = document.getElementById('verificationModalMessage');

        if (!modal || !codeElement || !messageElement) {
            return;
        }

        const activeDetail = document.querySelector('.detail-modal.show');
        const activeText = activeDetail
            ? (activeDetail.innerText || '')
            : '';

        codeElement.textContent = verificationOrderCode
            || 'Pesanan yang dipilih';

        if (activeText.includes('Menunggu Pembayaran')) {

            messageElement.textContent =
                'Pastikan pembayaran Cash benar-benar sudah diterima. Setelah dikonfirmasi, pesanan masuk ke tahap Menunggu Pengambilan.';

        } else if (activeText.includes('Lunas')) {

            messageElement.textContent =
                'Pembayaran QRIS telah dikonfirmasi Midtrans. Setelah verifikasi kasir, pesanan masuk ke tahap Menunggu Pengambilan.';

        } else {

            messageElement.textContent =
                'Pastikan seluruh item Menu pada pesanan sudah diperiksa sebelum melakukan verifikasi.';

        }

        modal.classList.add('show');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeVerificationModal() {
        const modal = document.getElementById('verificationConfirmModal');

        if (!modal) return;

        modal.classList.remove('show');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';

        verificationForm = null;
        verificationOrderCode = '';
    }

    function submitVerification() {
        if (!verificationForm) {
            closeVerificationModal();
            return;
        }

        const form = verificationForm;

        /*
         * Simpan referensi form sebelum modal ditutup.
         * Form tidak diubah oleh closeVerificationModal().
         */
        closeVerificationModal();

        setTimeout(function () {
            if (form && typeof form.submit === 'function') {
                form.submit();
            }
        }, 80);
    }

    const verificationModal =
        document.getElementById('verificationConfirmModal');

    if (verificationModal) {
        verificationModal.addEventListener('click', function (event) {
            if (event.target === this) {
                closeVerificationModal();
            }
        });
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeVerificationModal();
        }
    });
</script>

</body>

</html>