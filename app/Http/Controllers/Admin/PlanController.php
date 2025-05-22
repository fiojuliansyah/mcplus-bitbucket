<?php

namespace App\Http\Controllers\Admin;

use App\Models\Plan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\DataTables\PlanDataTable;
use App\Http\Controllers\Controller;

class PlanController extends Controller
{
    public function index(PlanDataTable $dataTable)
    {
        return $dataTable->render('admin.plans.index');
    }

    public function store(Request $request)
    {
        Plan::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'price' => $request->price,
            'description' => $request->description,
            'duration' => $request->duration,
            'duration_value' => $request->duration_value,
            'device_limit' => $request->device_limit,
            'profile_limit' => $request->profile_limit,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.plans.index')->with('success', 'Plan created successfully.');
    }

    public function update(Request $request, $id)
    {
        $plan = Plan::findOrFail($id);

        $plan->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'price' => $request->price,
            'description' => $request->description,
            'duration' => $request->duration,
            'duration_value' => $request->duration_value,
            'device_limit' => $request->device_limit,
            'profile_limit' => $request->profile_limit,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.plans.index')->with('success', 'Plan updated successfully.');
    }

    public function destroy($id)
    {
        $plan = Plan::findOrFail($id);

        $plan->delete();

        return redirect()->route('admin.plans.index')->with('success', 'Plan deleted successfully.');
    }
}
