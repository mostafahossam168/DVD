@extends('dashboard.layouts.backend', ['title' => 'تعديل كوبون'])

@section('contant')
    <div class="main-side">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="main-title">
                <div class="small">الرئيسية</div>/
                <div class="small">الكوبونات</div>/
                <div class="large">تعديل كوبون</div>
            </div>
            <div class="btn-holder">
                <a class="main-btn btn-main-color fs-13px" href="{{ route('dashboard.coupons.index') }}">رجوع <i
                        class="fa-solid fa-arrow-left fs-13px"></i>
                </a>
            </div>
        </div>
        <x-alert-component></x-alert-component>
        <form action="{{ route('dashboard.coupons.update', $item->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="row g-4">
                <div class="col-12 col-md-6">
                    <label class="special-input">
                        <span>كود الكوبون</span>
                        <div class="box-input">
                            <input type="text" name="code" value="{{ $item->code }}" id="" placeholder="مثال: STUDENT2024" required>
                        </div>
                        @error('code')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </label>
                </div>
                <div class="col-12 col-md-6">
                    <label class="special-input">
                        <span>اسم الكوبون</span>
                        <div class="box-input">
                            <input type="text" name="name" value="{{ $item->name }}" id="" required>
                        </div>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </label>
                </div>
                <div class="col-12">
                    <label class="special-input">
                        <span>الوصف</span>
                        <div class="box-input">
                            <textarea name="description" id="" rows="3">{{ $item->description }}</textarea>
                        </div>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </label>
                </div>
                <div class="col-12 col-md-6">
                    <label class="special-label" for="type">
                        نوع الخصم</label>
                    <select name="type" id="type" class="form-select select-setting" required onchange="updateValueLabel()">
                        <option value="percentage" @selected($item->type == 'percentage' || old('type') == 'percentage')>نسبة مئوية (%)</option>
                        <option value="fixed" @selected($item->type == 'fixed' || old('type') == 'fixed')>مبلغ ثابت (ر.س)</option>
                    </select>
                    @error('type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12 col-md-6">
                    <label class="special-input">
                        <span id="value-label">قيمة الخصم</span>
                        <div class="box-input">
                            <input type="number" name="value" value="{{ $item->value }}" id="value-input" step="0.01" min="0" required>
                        </div>
                        @error('value')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </label>
                </div>
                <div class="col-12 col-md-6">
                    <label class="special-input">
                        <span>الحد الأدنى للطلب (ر.س)</span>
                        <div class="box-input">
                            <input type="number" name="min_amount" value="{{ $item->min_amount }}" id="" step="0.01" min="0">
                        </div>
                        @error('min_amount')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">اتركه فارغاً إذا لم يكن هناك حد أدنى</small>
                    </label>
                </div>
                <div class="col-12 col-md-6">
                    <label class="special-input">
                        <span>حد الاستخدام</span>
                        <div class="box-input">
                            <input type="number" name="usage_limit" value="{{ $item->usage_limit }}" id="" min="1">
                        </div>
                        @error('usage_limit')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">اتركه فارغاً للاستخدام غير المحدود (المستخدم حالياً: {{ $item->used_count }})</small>
                    </label>
                </div>
                <div class="col-12 col-md-6">
                    <label class="special-input">
                        <span>تاريخ البداية</span>
                        <div class="box-input">
                            <input type="date" name="start_date" value="{{ $item->start_date ? $item->start_date->format('Y-m-d') : '' }}" id="">
                        </div>
                        @error('start_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">اتركه فارغاً للبدء فوراً</small>
                    </label>
                </div>
                <div class="col-12 col-md-6">
                    <label class="special-input">
                        <span>تاريخ النهاية</span>
                        <div class="box-input">
                            <input type="date" name="end_date" value="{{ $item->end_date ? $item->end_date->format('Y-m-d') : '' }}" id="">
                        </div>
                        @error('end_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">اتركه فارغاً للاستخدام الدائم</small>
                    </label>
                </div>
                <div class="col-12 col-md-6">
                    <label class="special-label" for="status">
                        الحالة</label>
                    <select name="status" id="status" class="form-select select-setting" required>
                        <option value="1" @selected($item->status == 1 || old('status') == '1')>مفعل</option>
                        <option value="0" @selected($item->status == 0 || old('status') == '0')>غير مفعل</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <button class="d-flex justify-content-center mt-4 mx-auto" type="submit"> <a class="main-btn"> حفظ
                </a></button>
        </form>
    </div>

    <script>
        function updateValueLabel() {
            const type = document.getElementById('type').value;
            const label = document.getElementById('value-label');
            const input = document.getElementById('value-input');
            
            if (type === 'percentage') {
                label.textContent = 'قيمة الخصم (%)';
                input.setAttribute('max', '100');
            } else if (type === 'fixed') {
                label.textContent = 'قيمة الخصم (ر.س)';
                input.removeAttribute('max');
            }
        }
        
        // تحديث التسمية عند التحميل
        document.addEventListener('DOMContentLoaded', function() {
            updateValueLabel();
        });
    </script>
@endsection
