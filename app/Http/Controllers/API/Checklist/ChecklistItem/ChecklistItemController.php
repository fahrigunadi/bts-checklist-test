<?php

namespace App\Http\Controllers\API\Checklist\ChecklistItem;

use App\Models\Checklist;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\API\BaseAPIController;

class ChecklistItemController extends BaseAPIController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, string $checklist): JsonResponse
    {
        $checklist = $this->findChecklist($checklist);

        if (! $checklist)
            return $this->responderChecklistNotFound();

        return $this->responder(
            message: 'Checklist items retrieved successfully',
            data: [
                'items' => $checklist->items()->get(),
            ],
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $checklist): JsonResponse
    {
        $checklist = $this->findChecklist($checklist);

        if (! $checklist)
            return $this->responderChecklistNotFound();

        $this->validateRequest([
            'itemName' => ['required', 'max:255'],
        ]);

        $item = $checklist->items()->create([
            'name' => $request->itemName,
        ]);

        return $this->responder(
            message: 'Checklist item created successfully',
            data: [
                'item' => $item
            ],
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $checklist, string $checklistItem): JsonResponse
    {
        $checklist = $this->findChecklist($checklist);

        if (! $checklist)
            return $this->responderChecklistNotFound();

        $checklistItem = $checklist->items()->find($checklistItem);

        if (! $checklistItem)
            return $this->responder(
                message: 'Checklist item not found',
                success: false,
                httpCode: 404
            );

        return $this->responder(
            message: 'Checklist item retrieved successfully',
            data: [
                'item' => $checklistItem
            ],
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStatus(Request $request, string $checklist, string $checklistItem): JsonResponse
    {
        $checklist = $this->findChecklist($checklist);

        if (! $checklist)
            return $this->responderChecklistNotFound();

        $checklistItem = $checklist->items()->find($checklistItem);

        if (! $checklistItem)
            return $this->responderChecklistItemNotFound();

        $checklistItem->updateStatus();

        return $this->responder(
            message: 'Checklist item updated successfully',
            data: [
                'item' => $checklistItem
            ],
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $checklist, string $checklistItem): JsonResponse
    {
        $checklist = $this->findChecklist($checklist);

        if (! $checklist)
            return $this->responderChecklistNotFound();

        $checklistItem = $checklist->items()->find($checklistItem);

        if (! $checklistItem)
            return $this->responderChecklistItemNotFound();

        $checklistItem->delete();

        return $this->responder(
            message: 'Checklist item deleted successfully',
        );
    }

    /**
     * Rename the specified resource in storage.
     */
    public function rename(Request $request, string $checklist, string $checklistItem): JsonResponse
    {
        $checklist = $this->findChecklist($checklist);

        if (! $checklist)
            return $this->responderChecklistNotFound();

        $checklistItem = $checklist->items()->find($checklistItem);

        if (! $checklistItem)
            return $this->responderChecklistItemNotFound();

        $this->validateRequest([
            'itemName' => ['required', 'max:255'],
        ]);

        $checklistItem->update([
            'name' => $request->itemName
        ]);

        return $this->responder(
            message: 'Checklist item updated successfully',
            data: [
                'item' => $checklistItem
            ],
        );
    }

    private function findChecklist(string $checklist): Checklist|null
    {
        return request()->user()->checklists()->find($checklist);
    }

    private function responderChecklistNotFound(): JsonResponse
    {
        return $this->responder(
            message: 'Checklist not found',
            success: false,
            httpCode: 404
        );
    }

    private function responderChecklistItemNotFound(): JsonResponse
    {
        return $this->responder(
            message: 'Checklist item not found',
            success: false,
            httpCode: 404
        );
    }
}
