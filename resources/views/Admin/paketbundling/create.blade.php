<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Paket Bundling</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

<style>
:root{
    --bg-primary:#0a0a0a;
    --bg-secondary:#151515;
    --bg-soft:#1a1a1a;
    --bg-card:#121212;

    --text-primary:#f8f4ed;
    --text-secondary:#d4c9b5;
    --text-muted:#a89988;
    --text-dim:#7a6f62;

    --accent:#e2c997;
    --accent-hover:#d4b384;
    --accent-dark:#b89a6e;

    --border-soft:rgba(255,255,255,.06);
    --border-gold:rgba(226,201,151,.15);

    --shadow-soft:0 20px 60px rgba(0,0,0,.40);
    --shadow-hover:0 25px 70px rgba(0,0,0,.50);

    --radius-lg:28px;
    --radius-md:16px;
    --radius-sm:13px;
    --radius-full:999px;

    --transition:.25s cubic-bezier(.4,0,.2,1);
}

*,
*::before,
*::after{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

html{scroll-behavior:smooth}

body{
    min-height:100vh;
    font-family:'Inter',Arial,sans-serif;
    background:
        radial-gradient(circle at 88% 3%,rgba(226,201,151,.055),transparent 28%),
        radial-gradient(circle at 4% 100%,rgba(226,201,151,.025),transparent 25%),
        var(--bg-primary);
    color:var(--text-primary);
    overflow-x:hidden;
    line-height:1.65;
    font-size:15px;
}

button,
input,
select,
textarea{
    font:inherit;
}

button,
a,
input,
select,
textarea{
    -webkit-tap-highlight-color:transparent;
}

::selection{
    background:rgba(226,201,151,.24);
    color:var(--text-primary);
}

.text-gradient{
    background:linear-gradient(
        135deg,
        var(--accent) 0%,
        #f8f4ed 50%,
        var(--accent-dark) 100%
    );
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
    background-clip:text;
}

/* =========================
   MOBILE SIDEBAR BUTTON
========================= */
.admin-mobile-menu-button{
    position:fixed;
    top:16px;
    left:16px;
    z-index:1205;
    width:48px;
    height:48px;
    display:none;
    align-items:center;
    justify-content:center;
    flex-direction:column;
    gap:5px;
    border:1px solid rgba(226,201,151,.20);
    border-radius:14px;
    background:rgba(18,18,18,.94);
    color:var(--accent);
    box-shadow:0 14px 35px rgba(0,0,0,.35);
    backdrop-filter:blur(18px);
    -webkit-backdrop-filter:blur(18px);
    cursor:pointer;
    transition:all var(--transition);
}
.admin-mobile-menu-button:hover{
    background:rgba(226,201,151,.09);
    border-color:rgba(226,201,151,.42);
    transform:translateY(-1px);
}
.admin-mobile-menu-button:active{transform:scale(.96)}
.admin-mobile-menu-button:focus-visible{
    outline:2px solid rgba(226,201,151,.72);
    outline-offset:3px;
}
.admin-mobile-menu-button span{
    width:21px;
    height:2px;
    border-radius:10px;
    background:var(--accent);
}

/* =========================
   PAGE
========================= */
#paketBundlingPage.container-custom{
    width:calc(100% - var(--admin-sidebar-width,280px));
    max-width:none;
    margin-left:var(--admin-sidebar-width,280px);
    margin-right:0;
    padding:54px 56px 76px;
    min-height:100vh;
}

.page-header{
    margin-bottom:30px;
}
.page-header h1{
    margin:0;
    font-family:'Playfair Display',Georgia,serif;
    font-size:clamp(40px,4vw,60px);
    line-height:1.08;
    letter-spacing:-1.3px;
    font-weight:700;
}
.page-description{
    max-width:760px;
    margin-top:12px;
    color:var(--text-muted);
    font-size:16px;
    line-height:1.75;
}

.glass-card{
    position:relative;
    overflow:visible;
    background:
        linear-gradient(145deg,rgba(255,255,255,.047),rgba(255,255,255,.016)),
        rgba(18,18,18,.90);
    border:1px solid var(--border-gold);
    border-radius:var(--radius-lg);
    box-shadow:var(--shadow-soft);
    backdrop-filter:blur(24px);
    -webkit-backdrop-filter:blur(24px);
}
.glass-card::before{
    content:"";
    position:absolute;
    left:0;
    right:0;
    top:0;
    height:1px;
    background:linear-gradient(90deg,transparent,rgba(226,201,151,.35),transparent);
    pointer-events:none;
}

