# 🚀 STEP-BY-STEP IMPLEMENTATION GUIDE

## Complete Instructions to Add Google Calendar Integration

### ⏱️ Total Time: ~20-30 minutes

---

## STEP 1: GET GOOGLE CLOUD CREDENTIALS (10 minutes)

### 1.1 Create Google Cloud Project

1. Go to: https://console.cloud.google.com/
2. Click **"Select a Project"** at the top
3. Click **"NEW PROJECT"**
4. Project name: `InterKlinik`
5. Click **"CREATE"**
6. Wait for it to load (1-2 minutes)

### 1.2 Enable Google Calendar API

1. In the top search bar, type: `Google Calendar API`
2. Click on "Google Calendar API" from results
3. Click **"ENABLE"**
4. Wait for it to load

### 1.3 Create OAuth Credentials

1. Go to: **APIs & Services** → **Credentials** (left menu)
2. Click **"+ CREATE CREDENTIALS"** → **OAuth client ID**
3. If prompted for OAuth consent screen:
   - Choose **"External"**
   - Click **"CREATE"**
   - Fill in:
     - App name: `InterKlinik`
     - User support email: `your@email.com`
     - Click **"SAVE AND CONTINUE"**
   - Click **"ADD OR REMOVE SCOPES"**
   - Search for: `calendar`
   - Select: `Google Calendar API` (all scopes)
   - Click **"UPDATE"** → **"SAVE AND CONTINUE"**
   - Add test users: Add your email
   - Click **"SAVE AND CONTINUE"** → **"BACK TO DASHBOARD"**

4. Now create credentials:
   - Click **"+ CREATE CREDENTIALS"** → **OAuth client ID**
   - Application type: **"Web application"**
   - Name: `InterKlinik Calendar`
   - **Authorized JavaScript origins:**
     - `http://localhost:8000`
     - `http://127.0.0.1:8000`
   - **Authorized redirect URIs:**
     - `http://localhost:8000/auth/google/callback`
     - `http://127.0.0.1:8000/auth/google/callback`
   - Click **"CREATE"**

