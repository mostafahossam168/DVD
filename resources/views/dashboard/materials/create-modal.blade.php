<div class="modal fade" id="create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">إضافة ملف جديد</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('dashboard.materials.store') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body row g-3">
                    @csrf
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for="">العنوان</label>
                            <input type="text" name="title" id="" class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="">الدرس</label>
                        <select name="lecture_id" id="tax" class="form-select select-setting">
                            <option value="">-- اختر --</option>
                            @foreach ($lectuers as $lectuer)
                                <option value="{{ $lectuer->id }}">{{ $lectuer->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for="">الملف</label>
                            <input type="file" min="1" value="" name="file" id=""
                                class="form-control">
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="">الحالة</label>
                        <select name="status" id="tax" class="form-select select-setting">
                            <option value="">-- اختر --</option>
                            <option value="1">مفعل</option>
                            <option value="0">غير مفعل</option>
                        </select>
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
