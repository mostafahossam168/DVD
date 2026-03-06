<div class="modal fade" id="create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">إضافة اختبار جديد</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('dashboard.quizes.store') }}" method="POST">
                <div class="modal-body row g-3">
                    @csrf
                    <div class="col-12">
                        <div class="form-group mb-1">
                            <label for="">العنوان</label>
                            <input type="text" name="title" id="" class="form-control-ds">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group mb-2">
                            <label for="">الدرس</label>
                            <select name="lecture_id" id="" class="form-control-ds">
                                <option value="">-- اختر --</option>
                                @foreach ($lectuers as $lectuer)
                                    <option value="{{ $lectuer->id }}">
                                        {{ $lectuer->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group mb-1">
                            <label for="">المدة (دقيقة)</label>
                            <input type="number" name="duration_minutes" id="" class="form-control-ds" min="1" max="300" value="60" placeholder="مثال: 60">
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="tax">الحالة</label>
                        <select name="status" id="tax" class="form-control-ds">
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
