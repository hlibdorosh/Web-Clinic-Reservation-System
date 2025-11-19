{{-- dashboard_user.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2>Панель admin</h2>

    </x-slot>
    <div class="p-6">Добро пожаловать, {{ Auth::user()->name }}</div>

</x-app-layout>

