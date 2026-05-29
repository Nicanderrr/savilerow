<div>
    <label class="form-label fw-semibold text-slate-700">Name</label>
    <input name="name" value="{{ old('name', $category->name) }}" class="admin-input" required>
</div>
<div>
    <label class="form-label fw-semibold text-slate-700">Slug</label>
    <input name="slug" value="{{ old('slug', $category->slug) }}" class="admin-input" placeholder="auto-generated from name">
</div>
<div>
    <label class="form-label fw-semibold text-slate-700">Parent category</label>
    <select name="parent_id" class="admin-select">
        <option value="">None</option>
        @foreach($parents as $parent)
            <option value="{{ $parent->id }}" @selected(old('parent_id', $category->parent_id) == $parent->id)>{{ $parent->name }}</option>
        @endforeach
    </select>
</div>
<div class="grid gap-4 sm:grid-cols-2">
    <div>
        <label class="form-label fw-semibold text-slate-700">Sort order</label>
        <input type="number" min="0" name="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}" class="admin-input">
    </div>
    <label class="mt-8 flex items-center gap-3 text-sm font-semibold text-slate-700">
        <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $category->is_featured))>
        Featured
    </label>
</div>
<div>
    <label class="form-label fw-semibold text-slate-700">Category image</label>
    <input type="file" name="image" accept="image/*" class="admin-input">
    @if($category->image_path)
        <img src="{{ $category->image_path }}" alt="{{ $category->name }}" class="mt-3 h-24 w-24 rounded-2xl object-cover">
    @endif
</div>