.alert-box{
    margin-bottom:22px;
    padding:18px 20px;
    border-radius:18px;
}
.alert-box.error{
    border-color:rgba(180,72,72,.45);
    color:var(--text-secondary);
}
.alert-box.error strong{color:#f1aaa2}

/* =========================
   FORM
========================= */
.form-card{
    padding:32px;
}
.form-grid{
    display:grid;
    grid-template-columns:minmax(0,1.03fr) minmax(390px,.97fr);
    gap:30px;
    align-items:start;
}
.form-column{
    min-width:0;
}
.form-field{
    margin-bottom:23px;
}
.form-label{
    display:block;
    margin-bottom:9px;
    color:var(--text-primary);
    font-size:15px;
    line-height:1.45;
    font-weight:700;
}
.form-help{
    display:block;
    margin-top:8px;
    color:var(--text-dim);
    font-size:13px;
    line-height:1.6;
}

.form-input,
.form-select,
.form-textarea{
    width:100%;
    border:1px solid rgba(255,255,255,.075);
    border-radius:15px;
    background:rgba(255,255,255,.032);
    color:var(--text-primary);
    outline:none;
    transition:all var(--transition);
}
.form-input,
.form-select{
    min-height:58px;
    padding:0 17px;
    font-size:15px;
}
.form-textarea{
    min-height:150px;
    padding:15px 17px;
    font-size:15px;
    line-height:1.7;
    resize:vertical;
}
.form-input::placeholder,
.form-textarea::placeholder{
    color:var(--text-dim);
}
.form-input:focus,
.form-select:focus,
.form-textarea:focus{
    border-color:rgba(226,201,151,.55);
    background:rgba(226,201,151,.042);
    box-shadow:0 0 0 4px rgba(226,201,151,.065);
}
.form-select{
    appearance:none;
    -webkit-appearance:none;
    padding-right:46px;
    cursor:pointer;
}
.select-wrap{
    position:relative;
}
.select-wrap > i{
    position:absolute;
    right:17px;
    top:50%;
    transform:translateY(-50%);
    color:var(--text-dim);
    pointer-events:none;
}
.form-select option{
    background:#181818;
    color:var(--text-primary);
}

/* price */
.price-wrap{
    position:relative;
}
.price-prefix{
    position:absolute;
    left:17px;
    top:50%;
    transform:translateY(-50%);
    color:var(--accent);
    font-size:15px;
    font-weight:800;
    pointer-events:none;
}
.price-input{
    padding-left:53px !important;
    font-weight:700;
}

/* =========================
   TICKET CARD
========================= */
.side-card{
    position:relative;
    z-index:1;
    padding:23px;
    margin-bottom:18px;
    border-radius:20px;
    overflow:visible !important;
}
.side-card.dropdown-host-open{
    z-index:3000 !important;
}
.form-card{
    overflow:visible !important;
}
.side-card:last-child{margin-bottom:0}
.side-title{
    display:flex;
    align-items:center;
    gap:10px;
    margin-bottom:7px;
    font-family:'Playfair Display',Georgia,serif;
    font-size:22px;
    line-height:1.25;
    font-weight:700;
}
.side-title i{
    width:36px;
    height:36px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    flex:0 0 36px;
    border:1px solid rgba(226,201,151,.16);
    border-radius:11px;
    background:rgba(226,201,151,.07);
    color:var(--accent);
    font-size:14px;
}
.side-description{
    margin-top:7px;
    color:var(--text-muted);
    font-size:14px;
    line-height:1.7;
}
.ticket-price-box{
    margin-top:18px;
    padding:16px;
    border:1px solid rgba(226,201,151,.12);
    border-radius:16px;
    background:rgba(226,201,151,.035);
}
.ticket-price-box .form-label{
    margin-bottom:9px;
}

/* =========================
   SEARCHABLE DROPDOWN
========================= */
.multi-select{
    position:relative;
}
.multi-trigger{
    width:100%;
    min-height:58px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    padding:0 16px;
    border:1px solid rgba(255,255,255,.075);
    border-radius:15px;
    background:rgba(255,255,255,.032);
    color:var(--text-primary);
    cursor:pointer;
    transition:all var(--transition);
}
.multi-trigger:hover{
    border-color:rgba(226,201,151,.35);
    background:rgba(226,201,151,.035);
}
.multi-trigger:focus-visible{
    outline:2px solid rgba(226,201,151,.65);
    outline-offset:3px;
}
.multi-trigger-left{
    display:flex;
    align-items:center;
    gap:11px;
    min-width:0;
}
.multi-trigger-icon{
    width:36px;
    height:36px;
    flex:0 0 36px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:10px;
    background:rgba(226,201,151,.075);
    border:1px solid rgba(226,201,151,.13);
    color:var(--accent);
}
.multi-trigger-text{
    min-width:0;
    overflow:hidden;
}
.multi-trigger-title{
    display:block;
    font-size:15px;
    line-height:1.35;
    font-weight:700;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
}
.multi-trigger-sub{
    display:block;
    margin-top:3px;
    color:var(--text-dim);
    font-size:12px;
    line-height:1.3;
}
.multi-trigger-arrow{
    flex:0 0 auto;
    color:var(--text-dim);
    transition:transform var(--transition),color var(--transition);
}
.multi-select.open .multi-trigger{
    border-color:rgba(226,201,151,.55);
    background:rgba(226,201,151,.042);
    box-shadow:0 0 0 4px rgba(226,201,151,.055);
}
.multi-select.open .multi-trigger-arrow{
    color:var(--accent);
    transform:rotate(180deg);
}
.multi-panel{
    position:absolute;
    left:0;
    right:0;
    top:calc(100% + 9px);
    z-index:3200;
    display:none;
    max-height:min(430px, calc(100dvh - 28px));
    padding:12px;
    border:1px solid rgba(226,201,151,.18);
    border-radius:18px;
    background:
        linear-gradient(145deg,rgba(255,255,255,.06),rgba(255,255,255,.018)),
        #131313;
    box-shadow:0 24px 60px rgba(0,0,0,.58);
    backdrop-filter:blur(20px);
    -webkit-backdrop-filter:blur(20px);
}
.multi-select.open .multi-panel{display:block}.multi-search{
    position:relative;
    margin-bottom:10px;
}
.multi-search input{
    width:100%;
    height:48px;
    padding:0 16px 0 44px;
    border:1px solid rgba(255,255,255,.075);
    border-radius:12px;
    background:rgba(255,255,255,.035);
    color:var(--text-primary);
    outline:none;
    font-size:14px;
}
.multi-search i{
    position:absolute;
    left:15px;
    top:50%;
    transform:translateY(-50%);
    color:var(--text-dim);
    pointer-events:none;
}
.multi-search input:focus{
    border-color:rgba(226,201,151,.48);
    box-shadow:0 0 0 3px rgba(226,201,151,.05);
}
.multi-options{
    max-height:320px;
    overflow:auto;
    padding-right:2px;
    scrollbar-width:thin;
    scrollbar-color:rgba(226,201,151,.25) transparent;
}
.multi-options::-webkit-scrollbar{width:6px}
.multi-options::-webkit-scrollbar-thumb{
    background:rgba(226,201,151,.23);
    border-radius:999px;
}
.option-group{
    margin-top:8px;
}
.option-group:first-child{margin-top:0}
.option-group-title{
    padding:8px 9px 7px;
    color:var(--accent);
    font-size:11px;
    font-weight:800;
    letter-spacing:1.15px;
    text-transform:uppercase;
}
.multi-option{
    display:flex;
    align-items:center;
    gap:11px;
    width:100%;
    min-height:50px;
    padding:9px 10px;
    border:1px solid transparent;
    border-radius:12px;
    background:transparent;
    cursor:pointer;
    transition:all var(--transition);
}
.multi-option:hover{
    background:rgba(226,201,151,.05);
    border-color:rgba(226,201,151,.09);
}
.multi-option.is-checked{
    background:rgba(226,201,151,.075);
    border-color:rgba(226,201,151,.17);
}
.multi-option input{
    width:20px;
    height:20px;
    flex:0 0 20px;
    margin:0;
    accent-color:var(--accent);
    cursor:pointer;
}
.option-copy{
    min-width:0;
    flex:1;
}
.option-name{
    color:var(--text-secondary);
    font-size:14px;
    font-weight:600;
    line-height:1.4;
}
.option-meta{
    margin-top:2px;
    color:var(--text-dim);
    font-size:12px;
    line-height:1.35;
}
.option-price{
    flex:0 0 auto;
    color:var(--accent);
    font-size:13px;
    font-weight:800;
    white-space:nowrap;
}
.empty-options{
    padding:24px 12px;
    text-align:center;
    color:var(--text-dim);
    font-size:13px;
}
.selection-footer{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:10px;
    margin-top:9px;
    padding-top:10px;
    border-top:1px solid rgba(255,255,255,.05);
}
.selection-count{
    color:var(--text-muted);
    font-size:12px;
}
.clear-selection{
    border:0;
    background:none;
    color:var(--accent);
    font-size:12px;
    font-weight:800;
    cursor:pointer;
}
.clear-selection:hover{color:var(--accent-hover)}

/* =========================
   IMAGE UPLOAD
========================= */
.image-upload-box{
    position:relative;
}
.upload-dropzone{
    position:relative;
    min-height:230px;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:24px;
    border:1px dashed rgba(226,201,151,.25);
    border-radius:20px;
    background:
        radial-gradient(circle at 50% 0%,rgba(226,201,151,.055),transparent 44%),
        rgba(255,255,255,.018);
    text-align:center;
    cursor:pointer;
    transition:all var(--transition);
}
.upload-dropzone:hover,
.upload-dropzone.drag-over{
    border-color:rgba(226,201,151,.60);
    background:rgba(226,201,151,.045);
    transform:translateY(-1px);
}
.upload-dropzone.has-file{
    padding:14px;
    min-height:260px;
}
.upload-content{
    max-width:330px;
}
.upload-icon{
    width:64px;
    height:64px;
    margin:0 auto 15px;
    display:flex;
    align-items:center;
    justify-content:center;
    border:1px solid rgba(226,201,151,.18);
    border-radius:19px;
    background:rgba(226,201,151,.075);
    color:var(--accent);
    font-size:25px;
    box-shadow:0 12px 30px rgba(0,0,0,.20);
}
.upload-title{
    color:var(--text-primary);
    font-size:16px;
    font-weight:800;
}
.upload-subtitle{
    margin-top:6px;
    color:var(--text-muted);
    font-size:13px;
    line-height:1.6;
}
.upload-button{
    min-height:46px;
    margin-top:16px;
    padding:0 18px;
    border:1px solid rgba(226,201,151,.23);
    border-radius:12px;
    background:rgba(226,201,151,.08);
    color:var(--accent);
    font-size:14px;
    font-weight:800;
}
.upload-meta{
    margin-top:10px;
    color:var(--text-dim);
    font-size:12px;
}
.upload-preview{
    position:relative;
    width:100%;
    min-height:230px;
    display:none;
    overflow:hidden;
    border-radius:16px;
}
.upload-preview.show{display:block}
.upload-preview img{
    display:block;
    width:100%;
    height:230px;
    object-fit:cover;
}
.upload-preview-overlay{
    position:absolute;
    inset:auto 0 0 0;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    padding:14px;
    background:linear-gradient(to top,rgba(0,0,0,.82),rgba(0,0,0,0));
}
.upload-file-name{
    min-width:0;
    color:#fff;
    font-size:13px;
    font-weight:700;
    overflow:hidden;
    white-space:nowrap;
    text-overflow:ellipsis;
}
.upload-remove{
    flex:0 0 auto;
    min-height:40px;
    padding:0 12px;
    border:1px solid rgba(255,255,255,.13);
    border-radius:10px;
    background:rgba(0,0,0,.42);
    color:#fff;
    font-size:12px;
    font-weight:800;
    cursor:pointer;
}
.upload-remove:hover{
    border-color:rgba(226,201,151,.4);
    color:var(--accent);
}
.file-input-hidden{
    position:absolute !important;
    width:1px !important;
    height:1px !important;
    padding:0 !important;
    margin:-1px !important;
    overflow:hidden !important;
    clip:rect(0,0,0,0) !important;
    white-space:nowrap !important;
    border:0 !important;
}

/* =========================
   SUMMARY
========================= */
.summary-card{
    margin-top:26px;
    padding:23px;
    border-radius:20px;
}
.summary-title{
    display:flex;
    align-items:center;
    gap:9px;
    margin-bottom:14px;
    font-family:'Playfair Display',Georgia,serif;
    font-size:22px;
    font-weight:700;
}
.summary-items{
    display:flex;
    flex-wrap:wrap;
    gap:10px;
}
.summary-pill{
    min-height:43px;
    display:inline-flex;
    align-items:center;
    gap:5px;
    padding:8px 13px;
    border:1px solid rgba(226,201,151,.13);
    border-radius:999px;
    background:rgba(226,201,151,.065);
    color:var(--text-secondary);
    font-size:14px;
}
.summary-pill strong{color:var(--accent)}
.component-warning{
    display:none;
    margin-top:12px;
    color:#efaaa3;
    font-size:14px;
    line-height:1.6;
}

/* =========================
   ACTIONS
========================= */
.form-actions{
    display:flex;
    justify-content:flex-end;
    gap:12px;
    margin-top:26px;
}
.btn-primary-travel,
.btn-secondary-travel{
    min-height:56px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    border-radius:var(--radius-full);
    text-decoration:none;
    font-size:15px;
    font-weight:800;
    transition:all var(--transition);
}
.btn-primary-travel{
    padding:0 25px;
    border:0;
    background:linear-gradient(135deg,var(--accent),var(--accent-hover));
    color:var(--bg-primary);
    box-shadow:0 11px 30px rgba(0,0,0,.24);
    cursor:pointer;
}
.btn-primary-travel:hover{
    background:linear-gradient(135deg,var(--accent-hover),var(--accent-dark));
    transform:translateY(-3px);
    box-shadow:var(--shadow-hover);
}
.btn-primary-travel:disabled{
    opacity:.65;
    cursor:not-allowed;
    transform:none !important;
}
.btn-secondary-travel{
    padding:0 22px;
    border:1px solid var(--border-gold);
    background:rgba(226,201,151,.055);
    color:var(--text-secondary);
    backdrop-filter:blur(12px);
}
.btn-secondary-travel:hover{
    background:rgba(226,201,151,.11);
    border-color:rgba(226,201,151,.44);
    color:var(--accent);
    transform:translateY(-2px);
}


/* =========================
   TWO-COLUMN TARGET / STATUS
========================= */
.form-two-col{
    display:grid;
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:16px;
    align-items:start;
    width:100%;
}

.form-two-col .form-field{
    min-width:0;
    margin-bottom:0;
}

.form-two-help{
    display:block;
    margin-top:9px;
    color:var(--text-dim);
    font-size:13px;
    line-height:1.6;
}

/* =========================
   RESPONSIVE
========================= */
@media (min-width:1400px){
    #paketBundlingPage.container-custom{
        padding:62px 70px 84px;
    }
    .form-grid{
        grid-template-columns:minmax(0,1.06fr) minmax(450px,.94fr);
        gap:34px;
    }
    .form-card{padding:36px}
}

