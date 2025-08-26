<?php

namespace App\Http\Controllers;

use App\Enums\HttpEnum;
use App\Enums\NoteStatesEnum;
use App\Http\Requests\NoteStoreRequest;
use App\Http\Requests\NoteUpdateRequest;
use App\Models\Notes;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class NotesController extends Controller
{
    /**
     * listado de notas
     *
     * @return JsonResponse
     *
     */
    public function index(): JsonResponse
    {

        $notes = Notes::getActiveNotes();
        return Response::success($notes);
    }

    /**
     * Guardar nota
     *
     * @param NoteStoreRequest $request
     *
     * @return JsonResponse
     *
     */
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

    /**
     * Actualizar nota
     *
     * @param Notes $nota
     * @param NoteUpdateRequest $request
     *
     * @return JsonResponse
     *
     */
    public function update(Notes $nota, NoteUpdateRequest $request): JsonResponse
    {
        $nota->update([
            'title'   => $request->input('title', $nota->title),
            'content' => $request->input('content', $nota->content),
            'state'   => $request->input('state', $nota->state),
            'setted' =>  $request->input('setted', 0),
            'updated_at' => now(),
        ]);

        return Response::success($nota, 'Nota actualizada');
    }

    /**
     * Borrar notas
     *
     * @param Notes $nota
     *
     * @return JsonResponse
     *
     */
    public function destroy(Notes $nota): JsonResponse
    {
        $nota->delete();
        return Response::success(null, 'Nota borrada');
    }

    /**
     * Archivar nota
     *
     * @param Notes $nota
     *
     * @return JsonResponse
     *
     */
    public function archive(Notes $nota): JsonResponse
    {
        $nota->update([
            'state'   => NoteStatesEnum::ARCHIVED->value,
            'updated_at' => now(),
        ]);
        return Response::success(null, "Nota archivada");
    }


    /**
     * Listado de notas archivadas
     *
     * @return JsonResponse
     *
     */
    public function archived(): JsonResponse
    {
        $archivedNotes = Notes::getArchivedNotes();
        return Response::success($archivedNotes);
    }
}
