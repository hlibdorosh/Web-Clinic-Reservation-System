# Quick Reference - Google Calendar Integration

## 5-Minute Setup

### 1. Install Package
```bash
composer require google/apiclient
```

### 2. Get Google Credentials
- Go to: https://console.cloud.google.com/
- Create new project → Name it "InterKlinik"
- Enable Google Calendar API
- Create OAuth 2.0 Web credentials
- Note down: Client ID and Client Secret
- Add Redirect URI: `http://localhost:8000/auth/google/callback`

### 3. Update .env
```
GOOGLE_CALENDAR_CLIENT_ID=your_client_id
GOOGLE_CALENDAR_CLIENT_SECRET=your_client_secret
GOOGLE_CALENDAR_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

### 4. Run Migration
```bash
php artisan migrate
```

### 5. Add Profile Button
Copy this into `resources/views/profile/edit.blade.php`:

```blade
<div class="mt-6">
    <h3 class="text-lg font-semibold mb-4">Google Calendar</h3>
    @if(auth()->user()->google_calendar_token)
        <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded flex justify-between">
            <span>✓ Connected</span>
            <form method="POST" action="{{ route('google.calendar.disconnect') }}">
                @csrf
                <button type="submit" class="underline text-sm">Disconnect</button>
            </form>
        </div>
    @else
        <a href="{{ route('google.calendar.redirect') }}" 
           class="text-blue-600 underline">Connect Calendar</a>
    @endif
</div>
```

## Files Modified/Created

✓ Created: `app/Services/GoogleCalendarService.php`
✓ Created: `app/Http/Controllers/Auth/GoogleCalendarAuthController.php`
✓ Created: Database migration (add Google columns)
✓ Updated: `app/Http/Controllers/Doctor/ReservationController.php` (confirm method)
✓ Updated: `config/services.php` (Google config)
✓ Updated: `routes/web.php` (OAuth routes)
✓ Updated: `.env` (Google credentials)

## How It Works

1. **Patient Profile** → Click "Connect Calendar"
2. **Redirected** → Google OAuth screen
3. **Patient Authorizes** → Token saved to database
4. **Doctor Confirms** → Email sent + Calendar event created
5. **Automatic** → Tokens refreshed before expiry

## Email + Calendar

When doctor confirms:
- ✓ Email notification sent (already working)
- ✓ Calendar event created (if patient connected)
  - Date & Time
  - Doctor Name
  - Service Name
  - Department
  - Room Number

## Testing Flow

1. Create doctor account
2. Create department/cabinet/service
3. Doctor creates term
4. Create patient account
5. Patient connects Google Calendar (click button in profile)
6. Patient books appointment
7. Doctor confirms appointment
8. Check patient's Google Calendar - event appears!

## Environment Setup

```bash
# Development (localhost)
GOOGLE_CALENDAR_REDIRECT_URI=http://localhost:8000/auth/google/callback

# Production
GOOGLE_CALENDAR_REDIRECT_URI=https://yourdomain.com/auth/google/callback
```

## Troubleshoot

| Issue | Solution |
|-------|----------|
| "Class not found" | Run `composer require google/apiclient` |
| "Invalid Client" | Check Client ID/Secret in .env match Google Console |
| "Redirect URI mismatch" | Copy exact URL from Google Console to .env |
| Event not appearing | Verify patient has Calendar connected in profile |
| Token errors | Check logs: `storage/logs/laravel.log` |

## Notes

- Tokens stored encrypted in database ✓
- Automatic token refresh ✓
- Secure OAuth flow ✓
- No hardcoded credentials ✓

Ready to go! 🚀

