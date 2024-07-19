<?php

namespace App\Http\Controllers\API\Checklist;

use App\Models\Checklist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseAPIController;

class ChecklistController extends BaseAPIController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $checklists = $request->user()->checklists()->get();

        return $this->responder(
            message: 'Checklists retrieved successfully',
            data: [
                'checklists' => $checklists
            ],
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $this->validateRequest([
            'name' => ['required', 'max:255'],
        ]);

        $checklist = $request->user()->checklists()->create($validated);

        return $this->responder(
            message: 'Checklist created successfully',
            data: [
                'checklist' => $checklist
            ],
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $checklist): JsonResponse
    {
        $checklist = $request->user()->checklists()->find($checklist);

        if (! $checklist) {
            return $this->responder(
                message: 'Checklist not found',
                success: false,
                httpCode: 404,
            );
        }

        $checklist->delete();

        return $this->responder(
            message: 'Checklist deleted successfully',
        );
    }
}
