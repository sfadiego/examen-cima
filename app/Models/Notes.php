<?php

namespace App\Models;

use App\Enums\NoteStatesEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    use HasFactory;
    protected $table = 'notes';
    protected $fillable = ['title', 'content', 'state', 'setted'];

    public static function getActiveNotes()
    {
        return Notes::where('state', NoteStatesEnum::ACTIVE)
            ->orderBy('setted', 'desc')->get();
    }

    public static function getArchivedNotes()
    {
        return Notes::where('state', NoteStatesEnum::ARCHIVED)->get();
    }
}
