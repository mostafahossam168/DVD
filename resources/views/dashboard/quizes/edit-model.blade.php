<div class="modal fade" id="edit{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> تعديل اختبار</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('dashboard.quizes.update', $item->id) }}" method="POST">
                <div class="modal-body row g-3">
                    @csrf
                    @method('PUT')
                    <div class="col-12">
                        <div class="form-group mb-1">
                            <label for="">العنوان</label>
                            <input type="text" name="title" id="" value="{{ $item->title }}"
                                class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group mb-2">
                            <label for="">الدرس</label>
                            <select name="lecture_id" id="" class="form-control">
                                <option value="">-- اختر --</option>
                                @foreach ($lectuers as $lectuer)
                                    <option value="{{ $lectuer->id }}" @selected($lectuer->id == $item->lecture_id)>
                                        {{ $lectuer->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group mb-1">
                            <label for="">المدة (دقيقة)</label>
                            <input type="number" name="duration_minutes" id="" class="form-control" min="1" max="300" value="{{ $item->duration_minutes ?? 60 }}" placeholder="مثال: 60">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group mb-1">
                            <label for="">الحالة</label>
                            <select name="status" id="" class="form-control">
                                <option value="1" @selected($item->status == 1)>مفعل</option>
                                <option value="0" @selected($item->status == 0)>غير مفعل</option>
                            </select>
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
