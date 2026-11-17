/**
 * Service Worker for BankRate ID / Depo Hunter PWA
 * Version: bankrate-pwa-v1.0.0
 */

const CACHE_NAME = 'bankrate-pwa-v1.0.0';
const OFFLINE_URL = '/offline.html';

// Static assets to pre-cache on install
const PRECACHE_ASSETS = [
    '/',
    OFFLINE_URL,
    '/manifest.json',
    '/favicon.ico',
    '/icons/icon-192x192.png',
    '/icons/icon-512x512.png',
    '/icons/icon-maskable-192x192.png',
    '/icons/apple-touch-icon.png',
    '/icons/icon.svg',
    '/css/admin-custom.css',
    '/css/rate-matrix.css',
    '/js/pwa.js'
];

/**
 * 1. Install Event: Pre-cache static shell & offline fallback
 */
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(PRECACHE_ASSETS).catch((err) => {
                console.warn('PWA Pre-cache non-critical item failed:', err);
            });
        }).then(() => self.skipWaiting())
    );
});

/**
 * 2. Activate Event: Clean up outdated caches
 */
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((name) => {
                    if (name !== CACHE_NAME) {
                        return caches.delete(name);
                    }
                })
            );
        }).then(() => self.clients.claim())
    );
});

/**
 * 3. Fetch Event: Smart Caching Strategy
 * - Navigation (HTML pages): Network first, fallback to cache, then fallback to /offline.html
 * - Static Assets (CSS, JS, Fonts, Images): Stale-While-Revalidate / Cache First
 * - API & POST requests: Network only
 */
self.addEventListener('fetch', (event) => {
    const request = event.request;

    // Only handle GET requests; skip POST, PUT, DELETE, etc.
    if (request.method !== 'GET') {
        return;
    }

    const url = new URL(request.url);

    // Skip chrome-extension, internal schemes, and non-http(s)
    if (!url.protocol.startsWith('http')) {
        return;
    }

    // A. Handle Page Navigation (HTML)
    if (request.mode === 'navigate') {
        event.respondWith(
            fetch(request)
                .then((networkResponse) => {
                    if (networkResponse && networkResponse.status === 200) {
                        const responseClone = networkResponse.clone();
                        caches.open(CACHE_NAME).then((cache) => {
                            cache.put(request, responseClone);
                        });
                    }
                    return networkResponse;
                })
                .catch(async () => {
                    // Try to get from cache first
                    const cachedResponse = await caches.match(request);
                    if (cachedResponse) {
                        return cachedResponse;
                    }
                    // Otherwise return offline fallback page
                    return caches.match(OFFLINE_URL);
                })
        );
        return;
    }

    // B. Handle Static Assets (Images, CSS, JS, Fonts)
    const isStaticAsset = (
        request.destination === 'style' ||
        request.destination === 'script' ||
        request.destination === 'image' ||
        request.destination === 'font' ||
        url.pathname.startsWith('/icons/') ||
        url.pathname.endsWith('.css') ||
        url.pathname.endsWith('.js') ||
        url.pathname.endsWith('.png') ||
        url.pathname.endsWith('.svg') ||
        url.pathname.endsWith('.ico')
    );

    if (isStaticAsset) {
        event.respondWith(
            caches.match(request).then((cachedResponse) => {
                // Return cached version immediately if available
                const fetchPromise = fetch(request).then((networkResponse) => {
                    if (networkResponse && networkResponse.status === 200) {
                        const responseClone = networkResponse.clone();
                        caches.open(CACHE_NAME).then((cache) => {
                            cache.put(request, responseClone);
                        });
                    }
                    return networkResponse;
                }).catch(() => {
                    // Offline and no network
                });

                return cachedResponse || fetchPromise;
            })
        );
        return;
    }

    // C. Default: Network with Cache Fallback
    event.respondWith(
        fetch(request)
            .then((networkResponse) => {
                if (networkResponse && networkResponse.status === 200) {
                    const responseClone = networkResponse.clone();
                    caches.open(CACHE_NAME).then((cache) => {
                        cache.put(request, responseClone);
                    });
                }
                return networkResponse;
            })
            .catch(() => caches.match(request))
    );
});

/**
 * 4. Push Notification Support (Optional background push sync)
 */
self.addEventListener('push', (event) => {
    if (!event.data) return;

    let payload = {};
    try {
        payload = event.data.json();
    } catch (e) {
        payload = { title: 'BankRate ID', body: event.data.text() };
    }

    const title = payload.title || 'BankRate ID - Update Suku Bunga';
    const options = {
        body: payload.body || 'Cek pembaruan suku bunga deposito terkini.',
        icon: '/icons/icon-192x192.png',
        badge: '/icons/icon-72x72.png',
        data: {
            url: payload.url || '/'
        }
    };

    event.waitUntil(self.registration.showNotification(title, options));
});

self.addEventListener('notificationclick', (event) => {
    event.notification.close();
    const targetUrl = event.notification.data?.url || '/';

    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then((clientList) => {
            for (const client of clientList) {
                if (client.url === targetUrl && 'focus' in client) {
                    return client.focus();
                }
            }
            if (clients.openWindow) {
                return clients.openWindow(targetUrl);
            }
        })
    );
});
