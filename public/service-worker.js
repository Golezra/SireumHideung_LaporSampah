const staticCacheName = 'cache-v1.7.0';
const dynamicCacheName = 'runtimeCache-v1.7.0';

// Assets to pre-cache
const precacheAssets = [
    '/',
    'js/pwa.js',
    'manifest.json',
    'fallback.html'
];

// Install Event: Caching static assets
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(staticCacheName).then(cache => {
            return cache.addAll(precacheAssets);
        }).then(() => {
            return self.skipWaiting(); // Memaksa Service Worker baru untuk langsung aktif
        })
    );
});

// Activate Event: Clearing old caches
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(keys => {
            return Promise.all(
                keys.filter(key => key !== staticCacheName && key !== dynamicCacheName)
                    .map(key => caches.delete(key))
            );
        }).then(() => {
            return self.clients.claim(); // Memastikan Service Worker langsung aktif
        })
    );
});

// Fetch Event: Responding to network requests
self.addEventListener('fetch', function (event) {
    event.respondWith(
        caches.match(event.request).then(function (response) {
            return response || fetch(event.request).then(function (networkResponse) {
                if (networkResponse.url.startsWith('http://')) {
                    console.error('Insecure request blocked: ' + networkResponse.url);
                    return caches.match('/fallback.html'); // Fallback ke halaman offline
                }
                return networkResponse;
            }).catch(() => {
                return caches.match('/fallback.html'); // Fallback jika fetch gagal
            });
        })
    );
});

if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/service-worker.js')
        .then(registration => {
            console.log('ServiceWorker registration successful with scope: ', registration.scope);
        })
        .catch(error => {
            console.error('ServiceWorker registration failed: ', error);
        });
}