@media (max-width:600px){
    .form-two-col{
        grid-template-columns:1fr;
        gap:18px;
    }

    .form-two-col .form-field{
        margin-bottom:0;
    }

    .form-two-help{
        margin-top:9px;
        font-size:13px;
    }
}

@media (min-width:901px) and (max-width:1199px){
    #paketBundlingPage.container-custom{
        padding:44px 32px 60px;
    }
    .page-header h1{font-size:45px}
    .page-description{font-size:15px}
    .form-grid{
        grid-template-columns:minmax(0,1fr) minmax(330px,.92fr);
        gap:22px;
    }
    .form-card{padding:26px}
}

@media (max-width:900px){
    .admin-mobile-menu-button{display:flex}
    #paketBundlingPage.container-custom{
        width:100% !important;
        margin-left:0 !important;
        padding:88px 26px 52px !important;
    }
    .page-header{margin-bottom:24px}
    .page-header h1{font-size:46px}
    .page-description{font-size:15px}
    .form-card{
        padding:25px;
        border-radius:24px;
    }
    .form-grid{
        grid-template-columns:1fr;
        gap:20px;
    }
    .multi-panel{
        position:fixed;
        left:26px;
        right:26px;
        top:auto;
        bottom:auto;
        max-height:calc(100dvh - 24px);
    }
    .form-actions{
        justify-content:stretch;
    }
    .form-actions > *{
        flex:1 1 0;
    }
}

@media (max-width:600px){
    body{font-size:15px}
    .admin-mobile-menu-button{
        top:13px;
        left:13px;
        width:46px;
        height:46px;
    }
    #paketBundlingPage.container-custom{
        padding:78px 15px 36px !important;
    }
    .page-header h1{
        font-size:38px;
        letter-spacing:-.7px;
    }
    .page-description{
        font-size:14px;
        line-height:1.72;
    }
    .form-card{
        padding:19px;
        border-radius:21px;
    }
    .side-card,
    .summary-card{
        padding:18px;
        border-radius:18px;
    }
    .side-title,
    .summary-title{font-size:20px}
    .form-input,
    .form-select{
        min-height:56px;
        font-size:15px;
    }
    .form-textarea{
        min-height:140px;
        font-size:15px;
    }
    .multi-trigger{
        min-height:56px;
    }
    .multi-panel{
        left:15px;
        right:15px;
    }
    .multi-options{max-height:52vh}
    .upload-dropzone{
        min-height:215px;
        padding:20px;
    }
    .upload-preview img{
        height:220px;
    }
    .form-actions{
        flex-direction:column-reverse;
        align-items:stretch;
        gap:10px;
    }
    .form-actions > *{
        width:100%;
    }
    .btn-primary-travel,
    .btn-secondary-travel{
        width:100%;
        min-height:56px;
    }
}

