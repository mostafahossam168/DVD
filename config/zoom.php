<?php

return [
    'account_id' => trim((string) env('ZOOM_ACCOUNT_ID', '')),
    'client_id' => trim((string) env('ZOOM_CLIENT_ID', '')),
    'client_secret' => trim((string) env('ZOOM_CLIENT_SECRET', '')),
    'base_url' => trim((string) env('ZOOM_BASE_URL', 'https://api.zoom.us/v2')),
];

