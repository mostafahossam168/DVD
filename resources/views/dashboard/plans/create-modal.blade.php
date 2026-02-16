<div class="modal fade" id="create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">إضافة اشتراك جديد</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('dashboard.plans.store') }}" method="POST">
                <div class="modal-body row g-3">
                    @csrf
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for="">الاسم</label>
                            <input type="text" name="name" id="" class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for="">السعر</label>
                            <input type="number" min="1" value="" name="price" id=""
                                class="form-control">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mb-3">
                            <label for="">عدد الطلاب</label>
                            <input type="number" min="1" value="0" name="students_limit" id=""
                                class="form-control">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mb-3">
                            <label for="">عدد المواد</label>
                            <input type="number" min="1" value="0" name="subjects_limit" id=""
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
