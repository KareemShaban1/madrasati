@props(['attachableType'])
<div class="attachments-create-section" style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border);">
    <h3 style="font-size: 0.95rem; font-weight: 600; margin-bottom: 0.75rem;">{{ __('admin.attachments') ?? 'Attachments' }}</h3>
    <p class="attachments-hint" style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 1rem;">{{ __('admin.attachments_hint') ?? 'Upload images, videos, or documents (PDF, DOC, etc.). Max 50 MB per file.' }}</p>
    <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
        <input type="file" name="files[]" multiple accept="image/*,video/*,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.zip" id="attachments-create-input-{{ $attachableType }}" style="flex: 1; min-width: 200px;">
    </div>
    <div id="attachments-preview-{{ $attachableType }}" class="attachments-preview" style="display: none; margin-top: 0.75rem;">
        <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); margin-bottom: 0.5rem;">{{ __('admin.preview') ?? 'Preview' }}</div>
        <div id="attachments-preview-images-{{ $attachableType }}" class="preview-images" style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 0.75rem;"></div>
        <div id="attachments-preview-others-{{ $attachableType }}" class="preview-others" style="display: flex; flex-direction: column; gap: 0.35rem;"></div>
    </div>
</div>

@push('scripts')
<script>
(function() {
    const input = document.getElementById('attachments-create-input-{{ $attachableType }}');
    const previewWrap = document.getElementById('attachments-preview-{{ $attachableType }}');
    const previewImages = document.getElementById('attachments-preview-images-{{ $attachableType }}');
    const previewOthers = document.getElementById('attachments-preview-others-{{ $attachableType }}');
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
        files.forEach(function(file, i) {
            const type = getType(file.name);
            const row = document.createElement('div');
            row.style.cssText = 'display: flex; align-items: center; gap: 0.5rem; padding: 0.4rem 0.5rem; border: 1px solid var(--border); border-radius: 0.5rem; background: var(--nav-hover);';
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
