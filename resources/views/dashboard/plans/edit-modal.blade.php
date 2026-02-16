<div class="modal fade" id="edit{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تعديل الاشتراك</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('dashboard.plans.update', $item->id) }}" method="POST">
                <div class="modal-body row g-3">
                    @csrf
                    @method('PUT')
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for="">الاسم</label>
                            <input type="text" name="name" value="{{ $item->name }}" id=""
                                class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="">الحالة</label>
                        <select name="status" id="tax" class="form-select select-setting">
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
