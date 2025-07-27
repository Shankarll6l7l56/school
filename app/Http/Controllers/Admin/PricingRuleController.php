<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PricingRule;
use Illuminate\Http\Request;

class PricingRuleController extends Controller
{


    public function index()
    {
        $pricingRules = PricingRule::all();
        return view('backend.pricing_rules.index', compact('pricingRules'));
    }

    public function create()
    {
        return view('backend.pricing_rules.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'rule_type' => 'required|string',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean'
        ]);

        $data['is_active'] = $request->has('is_active');
        // dd($request->all());

        PricingRule::create($data);
        return redirect()->route('pricing-rules.index')->with('success', 'Rule created.');
    }

    public function edit(PricingRule $pricingRule)
    {
        return view('backend.pricing_rules.edit', ['rule' => $pricingRule]);
    }

    public function update(Request $request, PricingRule $pricingRule)
    {
        $data = $request->validate([
            'rule_type' => 'required|string',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean'
        ]);
        $data['is_active'] = $request->has('is_active');
        $pricingRule->update($data);
        return redirect()->route('pricing-rules.index')->with('success', 'Rule updated.');
    }

    public function destroy(PricingRule $pricingRule)
    {
        $pricingRule->delete();
        return redirect()->route('pricing-rules.index')->with('success', 'Rule deleted.');
    }
}
