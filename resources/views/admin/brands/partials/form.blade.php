<div>
    <label class="form-label fw-semibold text-slate-700">Name</label>
    <input name="name" value="{{ old('name', $brand->name) }}" class="admin-input" required>
</div>
<div>
    <label class="form-label fw-semibold text-slate-700">Slug</label>
    <input name="slug" value="{{ old('slug', $brand->slug) }}" class="admin-input" placeholder="auto-generated from name">
</div>
<label class="flex items-center gap-3 text-sm font-semibold text-slate-700">
    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $brand->exists ? $brand->is_active : true))>
    Active brand
</label>
<div>
    <label class="form-label fw-semibold text-slate-700">Logo</label>
    <input type="file" name="logo" accept="image/*" class="admin-input">
    @if($brand->logo_path)
        <img src="{{ $brand->logo_path }}" alt="{{ $brand->name }}" class="mt-3 h-24 w-24 rounded-2xl object-cover">
    @endif
</div>
