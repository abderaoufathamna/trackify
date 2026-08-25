@extends('layouts.user')

@section('title', 'My Subscriptions')

@section('content')

    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-slate-800">My Subscriptions</h2>
        <a href="{{ route('user.subscriptions.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-brand-600 text-white text-sm font-medium rounded-lg hover:bg-brand-700 transition">
            <i data-lucide="plus-circle" class="w-4 h-4"></i> Add
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-slate-400 uppercase tracking-wide bg-slate-50">
                    <th class="px-5 py-3 font-medium">Type</th>
                    <th class="px-5 py-3 font-medium">Provider</th>
                    <th class="px-5 py-3 font-medium">Price</th>
                    <th class="px-5 py-3 font-medium">End Date</th>
                    <th class="px-5 py-3 font-medium">Status</th>
                    <th class="px-5 py-3 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($subscriptions as $subscription)
                    @php
                        $status = $subscription->end_date && $subscription->end_date->isPast() ? 'expired' : 'active';
                    @endphp
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-3 text-slate-700">{{ $subscription->type->name }}</td>
                        <td class="px-5 py-3 text-slate-500">{{ $subscription->provider }}</td>
                        <td class="px-5 py-3 text-slate-700">{{ $subscription->price }} {{ $subscription->currency }}</td>
                        <td class="px-5 py-3 text-slate-500">{{ $subscription->end_date?->format('Y-m-d') }}</td>
                        <td class="px-5 py-3">
                            <span class="text-xs font-medium px-2 py-1 rounded-full {{ $status === 'expired' ? 'bg-red-100 text-red-700' : 'bg-brand-100 text-brand-700' }}">
                                {{ ucfirst($status) }}
                            </span>
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('user.subscriptions.edit', $subscription) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 text-slate-700 text-xs font-medium rounded-lg hover:bg-slate-200 transition">
                                    <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                                </a>
                                <form action="{{ route('user.subscriptions.destroy', $subscription) }}" method="POST" onsubmit="return confirm('Delete?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-600 text-xs font-medium rounded-lg hover:bg-red-100 transition">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-5 py-8 text-center text-slate-400">No subscriptions yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection