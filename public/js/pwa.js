/**
 * BankRate ID / Depo Hunter - PWA Client Helper
 * Handles Service Worker registration, Install Prompts, and Online/Offline State
 */

(function () {
    'use strict';

    // 1. Registrasi Service Worker
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/sw.js')
                .then((registration) => {
                    // Check for updates periodically
                    registration.onupdatefound = () => {
                        const installingWorker = registration.installing;
                        if (installingWorker) {
                            installingWorker.onstatechange = () => {
                                if (installingWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                    showPwaUpdateToast();
                                }
                            };
                        }
                    };
                })
                .catch((error) => {
                    console.warn('PWA: Registrasi Service Worker gagal:', error);
                });
        });
    }

    // 2. Install Prompt (beforeinstallprompt)
    let deferredPrompt = null;

    window.addEventListener('beforeinstallprompt', (e) => {
        // Cegah prompt default dari browser
        e.preventDefault();
        deferredPrompt = e;

        // Tampilkan tombol / banner install jika belum di-dismiss baru-baru ini
        const dismissedAt = localStorage.getItem('pwa_install_dismissed');
        const isRecentlyDismissed = dismissedAt && (Date.now() - parseInt(dismissedAt, 10)) < (7 * 24 * 60 * 60 * 1000);

        // Cari elemen tombol install manual di DOM
        const manualInstallBtns = document.querySelectorAll('.btn-pwa-install, #pwaInstallBtn');
        manualInstallBtns.forEach((btn) => {
            btn.style.display = 'inline-flex';
            btn.classList.remove('d-none');
        });

        if (!isRecentlyDismissed) {
            showPwaInstallBanner();
        }
    });

    // Handler klik install global
    window.triggerPwaInstall = function () {
        if (!deferredPrompt) {
            console.log('PWA: Prompt install belum siap atau aplikasi sudah terpasang.');
            return;
        }

        deferredPrompt.prompt();

        deferredPrompt.userChoice.then((choiceResult) => {
            if (choiceResult.outcome === 'accepted') {
                console.log('PWA: Pengguna menerima instalasi aplikasi.');
            } else {
                console.log('PWA: Pengguna menolak instalasi aplikasi.');
            }
            deferredPrompt = null;
            hidePwaInstallBanner();
        });
    };

    window.addEventListener('appinstalled', () => {
        console.log('PWA: Aplikasi BankRate ID berhasil diinstal ke perangkat.');
        deferredPrompt = null;
        hidePwaInstallBanner();

        // Sembunyikan semua tombol install
        const manualInstallBtns = document.querySelectorAll('.btn-pwa-install, #pwaInstallBtn');
        manualInstallBtns.forEach((btn) => {
            btn.style.display = 'none';
        });

        showPwaToast('Aplikasi BankRate ID berhasil dipasang di perangkat Anda!', 'success');
    });

    // 3. Status Online / Offline
    window.addEventListener('online', () => {
        showPwaToast('Koneksi internet kembali normal.', 'online');
        const offlineBanner = document.getElementById('pwa-offline-indicator');
        if (offlineBanner) {
            offlineBanner.remove();
        }
    });

    window.addEventListener('offline', () => {
        showPwaToast('Koneksi internet terputus. Menggunakan data offline.', 'offline');
        showOfflineIndicator();
    });

    // Cek status awal saat load
    if (!navigator.onLine) {
        showOfflineIndicator();
    }

    // Helper: Buat banner install floating yang modern & non-intrusive
    function showPwaInstallBanner() {
        if (document.getElementById('pwa-install-banner')) return;

        const banner = document.createElement('div');
        banner.id = 'pwa-install-banner';
        banner.innerHTML = `
            <div class="pwa-banner-content">
                <div class="pwa-banner-icon">
                    <img src="/icons/icon-72x72.png" alt="BankRate ID" width="40" height="40">
                </div>
                <div class="pwa-banner-text">
                    <strong>Pasang BankRate ID</strong>
                    <p>Akses komparasi bunga deposito lebih cepat langsung dari layar utama.</p>
                </div>
                <div class="pwa-banner-actions">
                    <button type="button" class="pwa-btn-install" id="pwa-action-install">Pasang</button>
                    <button type="button" class="pwa-btn-close" id="pwa-action-dismiss" title="Tutup">&times;</button>
                </div>
            </div>
        `;

        document.body.appendChild(banner);

        // Inject styling banner jika belum ada
        injectPwaStyles();

        // Event listener tombol install & dismiss
        document.getElementById('pwa-action-install')?.addEventListener('click', () => {
            window.triggerPwaInstall();
        });

        document.getElementById('pwa-action-dismiss')?.addEventListener('click', () => {
            hidePwaInstallBanner();
            localStorage.setItem('pwa_install_dismissed', Date.now().toString());
        });
    }

    function hidePwaInstallBanner() {
        const banner = document.getElementById('pwa-install-banner');
        if (banner) {
            banner.classList.add('pwa-hiding');
            setTimeout(() => banner.remove(), 300);
        }
    }

    function showOfflineIndicator() {
        if (document.getElementById('pwa-offline-indicator')) return;

        const indicator = document.createElement('div');
        indicator.id = 'pwa-offline-indicator';
        indicator.innerHTML = `
            <div class="pwa-offline-pill">
                <span class="pwa-dot-red"></span>
                <span>Mode Offline Aktif</span>
            </div>
        `;
        document.body.appendChild(indicator);
        injectPwaStyles();
    }

    function showPwaToast(message, type) {
        const toast = document.createElement('div');
        toast.className = `pwa-toast pwa-toast-${type || 'info'}`;
        toast.textContent = message;
        document.body.appendChild(toast);
        injectPwaStyles();

        setTimeout(() => {
            toast.classList.add('pwa-toast-show');
        }, 10);

        setTimeout(() => {
            toast.classList.remove('pwa-toast-show');
            setTimeout(() => toast.remove(), 300);
        }, 4000);
    }

    function showPwaUpdateToast() {
        showPwaToast('Versi baru tersedia! Muat ulang untuk memperbarui.', 'info');
    }

    function injectPwaStyles() {
        if (document.getElementById('pwa-injected-styles')) return;

        const style = document.createElement('style');
        style.id = 'pwa-injected-styles';
        style.textContent = `
            #pwa-install-banner {
                position: fixed;
                bottom: 20px;
                left: 50%;
                transform: translateX(-50%);
                z-index: 99999;
                max-width: 480px;
                width: calc(100% - 32px);
                background: #0f172a;
                border: 1px solid rgba(255, 255, 255, 0.15);
                border-radius: 16px;
                box-shadow: 0 12px 35px rgba(0, 0, 0, 0.45);
                color: #ffffff;
                animation: pwaSlideUp 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            }
            #pwa-install-banner.pwa-hiding {
                animation: pwaSlideDown 0.3s cubic-bezier(0.7, 0, 0.84, 0) forwards;
            }
            .pwa-banner-content {
                display: flex;
                align-items: center;
                padding: 12px 16px;
                gap: 12px;
            }
            .pwa-banner-icon img {
                border-radius: 10px;
                box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3);
            }
            .pwa-banner-text {
                flex: 1;
                min-width: 0;
            }
            .pwa-banner-text strong {
                display: block;
                font-size: 0.95rem;
                font-weight: 700;
                color: #ffffff;
                line-height: 1.2;
            }
            .pwa-banner-text p {
                margin: 2px 0 0;
                font-size: 0.78rem;
                color: #94a3b8;
                line-height: 1.3;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            .pwa-banner-actions {
                display: flex;
                align-items: center;
                gap: 8px;
            }
            .pwa-btn-install {
                background: linear-gradient(135deg, #4f46e5, #6366f1);
                color: #ffffff;
                border: none;
                border-radius: 8px;
                padding: 8px 16px;
                font-size: 0.85rem;
                font-weight: 700;
                cursor: pointer;
                transition: transform 0.15s ease;
                white-space: nowrap;
            }
            .pwa-btn-install:hover {
                transform: scale(1.03);
            }
            .pwa-btn-close {
                background: transparent;
                border: none;
                color: #94a3b8;
                font-size: 1.3rem;
                cursor: pointer;
                padding: 0 4px;
                line-height: 1;
            }
            .pwa-btn-close:hover {
                color: #ffffff;
            }
            #pwa-offline-indicator {
                position: fixed;
                top: 14px;
                right: 14px;
                z-index: 99999;
                pointer-events: none;
            }
            .pwa-offline-pill {
                background: rgba(15, 23, 42, 0.9);
                border: 1px solid rgba(239, 68, 68, 0.5);
                backdrop-filter: blur(8px);
                color: #f87171;
                font-size: 0.78rem;
                font-weight: 600;
                padding: 6px 12px;
                border-radius: 20px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
                display: flex;
                align-items: center;
                gap: 6px;
            }
            .pwa-dot-red {
                width: 8px;
                height: 8px;
                border-radius: 50%;
                background-color: #ef4444;
                animation: pwaBlink 1.5s infinite;
            }
            .pwa-toast {
                position: fixed;
                bottom: 24px;
                right: 24px;
                z-index: 99999;
                padding: 12px 18px;
                border-radius: 10px;
                font-size: 0.88rem;
                font-weight: 600;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
                opacity: 0;
                transform: translateY(20px);
                transition: opacity 0.3s ease, transform 0.3s ease;
            }
            .pwa-toast-show {
                opacity: 1;
                transform: translateY(0);
            }
            .pwa-toast-online, .pwa-toast-success {
                background: #065f46;
                color: #ffffff;
                border: 1px solid #10b981;
            }
            .pwa-toast-offline {
                background: #7f1d1d;
                color: #ffffff;
                border: 1px solid #ef4444;
            }
            .pwa-toast-info {
                background: #1e3a8a;
                color: #ffffff;
                border: 1px solid #3b82f6;
            }
            @keyframes pwaSlideUp {
                from { opacity: 0; transform: translate(-50%, 30px); }
                to { opacity: 1; transform: translate(-50%, 0); }
            }
            @keyframes pwaSlideDown {
                from { opacity: 1; transform: translate(-50%, 0); }
                to { opacity: 0; transform: translate(-50%, 30px); }
            }
            @keyframes pwaBlink {
                0%, 100% { opacity: 1; }
                50% { opacity: 0.4; }
            }
        `;
        document.head.appendChild(style);
    }
})();
