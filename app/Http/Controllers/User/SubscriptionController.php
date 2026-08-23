<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\SubscriptionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Auth::user()->subscriptions()->with('type')->latest('id')->get();

        return view('user.subscriptions.index', compact('subscriptions'));
    }

    public function create()
    {
        $types = SubscriptionType::all();

        return view('user.subscriptions.create', compact('types'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateSubscription($request);

        $typeId = $this->resolveTypeId($validated);
        Subscription::create([
            'user_id'       => Auth::id(),
            'type_id'       => $typeId,
            'provider'      => $validated['provider'],
            'price'         => $validated['price'],
            'billing_cycle' => $validated['billing_cycle'],
            'start_date'    => $validated['start_date'],
            'end_date'      => $validated['end_date'],
        ]);

        return redirect()->route('user.subscriptions.index')->with('success', 'Subscription added.');
    }

    public function edit(Subscription $subscription)
    {
        abort_if($subscription->user_id !== Auth::id(), 403);

        $types = SubscriptionType::all();

        return view('user.subscriptions.edit', compact('subscription', 'types'));
    }

    public function update(Request $request, Subscription $subscription)
    {
        abort_if($subscription->user_id !== Auth::id(), 403);

        $validated = $this->validateSubscription($request);
        $typeId = $this->resolveTypeId($validated);

        $subscription->update([
            'type_id'       => $typeId,
            'provider'      => $validated['provider'],
            'price'         => $validated['price'],
            'billing_cycle' => $validated['billing_cycle'],
            'start_date'    => $validated['start_date'],
            'end_date'      => $validated['end_date'],
        ]);

        return redirect()->route('user.subscriptions.index')->with('success', 'Subscription updated.');
    }

    public function destroy(Subscription $subscription)
    {
        abort_if($subscription->user_id !== Auth::id(), 403);

        $subscription->delete();

        return redirect()->route('user.subscriptions.index')->with('success', 'Subscription deleted.');
    }

    private function validateSubscription(Request $request): array
    {
        return $request->validate([
            'type_id'       => ['required', 'exists:subscription_types,id'],
            'provider'      => ['required', 'string', 'max:255'],
            'price'         => ['required', 'numeric', 'min:0'],
            'billing_cycle' => ['required', 'in:monthly,yearly'],
            'start_date'    => ['required', 'date'],
            'end_date'      => ['required', 'date', 'after_or_equal:start_date'],
        ]);
    }

    private function resolveTypeId(array $validated): int
    {
        if (!empty($validated['custom_type'])) {
            $type = SubscriptionType::firstOrCreate(['name' => $validated['custom_type']]);
            return $type->id;
        }

        return (int) $validated['type_id'];
    }
}