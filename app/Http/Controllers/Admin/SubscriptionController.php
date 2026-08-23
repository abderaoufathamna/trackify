<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\SubscriptionType;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::with(['user', 'type'])->latest('id')->get();

        return view('admin.subscriptions.index', compact('subscriptions'));
    }

    public function edit(Subscription $subscription)
    {
        $types = SubscriptionType::all();

        return view('admin.subscriptions.edit', compact('subscription', 'types'));
    }

    public function update(Request $request, Subscription $subscription)
    {
        $validated = $request->validate([
            'type_id'       => ['required_without:custom_type', 'nullable', 'exists:subscription_types,id'],
            'custom_type'   => ['nullable', 'string', 'max:255'],
            'provider'      => ['required', 'string', 'max:255'],
            'price'         => ['required', 'numeric', 'min:0'],
            'billing_cycle' => ['required', 'in:monthly,yearly'],
            'start_date'    => ['required', 'date'],
            'end_date'      => ['required', 'date', 'after_or_equal:start_date'],
        ]);

        $typeId = $this->resolveTypeId($validated);
        
        $subscription->update([
            'type_id'       => $typeId,
            'provider'      => $validated['provider'],
            'price'         => $validated['price'],
            'billing_cycle' => $validated['billing_cycle'],
            'start_date'    => $validated['start_date'],
            'end_date'      => $validated['end_date'],
        ]);

        return redirect()->route('admin.subscriptions.index')->with('success', 'Subscription updated.');
    }

    public function destroy(Subscription $subscription)
    {
        $subscription->delete();

        return redirect()->route('admin.subscriptions.index')->with('success', 'Subscription deleted.');
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