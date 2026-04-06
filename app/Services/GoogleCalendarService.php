<?php

namespace App\Services;

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use Google\Service\Calendar\EventDateTime;
use App\Models\User;
use Carbon\Carbon;

class GoogleCalendarService
{
    private $client;
    private $service;
    private $user;

    public function __construct(User $user = null)
    {
        $this->client = new Client();
        $this->client->setClientId(config('services.google.calendar_client_id'));
        $this->client->setClientSecret(config('services.google.calendar_client_secret'));
        $this->client->setRedirectUri(config('services.google.calendar_redirect_uri'));
        $this->client->addScope(Calendar::CALENDAR);

        $this->user = $user;
        $this->service = new Calendar($this->client);

        if ($user && $user->google_calendar_token) {
            $this->authenticateUser($user);
        }
    }

    /**
     * Authenticate user with stored Google Calendar token
     */
    public function authenticateUser(User $user)
    {
        $this->user = $user;

        $token = json_decode($user->google_calendar_token, true);
        $this->client->setAccessToken($token);

        // Refresh token if expired
        if ($this->client->isAccessTokenExpired()) {
            $refreshToken = $user->google_calendar_refresh_token ?? $token['refresh_token'] ?? null;

            if ($refreshToken) {
                $this->client->fetchAccessTokenWithRefreshToken($refreshToken);
                $newToken = $this->client->getAccessToken();

                $user->update([
                    'google_calendar_token' => json_encode($newToken),
                    'google_calendar_token_expires_at' => now()->addSeconds($newToken['expires_in'] ?? 3600)
                ]);
            }
        }
    }

    /**
     * Get authorization URL for user to grant access
     */
    public function getAuthorizationUrl()
    {
        return $this->client->createAuthUrl();
    }

    /**
     * Handle OAuth callback and store token
     */
    public function handleAuthorizationCallback($code, User $user)
    {
        try {
            \Log::info('Fetching access token with code: ' . substr($code, 0, 20) . '...');
            $token = $this->client->fetchAccessTokenWithAuthCode($code);

            \Log::info('Token received: ' . json_encode(array_keys($token)));

            $updateData = [
                'google_calendar_token' => json_encode($token),
                'google_calendar_refresh_token' => $token['refresh_token'] ?? null,
                'google_calendar_token_expires_at' => now()->addSeconds($token['expires_in'] ?? 3600)
            ];

            \Log::info('Updating user ' . $user->id . ' with token data');
            $result = $user->update($updateData);

            if ($result) {
                \Log::info('User ' . $user->id . ' updated successfully with Google Calendar token');
                return true;
            } else {
                \Log::error('Failed to update user with token');
                return false;
            }
        } catch (\Exception $e) {
            \Log::error('Google Calendar OAuth error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return false;
        }
    }

    /**
     * Create event in Google Calendar
     */
    public function createEvent($title, $description, $startTime, $endTime, $attendeeEmail = null)
    {
        if (!$this->user || !$this->user->google_calendar_token) {
            return false;
        }

        try {
            $event = new Event([
                'summary' => $title,
                'description' => $description,
                'start' => new EventDateTime([
                    'dateTime' => $startTime->toRfc3339String(),
                    'timeZone' => config('app.timezone'),
                ]),
                'end' => new EventDateTime([
                    'dateTime' => $endTime->toRfc3339String(),
                    'timeZone' => config('app.timezone'),
                ]),
            ]);

            // Add attendee if provided
            if ($attendeeEmail) {
                $event->setAttendees([
                    new \Google\Service\Calendar\EventAttendee([
                        'email' => $attendeeEmail,
                    ])
                ]);
            }

            $createdEvent = $this->service->events->insert('primary', $event, [
                'sendNotifications' => true,
            ]);

            return $createdEvent;
        } catch (\Exception $e) {
            \Log::error('Failed to create Google Calendar event: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Check if user has connected Google Calendar
     */
    public function isConnected()
    {
        if (!$this->user) {
            return false;
        }

        // Refresh user data to ensure we have the latest token info
        if (!$this->user->getAttribute('google_calendar_token')) {
            $this->user->refresh();
        }

        return !is_null($this->user->getAttribute('google_calendar_token'));
    }

    /**
     * Disconnect Google Calendar
     */
    public function disconnect()
    {
        $this->user->update([
            'google_calendar_token' => null,
            'google_calendar_refresh_token' => null,
            'google_calendar_token_expires_at' => null,
        ]);

        return true;
    }
}

