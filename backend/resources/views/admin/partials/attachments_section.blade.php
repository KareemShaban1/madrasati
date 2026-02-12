@props(['attachable', 'attachableType'])
@php
    $attachments = $attachable->attachments ?? collect();
    $images = $attachments->where('file_type', 'image');
    $videos = $attachments->where('file_type', 'video');
    $files = $attachments->where('file_type', 'file');
@endphp
<div class="attachments-section" style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border);">
    <h3 style="font-size: 0.95rem; font-weight: 600; margin-bottom: 0.75rem;">{{ __('admin.attachments') ?? 'Attachments' }}</h3>
    <p class="attachments-hint" style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 1rem;">{{ __('admin.attachments_hint') ?? 'Upload images, videos, or documents (PDF, DOC, etc.). Max 50 MB per file.' }}</p>

    {{-- Upload form --}}
    <form method="POST" action="{{ route('admin.attachments.store') }}" enctype="multipart/form-data" class="attachments-upload-form" style="margin-bottom: 1.25rem;">
        @csrf
        <input type="hidden" name="attachable_type" value="{{ $attachableType }}">
        <input type="hidden" name="attachable_id" value="{{ $attachable->id }}">
        <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 0.5rem;">
            <input type="file" name="files[]" multiple accept="image/*,video/*,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.zip" id="attachments-input-{{ $attachableType }}-{{ $attachable->id }}" style="flex: 1; min-width: 200px;">
            <button type="submit" class="btn" style="padding: 0.5rem 1rem;">{{ __('admin.upload') ?? 'Upload' }}</button>
        </div>
        @error('files')
            <span style="font-size: 0.75rem; color: #dc2626;">{{ $message }}</span>
        @enderror
    </form>
    {{-- New files preview (before upload) --}}
    <div id="attachments-edit-preview-{{ $attachableType }}-{{ $attachable->id }}" class="attachments-preview" style="display: none; margin-bottom: 1.25rem;">
        <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); margin-bottom: 0.5rem;">{{ __('admin.preview') ?? 'Preview' }}</div>
        <div id="attachments-edit-preview-images-{{ $attachableType }}-{{ $attachable->id }}" class="preview-images" style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 0.75rem;"></div>
        <div id="attachments-edit-preview-others-{{ $attachableType }}-{{ $attachable->id }}" class="preview-others" style="display: flex; flex-direction: column; gap: 0.35rem;"></div>
    </div>

    {{-- Existing attachments --}}
    @if($attachments->isNotEmpty())
        <div class="attachments-list">
            @if($images->isNotEmpty())
                <div class="attachment-group" style="margin-bottom: 1rem;">
                    <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); margin-bottom: 0.5rem;">{{ __('admin.images') ?? 'Images' }}</div>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                        @foreach($images as $att)
                            <div class="attachment-item attachment-image" style="position: relative; width: 80px; height: 80px; border-radius: 0.5rem; overflow: hidden; border: 1px solid var(--border);">
                                <img src="{{ asset('storage/' . $att->file_path) }}" alt="{{ $att->file_name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                <form method="POST" action="{{ route('admin.attachments.destroy', $att) }}" style="position: absolute; top: 0.2rem; {{ app()->getLocale() === 'ar' ? 'left' : 'right' }}: 0.2rem;" onsubmit="return confirm('{{ __('admin.delete_attachment_confirm') ?? 'Delete this attachment?' }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger" style="padding: 0.2rem 0.4rem; font-size: 0.7rem; border-radius: 0.35rem;">×</button>
                                </form>
                                <a href="{{ asset('storage/' . $att->file_path) }}" target="_blank" rel="noopener" style="position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,0.6); color: white; font-size: 0.65rem; padding: 0.2rem; text-align: center; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ Str::limit($att->file_name, 12) }}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            @if($videos->isNotEmpty())
                <div class="attachment-group" style="margin-bottom: 1rem;">
                    <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); margin-bottom: 0.5rem;">{{ __('admin.videos') ?? 'Videos' }}</div>
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        @foreach($videos as $att)
                            <div class="attachment-item attachment-video" style="display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem; border: 1px solid var(--border); border-radius: 0.5rem; background: var(--nav-hover);">
                                <span style="font-size: 1.25rem;">▶</span>
                                <a href="{{ asset('storage/' . $att->file_path) }}" target="_blank" rel="noopener" style="flex: 1; font-size: 0.85rem;">{{ $att->file_name }}</a>
                                <form method="POST" action="{{ route('admin.attachments.destroy', $att) }}" style="display: inline;" onsubmit="return confirm('{{ __('admin.delete_attachment_confirm') ?? 'Delete this attachment?' }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger" style="padding: 0.2rem 0.5rem; font-size: 0.75rem;">{{ __('admin.delete') ?? 'Delete' }}</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            @if($files->isNotEmpty())
                <div class="attachment-group" style="margin-bottom: 1rem;">
                    <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); margin-bottom: 0.5rem;">{{ __('admin.files') ?? 'Documents & Files' }}</div>
                    <div style="display: flex; flex-direction: column; gap: 0.35rem;">
                        @foreach($files as $att)
                            <div class="attachment-item attachment-file" style="display: flex; align-items: center; gap: 0.5rem; padding: 0.4rem 0.5rem; border: 1px solid var(--border); border-radius: 0.5rem; background: var(--nav-hover);">
                                <span style="font-size: 1rem;">📄</span>
                                <a href="{{ asset('storage/' . $att->file_path) }}" target="_blank" rel="noopener" style="flex: 1; font-size: 0.85rem;">{{ $att->file_name }}</a>
                                <form method="POST" action="{{ route('admin.attachments.destroy', $att) }}" style="display: inline;" onsubmit="return confirm('{{ __('admin.delete_attachment_confirm') ?? 'Delete this attachment?' }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger" style="padding: 0.2rem 0.5rem; font-size: 0.75rem;">{{ __('admin.delete') ?? 'Delete' }}</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    @endif