5. Copy your credentials:
   - You'll see a popup with **Client ID** and **Client Secret**
   - **COPY BOTH VALUES** (you'll need them in 2 minutes)
   - You can also download JSON file for reference

✅ **STEP 1 COMPLETE** - You have Client ID and Client Secret

---

## STEP 2: INSTALL COMPOSER PACKAGE (2 minutes)

Open Terminal/CMD in your project folder and run:

```bash
composer require google/apiclient
```

Wait for it to complete (should take 1-2 minutes).

✅ **STEP 2 COMPLETE** - Google API client installed

---

## STEP 3: UPDATE .ENV FILE (3 minutes)

1. Open the `.env` file in your project root
2. Scroll to the bottom
3. Find this section:
   ```
   GOOGLE_CALENDAR_CLIENT_ID=your_client_id_here
   GOOGLE_CALENDAR_CLIENT_SECRET=your_client_secret_here
   GOOGLE_CALENDAR_REDIRECT_URI=http://localhost:8000/auth/google/callback
   ```

4. Replace with your actual values from Google Cloud:
   ```
   GOOGLE_CALENDAR_CLIENT_ID=your-actual-client-id-from-google
   GOOGLE_CALENDAR_CLIENT_SECRET=your-actual-secret-from-google
   GOOGLE_CALENDAR_REDIRECT_URI=http://localhost:8000/auth/google/callback
   ```

5. **Save the file**

**⚠️ IMPORTANT:** Make sure there are NO QUOTES around the values!

✅ **STEP 3 COMPLETE** - .env configured

---

## STEP 4: RUN DATABASE MIGRATION (2 minutes)

In Terminal/CMD in your project folder, run:

```bash
php artisan migrate
```

You should see output like:
```
Migrating: 2026_04_06_000000_add_google_calendar_to_users
Migrated: 2026_04_06_000000_add_google_calendar_to_users
```

This adds 3 new columns to your `users` table to store Google Calendar data.

✅ **STEP 4 COMPLETE** - Database updated

---

## STEP 5: ADD UI BUTTON TO PROFILE (5 minutes)

1. Open: `resources/views/profile/edit.blade.php`
2. Find the end of the file (look for `</x-app-layout>`)
3. Add this code BEFORE the closing tag:

```blade
<!-- Google Calendar Integration Section -->
<div class="p-6 max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
    <div class="bg-white shadow sm:rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Google Calendar Integration</h3>
        
        @if(auth()->user()->google_calendar_token)
            <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded mb-4 flex justify-between items-center">
                <span class="font-medium">✓ Google Calendar Connected</span>
                <form method="POST" action="{{ route('google.calendar.disconnect') }}">
                    @csrf
                    <button type="submit" class="text-sm font-medium underline hover:no-underline">
                        Disconnect
                    </button>
                </form>
            </div>
            <p class="text-sm text-gray-600">
                Appointments will be automatically added to your Google Calendar when confirmed.
            </p>
        @else
            <div class="p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded">
                <p class="mb-3">
                    <a href="{{ route('google.calendar.redirect') }}" 
                       class="font-medium hover:underline inline-flex items-center">
                        🔗 Connect Google Calendar
                    </a>
                </p>
                <p class="text-sm">
                    Automatically receive appointment confirmations and reminders in your Google Calendar.
                </p>
            </div>
        @endif
    </div>
</div>
```

4. **Save the file**

✅ **STEP 5 COMPLETE** - UI button added

---

## STEP 6: CLEAR CACHE (1 minute)

In Terminal/CMD, run:

```bash
php artisan config:clear
php artisan cache:clear
```

This ensures Laravel loads your new .env values.

✅ **STEP 6 COMPLETE** - Cache cleared

---

## STEP 7: TEST THE INTEGRATION (5 minutes)

### 7.1 Start Your Application

Make sure your Laravel app is running:
```bash
php artisan serve
```

### 7.2 Test as a Patient

1. **Log in as a patient** (or create a new account)
2. Go to: `http://localhost:8000/profile`
3. Scroll down to "Google Calendar Integration"
4. Click **"Connect Google Calendar"**
5. You'll be redirected to Google
6. **Click "Allow"** to authorize
7. You should see: **"✓ Google Calendar Connected"**

### 7.3 Book an Appointment

1. As the same patient, go to browse doctors/terms
2. Book an appointment with any available term
3. Status should show: **"Pending"**

### 7.4 Confirm as Doctor

1. **Log in as a doctor**
2. Go to: `http://localhost:8000/doctor/terms`
3. Find the pending reservation from the patient
4. Click **"Confirm"** button
5. You should see: **"Reservation confirmed"**

### 7.5 Verify Results

1. Check patient's **email** - should have confirmation email
2. Check patient's **Google Calendar** - appointment should appear!
3. Event should show:
   - Date & Time
   - Doctor Name
   - Service
   - Department
   - Room Number

✅ **STEP 7 COMPLETE** - Integration tested and working!

---

## 📋 CHECKLIST

Before you start:
- [ ] You have Google Cloud account
- [ ] You're in the correct project directory

During setup:
- [ ] Created Google Cloud project
- [ ] Enabled Google Calendar API
- [ ] Created OAuth credentials
- [ ] Copied Client ID and Secret
- [ ] Ran `composer require google/apiclient`
- [ ] Updated .env file with credentials
- [ ] Ran `php artisan migrate`
- [ ] Added UI button to profile
- [ ] Ran `php artisan config:clear`
- [ ] Started app with `php artisan serve`

Testing:
- [ ] Patient can connect Google Calendar
- [ ] Patient can book appointment
- [ ] Doctor can confirm appointment
- [ ] Email notification sent
- [ ] Calendar event appears in Google Calendar

---

## 🎉 SUCCESS!

If you've completed all steps and tested successfully, you now have:

✅ Email notifications working (already was)
✅ Google Calendar integration added
✅ Automatic event creation when appointment confirmed
✅ Secure OAuth 2.0 authentication
✅ Token management and refresh

---

## 🆘 TROUBLESHOOTING

### "Failed to require google/apiclient"
- Make sure you're in the correct project directory
- Run: `composer update`

### "Redirect URI mismatch" error
- Copy the EXACT URL from error message
- Add it to Google Cloud Console
- Make sure it's exactly: `http://localhost:8000/auth/google/callback`

### "Invalid Client" error
- Check Client ID and Secret in .env match Google Cloud
- Run: `php artisan config:clear`
- Clear browser cookies

### Calendar event not appearing
- Check that patient actually clicked "Connect Google Calendar"
- Verify patient email is correct in database
- Check browser console for JavaScript errors
- Check Laravel logs: `storage/logs/laravel.log`

### Still not working?
- Check the detailed guide: `GOOGLE_CALENDAR_INTEGRATION.md`
- Check quick reference: `QUICK_START_GOOGLE_CALENDAR.md`

---

## 📞 Support Files

Inside your project you have:
- `GOOGLE_CALENDAR_SETUP.md` - Detailed Google setup
- `GOOGLE_CALENDAR_INTEGRATION.md` - Complete technical docs
- `QUICK_START_GOOGLE_CALENDAR.md` - Quick reference
- `INTEGRATION_SUMMARY.md` - Overview

---

**You're ready! Start with Step 1 now!** 🚀

