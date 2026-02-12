<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AttachmentController extends Controller
{
    private const IMAGE_EXT = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
    private const VIDEO_EXT = ['mp4', 'webm', 'ogg', 'mov', 'avi'];
    private const MAX_SIZE_KB = 51200; // 50 MB in KB

    public function store(Request $request)
    {
        $request->validate([
            'attachable_type' => ['required', 'string', Rule::in(['grade', 'subject', 'unit', 'lesson'])],
            'attachable_id' => ['required', 'integer'],
            'files' => ['required'],
            'files.*' => ['file', 'max:' . self::MAX_SIZE_KB],
        ]);

        $modelClass = $this->resolveModelClass($request->attachable_type);
        $attachable = $modelClass::findOrFail($request->attachable_id);

        $uploaded = [];
        $files = $request->file('files');
        if (! is_array($files)) {
            $files = [$files];
        }

        foreach ($files as $file) {
            $ext = strtolower($file->getClientOriginalExtension());
            $fileType = self::detectFileType($ext);
            $path = $file->store(
                "attachments/{$request->attachable_type}s/{$attachable->id}",
                'public'
            );

            $attachment = $attachable->attachments()->create([
                'file_path' => $path,
                'file_name' => $file->getClientOriginalName(),
                'file_type' => $fileType,
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
            ]);

            $uploaded[] = $attachment;
        }

        if ($request->wantsJson()) {
            return response()->json(['attachments' => $uploaded, 'message' => 'Files uploaded.']);
        }

        return back()->with('status', count($uploaded) . ' file(s) uploaded.');
    }

    public function destroy(Attachment $attachment)
    {
        Storage::disk('public')->delete($attachment->file_path);
        $attachment->delete();

        if (request()->wantsJson()) {
            return response()->json(['message' => 'Attachment deleted.']);
        }

        return back()->with('status', 'Attachment deleted.');
    }

    private function resolveModelClass(string $type): string
    {
        return match ($type) {
            'grade' => \App\Models\Grade::class,
            'subject' => \App\Models\Subject::class,
            'unit' => \App\Models\Unit::class,
            'lesson' => \App\Models\Lesson::class,
            default => throw new \InvalidArgumentException('Invalid attachable type.'),
        };
    }

    private static function detectFileType(string $ext): string
    {
        if (in_array($ext, self::IMAGE_EXT, true)) {
            return 'image';
        }
        if (in_array($ext, self::VIDEO_EXT, true)) {
            return 'video';
        }
        return 'file';
    }

    public static function processAttachmentsFromRequest(Request $request, $attachable, string $type): int
    {
        $files = $request->file('files');
        if (!$files) {
            return 0;
        }
        $files = is_array($files) ? $files : [$files];
        $count = 0;
        foreach ($files as $file) {
            if (!$file || !$file->isValid()) {
                continue;
            }
            $ext = strtolower($file->getClientOriginalExtension());
            $fileType = self::detectFileType($ext);
            $path = $file->store("attachments/{$type}s/{$attachable->id}", 'public');
            $attachable->attachments()->create([
                'file_path' => $path,
                'file_name' => $file->getClientOriginalName(),
                'file_type' => $fileType,
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
            ]);
            $count++;
        }
        return $count;
    }
}
