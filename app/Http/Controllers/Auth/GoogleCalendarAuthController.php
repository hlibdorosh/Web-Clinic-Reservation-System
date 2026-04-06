<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\GoogleCalendarService;
use Illuminate\Http\Request;

class GoogleCalendarAuthController extends Controller
{
    /**
     * Redirect to Google OAuth consent screen
     */
    public function redirect()
    {
        $googleCalendar = new GoogleCalendarService(auth()->user());
        $authUrl = $googleCalendar->getAuthorizationUrl();

        return redirect()->away($authUrl);
    }

    /**
     * Handle OAuth callback
     */
    public function callback(Request $request)
    {
        $code = $request->query('code');
        $state = $request->query('state');

        if (!$code) {
            return redirect()->route('profile.edit')
                ->with('error', 'Failed to authorize Google Calendar access');
        }

        $googleCalendar = new GoogleCalendarService(auth()->user());

        if ($googleCalendar->handleAuthorizationCallback($code, auth()->user())) {
            return redirect()->route('profile.edit')
                ->with('success', 'Google Calendar connected successfully!');
        }

        return redirect()->route('profile.edit')
            ->with('error', 'Failed to connect Google Calendar. Please try again.');
    }

    /**
     * Disconnect Google Calendar
     */
    public function disconnect()
    {
        $googleCalendar = new GoogleCalendarService(auth()->user());
        $googleCalendar->disconnect();

        return redirect()->route('profile.edit')
            ->with('success', 'Google Calendar disconnected.');
    }
}

