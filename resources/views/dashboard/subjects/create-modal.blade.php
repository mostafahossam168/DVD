<div class="modal fade" id="create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">إضافة ماده جديد</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('dashboard.subjects.store') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body row g-3">
                    @csrf
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for="">الاسم</label>
                            <input type="text" name="name" id="" class="form-control-ds">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for="">المرحلة الدراسية</label>
                            <select name="stage_id" id="stage_id_subject" class="form-control-ds">
                                <option value="">-- اختر المرحلة --</option>
                                @foreach ($stages as $stage)
                                    <option value="{{ $stage->id }}">
                                        {{ $stage->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for="">الصف الدراسي</label>
                            <select name="grade_id" id="grade_id_subject" class="form-control-ds">
                                <option value="">-- اختر المرحلة أولاً --</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for="teacher_id">المعلمين</label>

                            <select name="teacher_id[]" id="teacher_id" class="form-control-ds" multiple size="6"
                                style="min-height: 150px;">
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">
                                        {{ $teacher->fullname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="">الحالة</label>
                        <select name="status" id="tax" class="form-control-ds">
                            <option value="">-- اختر --</option>
                            <option value="1">مفعل</option>
                            <option value="0">غير مفعل</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for="">الصوره</label>
                            <input type="file" name="image" id="" class="form-control-ds">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">@lang('Save')</button>
                </div>
            </form>

        </div>
    </div>
</div>
