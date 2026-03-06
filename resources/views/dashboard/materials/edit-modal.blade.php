<div class="modal fade" id="edit{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    data-stage-id="{{ $item->lecture?->subject?->grade?->stage_id ?? '' }}"
    data-grade-id="{{ $item->lecture?->subject?->grade_id ?? '' }}"
    data-subject-id="{{ $item->lecture?->subject_id ?? '' }}"
    data-lecture-id="{{ $item->lecture_id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تعديل الملف</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('dashboard.materials.update', $item->id) }}" method="POST"
                enctype="multipart/form-data">
                <div class="modal-body row g-3">
                    @csrf
                    @method('PUT')
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for="">العنوان</label>
                            <input type="text" name="title" value="{{ $item->title }}" class="form-control-ds">
                        </div>
                    </div>
                    @if(isset($stages) && $stages->count() > 0)
                    <div class="col-12">
                        <label for="">المرحلة الدراسية</label>
                        <select name="stage_id" class="form-control-ds material-stage-select">
                            <option value="">-- اختر --</option>
                            @foreach ($stages as $stage)
                                <option value="{{ $stage->id }}" @selected(($item->lecture?->subject?->grade?->stage_id ?? '') == $stage->id)>{{ $stage->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="">الصف الدراسي</label>
                        <select name="grade_id" class="form-control-ds material-grade-select">
                            <option value="">-- اختر --</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="">المادة</label>
                        <select name="subject_id" class="form-control-ds material-subject-select">
                            <option value="">-- اختر --</option>
                        </select>
                    </div>
                    @endif
                    <div class="col-12">
                        <label for="">الدرس</label>
                        <select name="lecture_id" class="form-control-ds material-lecture-select" required>
                            <option value="">@if(isset($stages) && $stages->isNotEmpty())-- اختر المرحلة والصف والمادة أولاً --@else-- اختر --@endif</option>
                            @if(!isset($stages) || $stages->isEmpty())
                                @foreach ($lectuers as $lectuer)
                                    <option value="{{ $lectuer->id }}" @selected($item->lecture_id == $lectuer->id)>{{ $lectuer->title }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for="">الملف</label>
                            <input type="file" min="1" value="" name="file" id=""
                                class="form-control-ds">
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="">الحالة</label>
                        <select name="status" id="tax" class="form-control-ds">
                            <option value="1" @selected($item->status == 1)>مفعل</option>
                            <option value="0" @selected($item->status == 0)>غير مفعل</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">@lang('Save')</button>
                </div>
            </form>
        </div>
    </div>
</div>
