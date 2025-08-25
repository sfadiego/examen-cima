<?php

namespace App\Http\Controllers;

use App\Enums\HttpEnum;
use App\Enums\NoteStatesEnum;
use App\Http\Requests\NoteStoreRequest;
use App\Http\Requests\NoteUpdateRequest;
use App\Models\Notes;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Nette\Utils\Json;

class NotesController extends Controller
{
    public function index(): JsonResponse
    {
        $notes = Notes::all();

        return response()->json($notes);
    }

    public function store(NoteStoreRequest $request): JsonResponse
    {
        $note = Notes::create([
            'title' => $request->title,
            'content' => $request->content,
            'state' =>  $request->input('state', NoteStatesEnum::ACTIVE->value),
            'setted' =>  $request->input('setted', 0),
            'created_at' => now(),
        ]);
        return Response::success($note, 'Nota creada', HttpEnum::Created);
    }

    public function update(Notes $nota, NoteUpdateRequest $request): JsonResponse
    {
        $nota->update([
            'title'   => $request->input('title', $nota->title),
            'content' => $request->input('content', $nota->content),
            'state'   => $request->input('state', $nota->state),
            'updated_at' => now(),
        ]);

        return Response::success($nota, 'Nota actualizada');
    }

    public function destroy(Notes $nota): JsonResponse
    {
        $nota->delete();
        return Response::success(null, 'Nota borrada');
    }

    public function archive(Notes $nota): JsonResponse
    {
        $nota->update([
            'state'   => NoteStatesEnum::ARCHIVED->value,
            'updated_at' => now(),
        ]);
        return Response::success("Nota archivada");
    }


    public function archived(): JsonResponse
    {
        $archivedNotes = Notes::where('state', NoteStatesEnum::ARCHIVED)->get();
        return Response::success($archivedNotes);
    }
}