@media (max-width:380px){
    #paketBundlingPage.container-custom{
        padding-left:12px !important;
        padding-right:12px !important;
    }
    .page-header h1{font-size:34px}
    .form-card{padding:16px}
    .side-card,
    .summary-card{padding:16px}
    .multi-panel{left:12px;right:12px}
    .upload-title{font-size:15px}
}

@media (prefers-reduced-motion:reduce){
    *,
    *::before,
    *::after{
        scroll-behavior:auto !important;
        animation:none !important;
        transition:none !important;
    }
}
</style>



<style>
/* =========================================================
   SIDEBAR HP / TABLET — FLOATING GLASS SESUAI REFERENSI
========================================================= */

@media (max-width:900px){

    html,
    body{
        width:100%;
        min-height:100%;
    }

    body{
        overflow-x:hidden;
    }

    .admin-sidebar{
        position:fixed !important;
        top:10px !important;
        left:10px !important;
        right:auto !important;
        bottom:10px !important;

        width:min(320px, calc(100vw - 20px)) !important;
        height:calc(100dvh - 20px) !important;
        max-height:calc(100dvh - 20px) !important;
        min-height:0 !important;

        border:1px solid rgba(226,201,151,.16) !important;
        border-radius:18px !important;

        background:
            linear-gradient(
                180deg,
                rgba(18,18,18,.91) 0%,
                rgba(10,10,10,.84) 100%
            ) !important;

        backdrop-filter:blur(22px) saturate(120%) !important;
        -webkit-backdrop-filter:blur(22px) saturate(120%) !important;

        box-shadow:
            18px 0 60px rgba(0,0,0,.40),
            0 12px 45px rgba(0,0,0,.24) !important;

        overflow:hidden !important;
        isolation:isolate !important;

        transform:translate3d(calc(-100% - 18px),0,0) !important;
        transition:transform .30s cubic-bezier(.4,0,.2,1) !important;

        z-index:2100 !important;
    }

    .admin-sidebar.open{
        transform:translate3d(0,0,0) !important;
    }

    /* Header brand */
    .admin-sidebar-brand{
        position:relative !important;
        padding:18px 13px 13px !important;

        border-bottom:1px solid rgba(255,255,255,.055) !important;
        background:rgba(0,0,0,.07) !important;
    }

    .admin-brand-link{
        display:flex !important;
        align-items:center !important;
        gap:11px !important;
        min-width:0 !important;
        padding-right:52px !important;
    }

    .admin-brand-logo{
        width:45px !important;
        height:45px !important;
        flex:0 0 45px !important;
        border-radius:12px !important;
    }

    .admin-brand-text{
        min-width:0 !important;
    }

    .admin-brand-text strong{
        font-size:18px !important;
        line-height:1.2 !important;
    }

    .admin-brand-text span{
        margin-top:4px !important;
        font-size:8.5px !important;
        letter-spacing:1.3px !important;
    }

    /* Close */
    .admin-sidebar-close-button{
        display:flex !important;
        position:absolute !important;
        top:14px !important;
        right:13px !important;

        width:40px !important;
        height:40px !important;

        align-items:center !important;
        justify-content:center !important;

        border:1px solid rgba(226,201,151,.14) !important;
        border-radius:11px !important;

        background:rgba(255,255,255,.035) !important;
        color:#e2c997 !important;

        z-index:5 !important;
    }

    .admin-sidebar-close-button:hover{
        background:rgba(226,201,151,.08) !important;
        border-color:rgba(226,201,151,.40) !important;
    }

    /* Administrator */
    .admin-sidebar-user{
        margin:12px 13px 12px !important;
        padding:11px !important;

        border:1px solid rgba(226,201,151,.10) !important;
        border-radius:14px !important;

        background:rgba(255,255,255,.028) !important;
    }

    .admin-user-avatar{
        width:40px !important;
        height:40px !important;
        flex:0 0 40px !important;
        border-radius:12px !important;
    }

    .admin-user-info strong{
        font-size:14px !important;
    }

    .admin-user-info span{
        font-size:12px !important;
    }

    /* Navigation */
    .admin-sidebar-nav{
        min-height:0 !important;
        padding:0 10px 8px !important;

        overflow-x:hidden !important;
        overflow-y:auto !important;

        scrollbar-width:thin !important;
        scrollbar-color:rgba(226,201,151,.22) transparent !important;
    }

    .admin-sidebar-nav::-webkit-scrollbar{
        width:5px;
    }

    .admin-sidebar-nav::-webkit-scrollbar-track{
        background:transparent;
    }

    .admin-sidebar-nav::-webkit-scrollbar-thumb{
        background:rgba(226,201,151,.22);
        border-radius:999px;
    }

    .admin-nav-title{
        margin:15px 9px 7px !important;
        font-size:10px !important;
        letter-spacing:1.2px !important;
    }

    .admin-nav-link{
        min-height:51px !important;
        margin:3px 0 !important;
        padding:0 9px !important;
        border-radius:11px !important;
    }

    .admin-nav-icon{
        width:36px !important;
        height:36px !important;
        flex:0 0 36px !important;
        font-size:13px !important;
    }

    .admin-nav-text{
        font-size:14.5px !important;
    }

    /* Footer */
    .admin-sidebar-footer{
        padding:
            10px
            12px
            max(12px, env(safe-area-inset-bottom))
            !important;

        border-top:1px solid rgba(255,255,255,.055) !important;
        background:rgba(0,0,0,.20) !important;
    }

    .admin-system-status{
        margin-bottom:7px !important;
        padding:9px 10px !important;
        border-radius:10px !important;
        font-size:11px !important;
    }

    .admin-logout-button{
        min-height:43px !important;
        padding:0 9px !important;
        font-size:13.5px !important;
    }

    .admin-sidebar-copyright{
        margin-top:7px !important;
        padding-top:8px !important;
        font-size:9px !important;
    }

    .admin-sidebar-copyright small{
        font-size:9px !important;
    }

    /* Overlay */
    .admin-sidebar-overlay{
        display:block !important;
        position:fixed !important;
        inset:0 !important;

        z-index:2050 !important;

        background:rgba(0,0,0,.43) !important;

        backdrop-filter:blur(3px) !important;
        -webkit-backdrop-filter:blur(3px) !important;

        opacity:0 !important;
        pointer-events:none !important;

        transition:opacity .25s ease !important;
    }

    .admin-sidebar-overlay.show{
        opacity:1 !important;
        pointer-events:auto !important;
    }

    /* Hamburger */
    .admin-mobile-menu-button{
        display:flex !important;
        position:fixed !important;

        top:18px !important;
        left:18px !important;
        right:auto !important;

        width:48px !important;
        height:48px !important;

        z-index:2000 !important;

        align-items:center !important;
        justify-content:center !important;
        flex-direction:column !important;
        gap:5px !important;

        border:1px solid rgba(226,201,151,.20) !important;
        border-radius:14px !important;

        background:rgba(18,18,18,.90) !important;
        color:#e2c997 !important;

        box-shadow:0 12px 35px rgba(0,0,0,.32) !important;

        backdrop-filter:blur(18px) !important;
        -webkit-backdrop-filter:blur(18px) !important;
    }

    .admin-mobile-menu-button span{
        width:19px !important;
        height:2px !important;
        border-radius:999px !important;
        background:currentColor !important;
    }
}

