# GOOGLE CALENDAR SETUP GUIDE

## Step 1: Set Up Google Cloud Project

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project:
   - Click on "Select a Project" (top left)
   - Click "NEW PROJECT"
   - Name it "InterKlinik Calendar"
   - Click "CREATE"

3. Enable Google Calendar API:
   - Go to "APIs & Services" > "Library"
   - Search for "Google Calendar API"
   - Click on it and press "ENABLE"

## Step 2: Create OAuth 2.0 Credentials

1. Go to "APIs & Services" > "Credentials"
2. Click "CREATE CREDENTIALS" > "OAuth client ID"
3. If prompted, configure the OAuth consent screen first:
   - Choose "External"
   - Fill in the app name: "InterKlinik"
   - Add your email for support
   - Add scopes: Search for "Calendar" and select `calendar`
   - Add test users (your email)
   - Save and continue

4. Back to creating credentials:
   - Application type: "Web application"
   - Name: "InterKlinik Calendar"
   - Authorized JavaScript origins:
     - `http://localhost:8000`
     - `http://127.0.0.1:8000`
   - Authorized redirect URIs:
     - `http://localhost:8000/auth/google/callback`
     - `http://127.0.0.1:8000/auth/google/callback`
   - Click "CREATE"

5. Download the credentials (you'll see Client ID and Client Secret)

## Step 3: Update .env File

Add these to your `.env` file:

```
GOOGLE_CALENDAR_CLIENT_ID=your_client_id_here
GOOGLE_CALENDAR_CLIENT_SECRET=your_client_secret_here
GOOGLE_CALENDAR_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

## Step 4: Run Migrations

```bash
php artisan migrate
```

This will add the `google_calendar_token`, `google_calendar_refresh_token`, and `google_calendar_token_expires_at` columns to the users table.

## Step 5: Update User Model

Make sure your User model has the new columns (already done in migration):
- `google_calendar_token` - stores the OAuth access token
- `google_calendar_refresh_token` - stores the refresh token
- `google_calendar_token_expires_at` - stores token expiration time

## Step 6: Add Google Calendar Connection to Profile

Add a button in the user profile to connect Google Calendar. Add this to the profile edit page:

```blade
@if(auth()->user()->google_calendar_token)
    <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded mb-4">
        ✓ Google Calendar Connected
        <form method="POST" action="{{ route('google.calendar.disconnect') }}" style="display:inline;">
            @csrf
            <button type="submit" class="ml-2 text-sm font-medium underline">Disconnect</button>
        </form>
    </div>
@else
    <div class="p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded mb-4">
        <a href="{{ route('google.calendar.redirect') }}" class="font-medium underline">Connect Google Calendar</a>
        to receive appointment reminders in your Google Calendar
    </div>
@endif
```

## How It Works

1. **Patient connects Google Calendar:**
   - Click "Connect Google Calendar" button
   - Redirected to Google OAuth consent screen
   - User grants permission
   - Token stored in database

2. **Doctor confirms appointment:**
   - Doctor clicks "Confirm" button
   - Patient receives email notification (already implemented)
   - If patient has Google Calendar connected:
     - Event automatically added to patient's Google Calendar
     - Event includes: appointment time, doctor name, service, department, room number

3. **Token Management:**
   - Access tokens are automatically refreshed when expired
   - Refresh tokens stored securely in database
   - Uses Laravel's built-in encryption

## Security Notes

- Never commit .env file with credentials to Git
- Keep credentials in .env file on server
- Access tokens are encrypted in database
- Use HTTPS in production for OAuth

## Testing

1. Create a test patient account
2. Go to profile and click "Connect Google Calendar"
3. Authorize with your Google account
4. Create a term and make a reservation
5. As doctor, confirm the reservation
6. Check your Google Calendar - the event should appear!

## Troubleshooting

- **"Invalid Client" error**: Double-check Client ID and Secret in .env
- **Redirect URI mismatch**: Make sure callback URL matches exactly in both code and Google Cloud Console
- **Token expired**: System automatically refreshes, but check logs if issues persist
- **Event not appearing**: Check if patient has Google Calendar connected in profile

