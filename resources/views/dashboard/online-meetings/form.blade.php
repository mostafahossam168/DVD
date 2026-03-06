@csrf
<div class="form-card-ds">
    <div class="form-card-header-ds">
        <div class="fch-icon-ds" style="background:#e0e7ff">📹</div>
        <div>
            <h2>@isset($item) تعديل المحاضرة @else إضافة محاضرة أونلاين @endisset</h2>
            <p>المرحلة والصف والمادة وموعد البداية.</p>
        </div>
    </div>
    <div class="form-card-body-ds">
        <div class="form-grid-ds">
            <div class="form-group-ds">
                <label class="form-label-ds">عنوان المحاضرة <span class="required-ds">*</span></label>
                <input type="text" name="topic" class="form-control-ds" value="{{ old('topic', $item->topic ?? '') }}" required>
                @error('topic')<span class="form-error-ds">{{ $message }}</span>@enderror
            </div>
            <div class="form-group-ds">
                <label class="form-label-ds">المرحلة الدراسية</label>
                <select name="stage_id" class="form-control-ds">
                    <option value="">-- اختر --</option>
                    @foreach ($stages as $stage)
                        <option value="{{ $stage->id }}" @selected(old('stage_id', $item->stage_id ?? '') == $stage->id)>{{ $stage->name }}</option>
                    @endforeach
                </select>
                @error('stage_id')<span class="form-error-ds">{{ $message }}</span>@enderror
            </div>
            <div class="form-group-ds">
                <label class="form-label-ds">الصف الدراسي</label>
                <select name="grade_id" class="form-control-ds"></select>
                @error('grade_id')<span class="form-error-ds">{{ $message }}</span>@enderror
            </div>
            <div class="form-group-ds">
                <label class="form-label-ds">المادة</label>
                <select name="subject_id" class="form-control-ds"></select>
                @error('subject_id')<span class="form-error-ds">{{ $message }}</span>@enderror
            </div>
            <div class="form-group-ds">
                <label class="form-label-ds">موعد البداية <span class="required-ds">*</span></label>
                <input type="datetime-local" name="start_time" class="form-control-ds" value="{{ old('start_time', isset($item) && $item->start_time ? $item->start_time->format('Y-m-d\TH:i') : '') }}" required>
                @error('start_time')<span class="form-error-ds">{{ $message }}</span>@enderror
            </div>
            <div class="form-group-ds">
                <label class="form-label-ds">المدة (دقيقة)</label>
                <input type="number" name="duration" class="form-control-ds" value="{{ old('duration', $item->duration ?? 60) }}" min="15">
                @error('duration')<span class="form-error-ds">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>
    <div class="form-card-footer-ds">
        <button type="submit" class="btn-ds btn-success-ds">حفظ</button>
        <a href="{{ route('dashboard.online-meetings.index') }}" class="btn-ds btn-secondary-ds">إلغاء</a>
    </div>
</div>