/* HP */
@media (max-width:600px){

    .admin-sidebar{
        top:9px !important;
        left:9px !important;
        bottom:9px !important;

        width:min(320px, calc(100vw - 18px)) !important;
        height:calc(100dvh - 18px) !important;
        max-height:calc(100dvh - 18px) !important;

        border-radius:17px !important;
    }

    .admin-sidebar-brand{
        padding:18px 12px 12px !important;
    }

    .admin-sidebar-user{
        margin-left:12px !important;
        margin-right:12px !important;
    }

    .admin-mobile-menu-button{
        top:14px !important;
        left:14px !important;
        width:46px !important;
        height:46px !important;
        border-radius:13px !important;
    }
}

/* HP kecil */
@media (max-width:380px){

    .admin-sidebar{
        top:8px !important;
        left:8px !important;
        bottom:8px !important;

        width:min(305px, calc(100vw - 16px)) !important;
        height:calc(100dvh - 16px) !important;
        max-height:calc(100dvh - 16px) !important;
    }
}
</style>

</head>


<body>

    <button
        type="button"
        class="admin-mobile-menu-button"
        id="openAdminSidebar"
        aria-label="Buka menu navigasi"
        aria-controls="adminSidebar"
        aria-expanded="false"
        title="Buka menu"
    >
        <span></span><span></span><span></span>
    </button>

    @include('admin.partials.sidebar')

    <main class="container-custom" id="paketBundlingPage">

        <header class="page-header">
            <h1 class="text-gradient">Tambah Paket Bundling</h1>
            <p class="page-description">
                Buat kombinasi menu dan wahana untuk wisatawan, lalu tentukan harga serta status paket.
            </p>
        </header>

        @if ($errors->any())
            <div class="glass-card alert-box error">
                <strong><i class="fas fa-circle-exclamation"></i> Terjadi Kesalahan</strong>
                <ul style="margin-top:10px;padding-left:20px;">
                    @foreach ($errors->all() as $error)
                        <li style="margin-bottom:5px;color:var(--text-muted);font-size:14px;">
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="glass-card form-card">
            <form
                action="{{ route('admin.paketbundling.store') }}"
                method="POST"
                enctype="multipart/form-data"
                id="formPaketBundling"
            >
                @csrf

                <div class="form-grid">

                    <div class="form-column">

                        <div class="form-field">
                            <label class="form-label" for="nama_paket">Nama Paket</label>
                            <input
                                type="text"
                                id="nama_paket"
                                name="nama_paket"
                                value="{{ old('nama_paket') }}"
                                maxlength="255"
                                required
                                autocomplete="off"
                                class="form-input"
                                placeholder="Contoh: Paket Liburan Keluarga"
                            >
                        </div>

                        <div class="form-two-col">

                            <div class="form-field">
                                <label class="form-label" for="untuk">Untuk</label>

                                <div class="select-wrap">
                                    <select id="untuk" name="untuk" required class="form-select">
                                        <option value="">Pilih target</option>

                                        <option
                                            value="Anak-anak"
                                            {{ old('untuk') === 'Anak-anak' ? 'selected' : '' }}
                                        >
                                            Anak-anak
                                        </option>

                                        <option
                                            value="Dewasa"
                                            {{ old('untuk') === 'Dewasa' ? 'selected' : '' }}
                                        >
                                            Dewasa
                                        </option>
                                    </select>

                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>

                            <div class="form-field">
                                <label class="form-label" for="status">Status Paket</label>

                                <div class="select-wrap">
                                    <select id="status" name="status" required class="form-select">
                                        <option value="">Pilih status</option>

                                        <option
                                            value="Tersedia"
                                            {{ old('status', 'Tersedia') === 'Tersedia' ? 'selected' : '' }}
                                        >
                                            Tersedia
                                        </option>

                                        <option
                                            value="Tidak Tersedia"
                                            {{ old('status') === 'Tidak Tersedia' ? 'selected' : '' }}
                                        >
                                            Tidak Tersedia
                                        </option>
                                    </select>

                                    <i class="fas fa-chevron-down"></i>
                                </div>

                            </div>

                        </div>

                        <small class="form-two-help">
                            Target dan status dapat disesuaikan tanpa mengubah komponen paket.
                        </small>

                        <div class="form-field">
                            <label class="form-label" for="harga">
                                Harga Paket
                                <span style="color:var(--text-dim);font-size:12px;font-weight:600;">(Rp)</span>
                            </label>
                            <div class="price-wrap">
                                <span class="price-prefix">Rp</span>
                                <input
                                    type="text"
                                    id="harga"
                                    name="harga"
                                    value="{{ old('harga') }}"
                                    class="form-input price-input"
                                    inputmode="numeric"
                                    autocomplete="off"
                                    required
                                    placeholder="10.000"
                                    maxlength="7"
                                >
                            </div>
                            <small class="form-help">Minimal Rp 10.000 dan maksimal Rp 500.000.</small>
                        </div>

                        <div class="form-field">
                            <label class="form-label" for="deskripsi">Deskripsi</label>
                            <textarea
                                id="deskripsi"
                                name="deskripsi"
                                rows="5"
                                maxlength="5000"
                                required
                                class="form-textarea"
                                placeholder="Jelaskan isi dan keunggulan paket bundling..."
                            >{{ old('deskripsi') }}</textarea>
                        </div>

                        <div class="form-field" style="margin-bottom:0;">
                            <label class="form-label">Gambar Paket</label>

                            <div class="image-upload-box">
                                <input
                                    class="file-input-hidden"
                                    type="file"
                                    id="gambar"
                                    name="gambar"
                                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                >

                                <label for="gambar" class="upload-dropzone" id="uploadDropzone">
                                    <div class="upload-content">
                                        <div class="upload-icon">
                                            <i class="fas fa-cloud-arrow-up"></i>
                                        </div>
                                        <div class="upload-title">Unggah gambar paket</div>
                                        <div class="upload-subtitle">
                                            Klik area ini atau pilih file. Bisa juga tarik gambar ke area ini.
                                        </div>
                                        <div class="upload-button">
                                            <i class="fas fa-images"></i>&nbsp; Pilih Gambar
                                        </div>
                                        <div class="upload-meta">JPG, JPEG, PNG, atau WEBP</div>
                                    </div>
                                </label>

                                <div class="upload-preview" id="imagePreview">
                                    <img id="previewImage" src="" alt="Preview gambar paket">
                                    <div class="upload-preview-overlay">
                                        <div class="upload-file-name" id="uploadFileName">gambar.jpg</div>
                                        <button type="button" class="upload-remove" id="removeImage">
                                            <i class="fas fa-trash-can"></i>&nbsp; Ganti
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <small class="form-help">
                                Gunakan gambar yang jelas agar paket mudah dikenali.
                            </small>
                        </div>

                    </div>

                    <div class="form-column">

                        <div class="glass-card side-card">
                            <div class="side-title">
                                <i class="fas fa-ticket"></i>
                                <span>Harga Tiket Masuk</span>
                            </div>

                            <p class="side-description">
                                Masukkan harga tiket masuk saat ini. Kolom ini bisa diubah lagi sewaktu-waktu ketika harga tiket berubah.
                            </p>

                            <div class="ticket-price-box">
                                <label class="form-label" for="harga_tiket_masuk">
                                    Harga Tiket Masuk
                                </label>

                                <div class="price-wrap">
                                    <span class="price-prefix">Rp</span>
                                    <input
                                        type="text"
                                        id="harga_tiket_masuk"
                                        name="harga_tiket_masuk"
                                        value="{{ old('harga_tiket_masuk') }}"
                                        class="form-input price-input"
                                        inputmode="numeric"
                                        autocomplete="off"
                                        required
                                        placeholder="40.000"
                                        maxlength="15"
                                    >
                                </div>

                                <small class="form-help">
                                    Ketik angka saja. Titik ribuan akan muncul otomatis, misalnya 40000 → 40.000.
                                </small>
                            </div>
                        </div>

                        <div class="glass-card side-card">
                            <div class="side-title">
                                <i class="fas fa-water"></i>
                                <span>Pilih Wahana</span>
                            </div>

                            <p class="side-description">
                                Cari wahana dengan mengetik nama, lalu centang wahana yang ingin dimasukkan.
                            </p>

                            <div class="multi-select" id="wahanaSelect">
                                <button
                                    type="button"
                                    class="multi-trigger"
                                    aria-expanded="false"
                                    aria-haspopup="listbox"
                                >
                                    <span class="multi-trigger-left">
                                        <span class="multi-trigger-icon">
                                            <i class="fas fa-list-check"></i>
                                        </span>
                                        <span class="multi-trigger-text">
                                            <span class="multi-trigger-title" id="wahanaTriggerTitle">Pilih wahana</span>
                                            <span class="multi-trigger-sub" id="wahanaTriggerSub">Buka untuk mencari dan memilih</span>
                                        </span>
                                    </span>
                                    <i class="fas fa-chevron-down multi-trigger-arrow"></i>
                                </button>

                                <div class="multi-panel">
                                    <div class="multi-search">
                                        <i class="fas fa-magnifying-glass"></i>
                                        <input
                                            type="search"
                                            id="wahanaSearch"
                                            placeholder="Ketik nama wahana..."
                                            autocomplete="off"
                                        >
                                    </div>

                                    <div class="multi-options" id="wahanaOptions">
                                        @forelse($wahanas as $wahana)
                                            @php
                                                $wahanaId = $wahana->id_tiket_wahana;
                                                $wahanaNama =
                                                    $wahana->wahana
                                                    ?? $wahana->nama_wahana
                                                    ?? $wahana->nama_tiket
                                                    ?? $wahana->nama
                                                    ?? '-';
                                            @endphp

                                            <label
                                                class="multi-option {{ in_array((string)$wahanaId, array_map('strval', old('wahana_ids', [])), true) ? 'is-checked' : '' }}"
                                                data-search="{{ strtolower($wahanaNama) }}"
                                            >
                                                <input
                                                    type="checkbox"
                                                    name="wahana_ids[]"
                                                    value="{{ $wahanaId }}"
                                                    class="wahana-checkbox"
                                                    {{ in_array((string)$wahanaId, array_map('strval', old('wahana_ids', [])), true) ? 'checked' : '' }}
                                                >
                                                <span class="option-copy">
                                                    <span class="option-name">{{ $wahanaNama }}</span>
                                                </span>
                                                <span class="option-price">
                                                    Rp {{ number_format((int)$wahana->harga, 0, ',', '.') }}
                                                </span>
                                            </label>
                                        @empty
                                            <div class="empty-options">Belum ada wahana tersedia.</div>
                                        @endforelse
                                    </div>

                                    <div class="selection-footer">
                                        <span class="selection-count" id="wahanaCountText">0 wahana dipilih</span>
                                        <button type="button" class="clear-selection" data-clear="wahana">Bersihkan pilihan</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="glass-card side-card">
                            <div class="side-title">
                                <i class="fas fa-utensils"></i>
                                <span>Pilih Menu</span>
                            </div>

                            <p class="side-description">
                                Cari menu dengan mengetik nama. Pilihan tetap dapat dicentang lebih dari satu.
                            </p>

                            <div class="multi-select" id="menuSelect">
                                <button
                                    type="button"
                                    class="multi-trigger"
                                    aria-expanded="false"
                                    aria-haspopup="listbox"
                                >
                                    <span class="multi-trigger-left">
                                        <span class="multi-trigger-icon">
                                            <i class="fas fa-square-check"></i>
                                        </span>
                                        <span class="multi-trigger-text">
                                            <span class="multi-trigger-title" id="menuTriggerTitle">Pilih menu</span>
                                            <span class="multi-trigger-sub" id="menuTriggerSub">Buka untuk mencari dan memilih</span>
                                        </span>
                                    </span>
                                    <i class="fas fa-chevron-down multi-trigger-arrow"></i>
                                </button>

                                <div class="multi-panel">
                                    <div class="multi-search">
                                        <i class="fas fa-magnifying-glass"></i>
                                        <input
                                            type="search"
                                            id="menuSearch"
                                            placeholder="Ketik nama menu..."
                                            autocomplete="off"
                                        >
                                    </div>

                                    <div class="multi-options" id="menuOptions">
                                        @forelse($menus->groupBy('kategori') as $kategori => $items)
                                            <div class="option-group" data-group="{{ strtolower($kategori ?: 'Tanpa Kategori') }}">
                                                <div class="option-group-title">{{ $kategori ?: 'Tanpa Kategori' }}</div>

                                                @foreach($items as $menu)
                                                    @php
                                                        $menuId = $menu->id_menu;
                                                    @endphp

                                                    <label
                                                        class="multi-option {{ in_array((string)$menuId, array_map('strval', old('menu_ids', [])), true) ? 'is-checked' : '' }}"
                                                        data-search="{{ strtolower($menu->nama_menu . ' ' . ($kategori ?: 'tanpa kategori')) }}"
                                                    >
                                                        <input
                                                            type="checkbox"
                                                            name="menu_ids[]"
                                                            value="{{ $menuId }}"
                                                            class="menu-checkbox"
                                                            {{ in_array((string)$menuId, array_map('strval', old('menu_ids', [])), true) ? 'checked' : '' }}
                                                        >

                                                        <span class="option-copy">
                                                            <span class="option-name">{{ $menu->nama_menu }}</span>
                                                            <span class="option-meta">{{ $menu->status ?? 'Tersedia' }}</span>
                                                        </span>

                                                        <span class="option-price">
                                                            Rp {{ number_format((int)$menu->harga, 0, ',', '.') }}
                                                        </span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        @empty
                                            <div class="empty-options">Belum ada menu tersedia.</div>
                                        @endforelse
                                    </div>

                                    <div class="selection-footer">
                                        <span class="selection-count" id="menuCountText">0 menu dipilih</span>
                                        <button type="button" class="clear-selection" data-clear="menu">Bersihkan pilihan</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="glass-card summary-card">
                    <div class="summary-title">
                        <i class="fas fa-layer-group" style="color:var(--accent);font-size:17px;"></i>
                        <span>Komponen Paket</span>
                    </div>

                    <div class="summary-items">
                        <span class="summary-pill">
                            Menu:
                            <strong id="jumlahMenu">0</strong>
                        </span>

                        <span class="summary-pill">
                            Wahana:
                            <strong id="jumlahWahana">0</strong>
                        </span>
                    </div>

                    <p id="componentWarning" class="component-warning">
                        Pilih minimal satu menu atau satu wahana untuk paket bundling.
                    </p>
                </div>

                <div class="form-actions">
                    <a href="{{ url()->previous() }}" class="btn-secondary-travel">
                        Batal
                    </a>

                    <button type="submit" class="btn-primary-travel" id="submitButton">
                        <i class="fas fa-floppy-disk"></i>&nbsp; Simpan Paket Bundling
                    </button>
                </div>

            </form>
        </section>
    </main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formPaketBundling');

    const hargaInput = document.getElementById('harga');
    const ticketPriceInput = document.getElementById('harga_tiket_masuk');

    const warning = document.getElementById('componentWarning');
    const jumlahMenu = document.getElementById('jumlahMenu');
    const jumlahWahana = document.getElementById('jumlahWahana');

    const gambar = document.getElementById('gambar');
    const dropzone = document.getElementById('uploadDropzone');
    const preview = document.getElementById('imagePreview');
    const previewImage = document.getElementById('previewImage');
    const uploadFileName = document.getElementById('uploadFileName');
    const removeImage = document.getElementById('removeImage');

    function digitsOnly(value) {
        return String(value || '').replace(/\D/g, '');
    }

    function formatRupiahInput(value) {
        const digits = digitsOnly(value);
        if (!digits) return '';
        return digits.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function attachPriceFormatter(input) {
        if (!input) return;

        input.value = formatRupiahInput(input.value);

        input.addEventListener('input', function () {
            const start = this.selectionStart;
            const rawBefore = this.value.slice(0, start);
            const digitsBefore = digitsOnly(rawBefore);

            this.value = formatRupiahInput(this.value);

            let newPos = 0;
            let consumed = 0;
            for (let i = 0; i < this.value.length; i++) {
                if (/\d/.test(this.value[i])) {
                    consumed++;
                    if (consumed >= digitsBefore.length) {
                        newPos = i + 1;
                        break;
                    }
                }
            }

            if (digitsBefore.length === 0) newPos = 0;
            this.setSelectionRange(newPos, newPos);
        });

        input.addEventListener('keypress', function (event) {
            if (!/[0-9]/.test(event.key) && !['Backspace','Delete','Tab','ArrowLeft','ArrowRight','Home','End'].includes(event.key)) {
                event.preventDefault();
            }
        });

        input.addEventListener('paste', function (event) {
            event.preventDefault();
            const pasted = (event.clipboardData || window.clipboardData).getData('text');
            this.value = formatRupiahInput(pasted);
        });
    }

    attachPriceFormatter(hargaInput);
    attachPriceFormatter(ticketPriceInput);

    function positionDropdown(container) {
        if (!container) return;

        const panel = container.querySelector('.multi-panel');
        const trigger = container.querySelector('.multi-trigger');
        if (!panel || !trigger) return;

        const isMobile = window.matchMedia('(max-width: 900px)').matches;
        const triggerRect = trigger.getBoundingClientRect();
        const viewportHeight = window.innerHeight || document.documentElement.clientHeight;
        const viewportWidth = window.innerWidth || document.documentElement.clientWidth;
        const edge = isMobile ? 12 : 10;
        const gap = 9;

        // Dropdown selalu turun. Tidak pernah dibalik ke atas.
        if (isMobile) {
            const top = Math.max(edge, triggerRect.bottom + gap);
            const availableBelow = Math.max(180, viewportHeight - top - edge);

            panel.style.position = 'fixed';
            panel.style.left = edge + 'px';
            panel.style.right = edge + 'px';
            panel.style.width = Math.max(0, viewportWidth - (edge * 2)) + 'px';
            panel.style.top = top + 'px';
            panel.style.bottom = 'auto';
            panel.style.maxHeight = Math.min(430, availableBelow) + 'px';
        } else {
            const availableBelow = Math.max(
                180,
                viewportHeight - triggerRect.bottom - edge - gap
            );

            panel.style.position = 'absolute';
            panel.style.left = '0';
            panel.style.right = '0';
            panel.style.width = '100%';
            panel.style.top = 'calc(100% + 9px)';
            panel.style.bottom = 'auto';
            panel.style.maxHeight = Math.min(430, availableBelow) + 'px';
        }
    }

    function openDropdown(container) {
        if (!container) return;

        document.querySelectorAll('.multi-select.open').forEach(function (item) {
            if (item !== container) closeDropdown(item);
        });

        container.classList.add('open');
        container.closest('.side-card')?.classList.add('dropdown-host-open');
        container.querySelector('.multi-trigger')?.setAttribute('aria-expanded', 'true');

        /*
         * Dropdown selalu membuka ke bawah.
         * Pada mobile/tablet panel diposisikan fixed agar tidak terpotong.
         */
        const trigger = container.querySelector('.multi-trigger');

        if (trigger) {
            const rect = trigger.getBoundingClientRect();
            const viewportHeight = window.innerHeight || document.documentElement.clientHeight;
            const minimumSpaceBelow = 300;

            if (viewportHeight - rect.bottom < minimumSpaceBelow) {
                const scrollAmount = Math.min(
                    minimumSpaceBelow - (viewportHeight - rect.bottom) + 24,
                    Math.max(0, document.documentElement.scrollHeight - window.innerHeight - window.scrollY)
                );

                if (scrollAmount > 0) {
                    window.scrollBy({
                        top: scrollAmount,
                        behavior: 'smooth'
                    });

                    window.setTimeout(function () {
                        positionDropdown(container);
                    }, 260);
                } else {
                    positionDropdown(container);
                }
            } else {
                positionDropdown(container);
            }
        }

        const search = container.querySelector('.multi-search input');

        if (search) {
            window.setTimeout(() => search.focus(), 60);
        }
    }

    function closeDropdown(container) {
        if (!container) return;
        container.classList.remove('open');
        container.closest('.side-card')?.classList.remove('dropdown-host-open');
        const panel = container.querySelector('.multi-panel');
        if (panel) {
            panel.style.top = '';
            panel.style.bottom = '';
            panel.style.left = '';
            panel.style.right = '';
            panel.style.width = '';
        }
        container.querySelector('.multi-trigger')?.setAttribute('aria-expanded', 'false');
    }

    function selectionCount(selector) {
        return document.querySelectorAll(selector + ':checked').length;
    }

    function refreshDropdown(container, type) {
        const checkboxSelector = type === 'menu' ? '.menu-checkbox' : '.wahana-checkbox';
        const count = selectionCount(checkboxSelector);
        const title = container.querySelector(type === 'menu' ? '#menuTriggerTitle' : '#wahanaTriggerTitle');
        const sub = container.querySelector(type === 'menu' ? '#menuTriggerSub' : '#wahanaTriggerSub');
        const countText = container.querySelector(type === 'menu' ? '#menuCountText' : '#wahanaCountText');

        if (count === 0) {
            if (title) title.textContent = type === 'menu' ? 'Pilih menu' : 'Pilih wahana';
            if (sub) sub.textContent = 'Buka untuk mencari dan memilih';
        } else {
            if (title) title.textContent = count + (type === 'menu' ? ' menu dipilih' : ' wahana dipilih');
            if (sub) sub.textContent = 'Klik untuk melihat atau menambah pilihan';
        }

        if (countText) countText.textContent = count + (type === 'menu' ? ' menu dipilih' : ' wahana dipilih');
    }

    function refreshSelectionVisuals(scope) {
        scope.querySelectorAll('.multi-option').forEach(function (label) {
            const checkbox = label.querySelector('input[type="checkbox"]');
            label.classList.toggle('is-checked', !!checkbox?.checked);
        });
    }

    function updateSummary() {
        const selectedMenu = selectionCount('.menu-checkbox');
        const selectedWahana = selectionCount('.wahana-checkbox');

        jumlahMenu.textContent = selectedMenu;
        jumlahWahana.textContent = selectedWahana;

        const hasComponent = selectedMenu > 0 || selectedWahana > 0;
        warning.style.display = hasComponent ? 'none' : 'block';

        const menuSelect = document.getElementById('menuSelect');
        const wahanaSelect = document.getElementById('wahanaSelect');

        refreshDropdown(menuSelect, 'menu');
        refreshDropdown(wahanaSelect, 'wahana');
        refreshSelectionVisuals(menuSelect);
        refreshSelectionVisuals(wahanaSelect);
    }

    ['menu','wahana'].forEach(function (type) {
        const container = document.getElementById(type + 'Select');
        const trigger = container?.querySelector('.multi-trigger');
        const search = container?.querySelector('.multi-search input');
        const options = container?.querySelectorAll('.multi-option') || [];

        trigger?.addEventListener('click', function (event) {
            event.stopPropagation();
            container.classList.contains('open')
                ? closeDropdown(container)
                : openDropdown(container);
        });

        container?.addEventListener('click', function (event) {
            event.stopPropagation();
        });

        options.forEach(function (label) {
            const checkbox = label.querySelector('input[type="checkbox"]');
            checkbox?.addEventListener('change', function () {
                refreshSelectionVisuals(container);
                updateSummary();
            });
        });

        search?.addEventListener('input', function () {
            const keyword = this.value.toLowerCase().trim();
            const groups = container.querySelectorAll('.option-group');

            if (groups.length) {
                groups.forEach(function (group) {
                    let visible = 0;
                    group.querySelectorAll('.multi-option').forEach(function (label) {
                        const match = (label.dataset.search || '').includes(keyword);
                        label.style.display = match ? 'flex' : 'none';
                        if (match) visible++;
                    });
                    group.style.display = visible ? '' : 'none';
                });
            } else {
                options.forEach(function (label) {
                    const match = (label.dataset.search || '').includes(keyword);
                    label.style.display = match ? 'flex' : 'none';
                });
            }
        });

        container?.querySelector('[data-clear="' + type + '"]')?.addEventListener('click', function () {
            options.forEach(function (label) {
                const checkbox = label.querySelector('input[type="checkbox"]');
                if (checkbox) checkbox.checked = false;
            });
            if (search) search.value = '';
            options.forEach(function (label) { label.style.display = 'flex'; });
            container.querySelectorAll('.option-group').forEach(function (group) {
                group.style.display = '';
            });
            refreshSelectionVisuals(container);
            updateSummary();
        });
    });

    document.addEventListener('click', function () {
        document.querySelectorAll('.multi-select.open').forEach(closeDropdown);
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            document.querySelectorAll('.multi-select.open').forEach(closeDropdown);
        }
    });

    window.addEventListener('resize', function () {
        document.querySelectorAll('.multi-select.open').forEach(positionDropdown);
    });

    window.addEventListener('scroll', function () {
        document.querySelectorAll('.multi-select.open').forEach(positionDropdown);
    }, { passive:true });

    function showImagePreview(file) {
        if (!file) return;

        if (!['image/jpeg','image/png','image/webp'].includes(file.type)) {
            gambar.value = '';
            alert('File gambar harus berupa JPG, JPEG, PNG, atau WEBP.');
            return;
        }

        const reader = new FileReader();
        reader.onload = function (event) {
            previewImage.src = event.target.result;
            uploadFileName.textContent = file.name;
            dropzone.style.display = 'none';
            preview.classList.add('show');
        };
        reader.readAsDataURL(file);
    }

    gambar?.addEventListener('change', function () {
        showImagePreview(this.files?.[0]);
    });

    ['dragenter','dragover'].forEach(function (eventName) {
        dropzone?.addEventListener(eventName, function (event) {
            event.preventDefault();
            dropzone.classList.add('drag-over');
        });
    });

    ['dragleave','drop'].forEach(function (eventName) {
        dropzone?.addEventListener(eventName, function (event) {
            event.preventDefault();
            dropzone.classList.remove('drag-over');
        });
    });

    dropzone?.addEventListener('drop', function (event) {
        const file = event.dataTransfer?.files?.[0];
        if (!file) return;

        try {
            const dt = new DataTransfer();
            dt.items.add(file);
            gambar.files = dt.files;
        } catch (error) {
            // Browser tidak mendukung pengisian FileList secara programatis.
        }

        showImagePreview(file);
    });

    removeImage?.addEventListener('click', function (event) {
        event.preventDefault();
        event.stopPropagation();
        gambar.value = '';
        previewImage.src = '';
        uploadFileName.textContent = '';
        preview.classList.remove('show');
        dropzone.style.display = 'flex';
    });

    if (form) {
        form.addEventListener('submit', function (event) {
            const selectedMenu = selectionCount('.menu-checkbox');
            const selectedWahana = selectionCount('.wahana-checkbox');

            const rawHarga = Number(digitsOnly(hargaInput?.value));
            const rawTicket = Number(digitsOnly(ticketPriceInput?.value));

            const status = document.getElementById('status');

            if (!status?.value) {
                event.preventDefault();
                status?.focus();
                status?.scrollIntoView({behavior:'smooth', block:'center'});
                alert('Silakan pilih status paket terlebih dahulu.');
                return;
            }

            if (!ticketPriceInput?.value || !digitsOnly(ticketPriceInput.value)) {
                event.preventDefault();
                ticketPriceInput?.focus();
                alert('Silakan masukkan harga tiket masuk.');
                return;
            }

            if (!Number.isFinite(rawTicket) || rawTicket <= 0) {
                event.preventDefault();
                ticketPriceInput?.focus();
                alert('Harga tiket masuk harus berupa angka yang lebih besar dari 0.');
                return;
            }

            if (!Number.isFinite(rawHarga) || rawHarga < 10000 || rawHarga > 500000) {
                event.preventDefault();
                hargaInput?.focus();
                alert('Harga paket harus minimal Rp 10.000 dan maksimal Rp 500.000.');
                return;
            }

            if (selectedMenu === 0 && selectedWahana === 0) {
                event.preventDefault();
                warning.style.display = 'block';
                warning.scrollIntoView({behavior:'smooth', block:'center'});
                alert('Pilih minimal satu menu atau satu wahana.');
                return;
            }

            // Kirim nilai numerik tanpa pemisah titik ke backend.
            hargaInput.value = digitsOnly(hargaInput.value);
            ticketPriceInput.value = digitsOnly(ticketPriceInput.value);

            const submitButton = document.getElementById('submitButton');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>&nbsp; Menyimpan...';
            }
        });
    }

    updateSummary();
});
</script>

</body>
</html>
