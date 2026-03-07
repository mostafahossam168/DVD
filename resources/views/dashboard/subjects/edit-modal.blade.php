<div class="modal fade" id="edit{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تعديل ماده</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('dashboard.subjects.update', $item->id) }}" method="POST"
                enctype="multipart/form-data">
                <div class="modal-body row g-3">
                    @csrf
                    @method('PUT')
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for="">الاسم</label>
                            <input type="text" name="name" value="{{ $item->name }}" id=""
                                class="form-control-ds">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for="">المرحلة الدراسية</label>
                            <select name="stage_id" id="stage_id_subject_edit{{ $item->id }}" class="form-control-ds">
                                <option value="">-- اختر المرحلة --</option>
                                @foreach ($stages as $stage)
                                    <option value="{{ $stage->id }}" @selected($stage->id == $item->grade->stage_id)>
                                        {{ $stage->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for="">الصف الدراسي</label>
                            <select name="grade_id" id="grade_id_subject_edit{{ $item->id }}" class="form-control-ds">
                                <option value="">-- اختر المرحلة أولاً --</option>
                                @foreach ($grades as $grade)
                                    @if($grade->stage_id == $item->grade->stage_id)
                                        <option value="{{ $grade->id }}" @selected($grade->id == $item->grade_id)>
                                            {{ $grade->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for="">السعر (جنيه)</label>
                            <input type="number" name="price" step="0.01" min="0" placeholder="0.00" class="form-control-ds" value="{{ old('price', $item->price ?? '') }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="">الحالة</label>
                        <select name="status" id="tax" class="form-control-ds">
                            <option value="1" @selected($item->status == 1)>مفعل</option>
                            <option value="0" @selected($item->status == 0)>غير مفعل</option>
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
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">@lang('Save')</button>
                </div>
            </form>
        </div>
    </div>
</div>