</div>
@push('scripts')
<script>
(function() {
    const inputId = 'attachments-input-{{ $attachableType }}-{{ $attachable->id }}';
    const previewWrapId = 'attachments-edit-preview-{{ $attachableType }}-{{ $attachable->id }}';
    const previewImagesId = 'attachments-edit-preview-images-{{ $attachableType }}-{{ $attachable->id }}';
    const previewOthersId = 'attachments-edit-preview-others-{{ $attachableType }}-{{ $attachable->id }}';
    const input = document.getElementById(inputId);
    if (!input) return;
    const previewWrap = document.getElementById(previewWrapId);
    const previewImages = document.getElementById(previewImagesId);
    const previewOthers = document.getElementById(previewOthersId);
    const imageExt = ['jpg','jpeg','png','gif','webp','svg'];
    const videoExt = ['mp4','webm','ogg','mov','avi'];
    function getType(name) {
        const ext = (name.split('.').pop() || '').toLowerCase();
        if (imageExt.includes(ext)) return 'image';
        if (videoExt.includes(ext)) return 'video';
        return 'file';
    }
    function formatSize(bytes) {
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1024*1024) return (bytes/1024).toFixed(1) + ' KB';
        return (bytes/(1024*1024)).toFixed(1) + ' MB';
    }
    input.addEventListener('change', function() {
        const files = Array.from(this.files || []);
        previewImages.innerHTML = '';
        previewOthers.innerHTML = '';
        previewWrap.style.display = files.length ? 'block' : 'none';
        files.forEach(function(file) {
            const type = getType(file.name);
            if (type === 'image') {
                const box = document.createElement('div');
                box.style.cssText = 'position: relative; width: 80px; height: 80px; border-radius: 0.5rem; overflow: hidden; border: 1px solid var(--border); flex-shrink: 0;';
                const img = document.createElement('img');
                img.style.cssText = 'width: 100%; height: 100%; object-fit: cover;';
                img.alt = file.name;
                const reader = new FileReader();
                reader.onload = function(e) { img.src = e.target.result; };
                reader.readAsDataURL(file);
                const label = document.createElement('div');
                label.style.cssText = 'position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,0.6); color: white; font-size: 0.65rem; padding: 0.2rem; text-align: center; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;';
                label.textContent = file.name.length > 12 ? file.name.substring(0, 10) + '…' : file.name;
                box.appendChild(img);
                box.appendChild(label);
                previewImages.appendChild(box);
            } else {
                const row = document.createElement('div');
                row.style.cssText = 'display: flex; align-items: center; gap: 0.5rem; padding: 0.4rem 0.5rem; border: 1px solid var(--border); border-radius: 0.5rem; background: var(--nav-hover);';
                const icon = document.createElement('span');
                icon.style.fontSize = '1rem';
                icon.textContent = type === 'video' ? '▶' : '📄';
                const name = document.createElement('span');
                name.style.cssText = 'flex: 1; font-size: 0.85rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;';
                name.textContent = file.name + ' (' + formatSize(file.size) + ')';
                row.appendChild(icon);
                row.appendChild(name);
                previewOthers.appendChild(row);
            }
        });
    });
})();
</script>
@endpush
