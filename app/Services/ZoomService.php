<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class ZoomService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('zoom.base_url');
    }

    protected function getAccessToken(): string
    {
        $accountId = config('zoom.account_id');
        $clientId = config('zoom.client_id');
        $clientSecret = config('zoom.client_secret');

        if (! $accountId || ! $clientId || ! $clientSecret) {
            throw new \RuntimeException('Zoom credentials are missing from configuration.');
        }

        $response = Http::withBasicAuth($clientId, $clientSecret)
            ->acceptJson()
            ->asForm()
            ->post('https://zoom.us/oauth/token', [
                'grant_type' => 'account_credentials',
                'account_id' => $accountId,
            ]);

        if ($response->failed()) {
            logger()->error('Zoom OAuth token error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        }

        $response->throw();

        return $response->json('access_token');
    }

    protected function client()
    {
        $token = $this->getAccessToken();

        return Http::withToken($token)->baseUrl($this->baseUrl);
    }

    public function createMeeting(array $data, string $userId = 'me'): array
    {
        $startTime = $data['start_time'] instanceof Carbon
            ? $data['start_time']
            : Carbon::parse($data['start_time']);

        $payload = [
            'topic' => $data['topic'],
            'type' => 2,
            'start_time' => $startTime->format('Y-m-d\TH:i:s'),
            'duration' => $data['duration'] ?? 60,
            'password' => $data['password'] ?? null,
            'settings' => [
                'join_before_host' => false,
                'waiting_room' => true,
                'approval_type' => 0,
                'mute_upon_entry' => true,
            ],
        ];

        $response = $this->client()->post("/users/{$userId}/meetings", $payload);

        $response->throw();

        return $response->json();
    }

    public function updateMeeting(string $meetingId, array $data): void
    {
        $payload = [];

        if (isset($data['topic'])) {
            $payload['topic'] = $data['topic'];
        }

        if (isset($data['start_time'])) {
            $startTime = $data['start_time'] instanceof Carbon
                ? $data['start_time']
                : Carbon::parse($data['start_time']);

            $payload['start_time'] = $startTime->format('Y-m-d\TH:i:s');
        }

        if (isset($data['duration'])) {
            $payload['duration'] = $data['duration'];
        }

        if (empty($payload)) {
            return;
        }

        $this->client()->patch("/meetings/{$meetingId}", $payload)->throw();
    }

    public function deleteMeeting(string $meetingId): void
    {
        $this->client()->delete("/meetings/{$meetingId}")->throw();
    }
}

