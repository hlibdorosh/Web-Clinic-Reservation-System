# Google Calendar Integration - Complete Implementation Guide

## What Has Been Done

I've set up Google Calendar integration for your InterKlinik application. Here's what was implemented:

### 1. **Database Changes**
   - Created migration: `2026_04_06_000000_add_google_calendar_to_users.php`
   - Adds 3 new columns to `users` table:
     - `google_calendar_token` - stores encrypted OAuth token
     - `google_calendar_refresh_token` - stores refresh token for token renewal
     - `google_calendar_token_expires_at` - tracks token expiration

### 2. **Google Calendar Service** (`app/Services/GoogleCalendarService.php`)
   - Handles all Google Calendar API interactions
   - Features:
     - OAuth authentication and token management
     - Automatic token refresh when expired
     - Create events in patient's calendar
     - Connect/disconnect functionality
     - Error handling with logging

### 3. **Authentication Controller** (`app/Http/Controllers/Auth/GoogleCalendarAuthController.php`)
   - `redirect()` - Redirects user to Google OAuth consent screen
   - `callback()` - Handles OAuth callback and stores token
   - `disconnect()` - Removes Google Calendar connection

### 4. **Reservation Controller Updates** (`app/Http/Controllers/Doctor/ReservationController.php`)
   - When doctor confirms a reservation:
     1. Email is sent to patient (already working)
     2. If patient has Google Calendar connected:
        - Event automatically created in patient's calendar
        - Event includes: appointment time, doctor name, service, department, room number

### 5. **Routes** (web.php)
   - `GET /auth/google/redirect` - Start OAuth flow
   - `GET /auth/google/callback` - Handle OAuth callback
   - `POST /auth/google/disconnect` - Disconnect calendar

### 6. **Configuration** (config/services.php)
   - Added Google Calendar service configuration
   - Reads from environment variables

### 7. **Environment Configuration** (.env)
   - Added placeholders for Google Calendar credentials

## What You Need to Do

### Step 1: Install Google API Client Library

Run this command in your project directory:
```bash
composer require google/apiclient
```

### Step 2: Set Up Google Cloud Project

Follow the detailed guide in `GOOGLE_CALENDAR_SETUP.md`:

1. Create a Google Cloud Project
2. Enable Google Calendar API
3. Create OAuth 2.0 credentials
4. Get Client ID and Client Secret
5. Add authorized redirect URIs

### Step 3: Update .env File

Replace the placeholders with your actual credentials:

```
GOOGLE_CALENDAR_CLIENT_ID=your_actual_client_id
GOOGLE_CALENDAR_CLIENT_SECRET=your_actual_client_secret
GOOGLE_CALENDAR_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

### Step 4: Run Database Migration

```bash
php artisan migrate
```

This will create the necessary columns in the `users` table.

### Step 5: Add UI Button to Profile

Add this to your profile edit page (`resources/views/profile/edit.blade.php`):

```blade
<div class="mt-6">
    <h3 class="text-lg font-semibold mb-4">Google Calendar Integration</h3>
    
    @if(auth()->user()->google_calendar_token)
        <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded mb-4 flex justify-between items-center">
            <span>✓ Google Calendar Connected</span>
            <form method="POST" action="{{ route('google.calendar.disconnect') }}">
                @csrf
                <button type="submit" class="text-sm font-medium underline hover:no-underline">
                    Disconnect
                </button>
            </form>
        </div>
    @else
        <div class="p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded">
            <a href="{{ route('google.calendar.redirect') }}" 
               class="font-medium hover:underline">
                Connect Google Calendar
            </a>
            to automatically receive appointment reminders
        </div>
    @endif
</div>
```

## How It Works in Practice

### For Patients:
1. Log in to their profile
2. Click "Connect Google Calendar"
3. Authorize the application to access their calendar
4. Token is securely stored in the database

### When a Doctor Confirms an Appointment:
1. Doctor clicks "Confirm" button on pending reservation
2. Patient receives email notification (with all appointment details)
3. If patient has Google Calendar connected:
   - Event is automatically added to their primary calendar
   - Event includes: appointment date/time, doctor name, service, department, room number
   - Patient can set reminders from Google Calendar

### Token Management:
- Access tokens are automatically refreshed before expiry
- All tokens are encrypted in the database
- No security risk even if database is compromised

## File Structure

New files created:
```
app/
  Services/
    GoogleCalendarService.php (handles all calendar operations)
  Http/Controllers/Auth/
    GoogleCalendarAuthController.php (handles OAuth flow)

database/
  migrations/
    2026_04_06_000000_add_google_calendar_to_users.php

config/
  services.php (updated with Google config)

routes/
  web.php (updated with new routes)

.env (updated with Google credentials placeholders)

GOOGLE_CALENDAR_SETUP.md (detailed setup guide)
```

## Security Considerations

✓ OAuth tokens are encrypted in database
✓ Refresh tokens stored securely
✓ No hardcoded credentials
✓ Uses Laravel's built-in encryption
✓ Automatic token refresh before expiry
✓ Users can disconnect anytime

## Testing Checklist

- [ ] Run `composer require google/apiclient`
- [ ] Create Google Cloud Project and get credentials
- [ ] Update .env with credentials
- [ ] Run `php artisan migrate`
- [ ] Add profile UI button (copy code from Step 5 above)
- [ ] Test: Patient connects Google Calendar
- [ ] Test: Create reservation and confirm it
- [ ] Test: Check patient's Google Calendar for the event
- [ ] Test: Disconnect Google Calendar
- [ ] Test: Verify email still sends even without calendar

## Troubleshooting

**"Class not found" error?**
- Run `composer require google/apiclient` first

**"Invalid Client" error?**
- Check Client ID and Secret match exactly in .env and Google Cloud Console
- Make sure .env is loaded (`php artisan config:clear`)

**Redirect URI mismatch?**
- Ensure `GOOGLE_CALENDAR_REDIRECT_URI` in .env matches exactly in Google Cloud Console
- Include protocol (http:// or https://)

**Event not appearing in calendar?**
- Check if patient actually clicked "Connect Google Calendar"
- Verify patient's email is correct in database
- Check Laravel logs for errors

**Token expired?**
- System handles this automatically
- If issues persist, patient should disconnect and reconnect

## Next Steps

1. Complete the Google Cloud setup (see GOOGLE_CALENDAR_SETUP.md)
2. Update .env with credentials
3. Run migration: `php artisan migrate`
4. Add the profile UI button
5. Test the entire flow!

Happy scheduling! 🗓️

