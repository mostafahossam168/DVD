@csrf

<div class="row g-3">
    <div class="col-12 col-md-4">
        <label class="form-label">عنوان المحاضرة</label>
        <input type="text" name="topic" class="form-control"
            value="{{ old('topic', $item->topic ?? '') }}" required>
    </div>

    <div class="col-12 col-md-3">
        <label class="form-label">المرحلة الدراسية</label>
        <select name="stage_id" class="form-select">
            <option value="">-- اختر --</option>
            @foreach ($stages as $stage)
                <option value="{{ $stage->id }}" @selected(old('stage_id', $item->stage_id ?? '') == $stage->id)>
                    {{ $stage->name }}
                </option>
            @endforeach
        </select>
        @error('stage_id')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-12 col-md-3">
        <label class="form-label">الصف الدراسي</label>
        <select name="grade_id" class="form-select">
        </select>
        @error('grade_id')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-12 col-md-2">
        <label class="form-label">المادة</label>
        <select name="subject_id" class="form-select">
        </select>
        @error('subject_id')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="row g-3 mt-2">
    <div class="col-12 col-md-4">
        <label class="form-label">موعد البداية</label>
        <input type="datetime-local" name="start_time" class="form-control"
            value="{{ old('start_time', isset($item) && $item->start_time ? $item->start_time->format('Y-m-d\TH:i') : '') }}"
            required>
    </div>

    <div class="col-12 col-md-2">
        <label class="form-label">المدة (دقيقة)</label>
        <input type="number" name="duration" class="form-control"
            value="{{ old('duration', $item->duration ?? 60) }}" min="15">
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="main-btn btn-main-color">
        حفظ
    </button>
    <a href="{{ route('dashboard.online-meetings.index') }}" class="main-btn bg-secondary">
        إلغاء
    </a>
</div>

