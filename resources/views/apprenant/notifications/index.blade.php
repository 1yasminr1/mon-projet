@extends('layouts.apprenant')
@section('title', 'Notifications')
@section('content')

<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-800">🔔 Notifications</h1>
    <form method="POST" action="{{ route('apprenant.notifications.lire.tout') }}">
        @csrf
        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
            ✅ Tout marquer comme lu
        </button>
    </form>
</div>

<div class="space-y-3">
    @forelse($notifications as $notification)
    <div class="bg-white rounded-xl shadow p-5 flex items-start justify-between
                {{ $notification->lu ? 'opacity-60' : 'border-l-4 border-blue-500' }}">
        <div class="flex items-start gap-4">
            <div class="w-10 h-10 rounded-full {{ $notification->lu ? 'bg-gray-100' : 'bg-blue-100' }}
                        flex items-center justify-center text-xl flex-shrink-0">
                🔔
            </div>
            <div>
                <p class="font-bold text-gray-800">{{ $notification->titre }}</p>
                <p class="text-gray-600 text-sm mt-1">{{ $notification->message }}</p>
                <p class="text-gray-400 text-xs mt-2">
                    {{ $notification->created_at->diffForHumans() }}
                </p>
            </div>
        </div>
        @if(!$notification->lu)
        <form method="POST" action="{{ route('apprenant.notifications.lire', $notification->id) }}">
            @csrf
            <button class="text-blue-600 text-xs hover:underline flex-shrink-0">
                Marquer lu
            </button>
        </form>
        @else
        <span class="text-green-500 text-xs flex-shrink-0">✅ Lu</span>
        @endif
    </div>
    @empty
    <div class="bg-white rounded-xl shadow p-12 text-center">
        <div class="text-5xl mb-4">🔔</div>
        <p class="text-gray-400">Aucune notification</p>
    </div>
    @endforelse
</div>

<div class="mt-4">{{ $notifications->links() }}</div>

@endsection