@extends('dashboard.layouts.backend', ['title' => 'تعديل كوبون'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <a href="{{ route('dashboard.coupons.index') }}">الكوبونات</a>
        <span class="sep">/</span>
        <span class="current">تعديل كوبون</span>
    </div>
    <div class="page-header-ds fade-up-ds">
        <h1>تعديل كوبون</h1>
    </div>
    <a href="{{ route('dashboard.coupons.index') }}" class="btn-back-ds fade-up-ds">رجوع</a>
    <x-alert-component></x-alert-component>
    <form action="{{ route('dashboard.coupons.update', $item->id) }}" method="post" class="fade-up-ds delay-1-ds">
        @csrf
        @method('PUT')
        <div class="form-card-ds">
            <div class="form-card-header-ds">
                <div class="fch-icon-ds" style="background:#fef3c7">🎫</div>
                <div>
                    <h2>{{ $item->code }}</h2>
                    <p>تعديل بيانات الكوبون.</p>
                </div>
            </div>
            <div class="form-card-body-ds">
                <div class="form-grid-ds">
                    <div class="form-group-ds">
                        <label class="form-label-ds">كود الكوبون <span class="required-ds">*</span></label>
                        <input type="text" name="code" class="form-control-ds" value="{{ old('code', $item->code) }}" placeholder="مثال: STUDENT2024" required>
                        @error('code')<span class="form-error-ds" style="font-size:.76rem;color:#dc2626">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">اسم الكوبون <span class="required-ds">*</span></label>
                        <input type="text" name="name" class="form-control-ds" value="{{ old('name', $item->name) }}" required>
                        @error('name')<span class="form-error-ds" style="font-size:.76rem;color:#dc2626">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">نوع الخصم <span class="required-ds">*</span></label>
                        <select name="type" id="type" class="form-control-ds" required onchange="updateValueLabel()">
                            <option value="percentage" @selected($item->type == 'percentage' || old('type') == 'percentage')>نسبة مئوية (%)</option>
                            <option value="fixed" @selected($item->type == 'fixed' || old('type') == 'fixed')>مبلغ ثابت (ر.س)</option>
                        </select>
                        @error('type')<span class="form-error-ds" style="font-size:.76rem;color:#dc2626">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds" id="value-label">قيمة الخصم (%) <span class="required-ds">*</span></label>
                        <input type="number" name="value" class="form-control-ds" value="{{ old('value', $item->value) }}" id="value-input" step="0.01" min="0" required>
                        @error('value')<span class="form-error-ds" style="font-size:.76rem;color:#dc2626">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">الحد الأدنى للطلب (ر.س)</label>
                        <input type="number" name="min_amount" class="form-control-ds" value="{{ old('min_amount', $item->min_amount) }}" step="0.01" min="0">
                        @error('min_amount')<span class="form-error-ds" style="font-size:.76rem;color:#dc2626">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">حد الاستخدام</label>
                        <input type="number" name="usage_limit" class="form-control-ds" value="{{ old('usage_limit', $item->usage_limit) }}" min="1">
                        @error('usage_limit')<span class="form-error-ds" style="font-size:.76rem;color:#dc2626">{{ $message }}</span>@enderror
                        <small class="form-hint-ds">المستخدم حالياً: {{ $item->used_count }}</small>
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">تاريخ البداية</label>
                        <input type="date" name="start_date" class="form-control-ds" value="{{ old('start_date', $item->start_date ? $item->start_date->format('Y-m-d') : '') }}">
                        @error('start_date')<span class="form-error-ds" style="font-size:.76rem;color:#dc2626">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">تاريخ النهاية</label>
                        <input type="date" name="end_date" class="form-control-ds" value="{{ old('end_date', $item->end_date ? $item->end_date->format('Y-m-d') : '') }}">
                        @error('end_date')<span class="form-error-ds" style="font-size:.76rem;color:#dc2626">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">الحالة <span class="required-ds">*</span></label>
                        <select name="status" class="form-control-ds" required>
                            <option value="1" @selected(old('status', $item->status) == 1)>مفعل</option>
                            <option value="0" @selected(old('status', $item->status) == 0)>غير مفعل</option>
                        </select>
                        @error('status')<span class="form-error-ds" style="font-size:.76rem;color:#dc2626">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="form-divider-ds">الوصف</div>
                <div class="form-group-ds" style="grid-column:1 / -1">
                    <label class="form-label-ds">الوصف</label>
                    <textarea name="description" class="form-control-ds" rows="3">{{ old('description', $item->description) }}</textarea>
                    @error('description')<span class="form-error-ds" style="font-size:.76rem;color:#dc2626">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="form-card-footer-ds">
                <button type="submit" class="btn-ds btn-success-ds">حفظ التعديلات</button>
                <a href="{{ route('dashboard.coupons.index') }}" class="btn-ds btn-secondary-ds">إلغاء</a>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function updateValueLabel() {
    var type = document.getElementById('type') && document.getElementById('type').value;
    var label = document.getElementById('value-label');
    var input = document.getElementById('value-input');
    if (!label || !input) return;
    if (type === 'percentage') {
        label.innerHTML = 'قيمة الخصم (%) <span class="required-ds">*</span>';
        input.setAttribute('max', '100');
    } else if (type === 'fixed') {
        label.innerHTML = 'قيمة الخصم (ر.س) <span class="required-ds">*</span>';
        input.removeAttribute('max');
    }
}
document.addEventListener('DOMContentLoaded', function() { updateValueLabel(); });
</script>
@endpush