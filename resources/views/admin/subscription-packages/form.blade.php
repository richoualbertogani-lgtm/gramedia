@php($package = $package ?? null)
{{-- Field bersama untuk membuat atau mengubah nama, deskripsi, harga, dan warna paket. --}}
<div class="mb-3">
    <label for="name" class="form-label">Nama Paket</label>
    <input type="text" name="name" id="name"
        class="form-control @error('name') is-invalid @enderror"
        value="{{ old('name', $package?->name) }}" required>
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label for="description" class="form-label">Deskripsi</label>
    <textarea name="description" id="description"
        class="form-control @error('description') is-invalid @enderror"
        required>{{ old('description', $package?->description) }}</textarea>
    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label for="price" class="form-label">Harga</label>
    <input type="number" name="price" id="price"
        class="form-control @error('price') is-invalid @enderror"
        value="{{ old('price', $package?->price) }}" min="0" required>
    @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label for="color" class="form-label">Warna Paket</label>
    <input type="color" name="color" id="color"
        class="form-control form-control-color @error('color') is-invalid @enderror"
        value="{{ old('color', $package?->color ?? '#000000') }}" required>
    @error('color') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
