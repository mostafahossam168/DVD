@extends('dashboard.layouts.backend', ['title' => 'الاعدادات'])
@section('css')
    <style>
        .multi-accounts-ds {
            border: 1px solid #e8ecf4;
            border-radius: 14px;
            padding: 14px;
            background: #fff;
        }

        .multi-accounts-title-ds {
            font-weight: 800;
            color: #1f2a44;
            margin-bottom: 4px;
            font-size: .98rem;
        }

        .multi-accounts-help-ds {
            color: #7a859f;
            font-size: .8rem;
            margin-bottom: 12px;
        }

        .multi-row-ds {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .multi-row-ds input {
            flex: 1;
        }

        .multi-del-ds {
            border: 0;
            background: transparent;
            color: #dc2626;
            width: 28px;
            height: 28px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .multi-del-ds:hover {
            background: #fef2f2;
        }

        .multi-actions-ds {
            display: flex;
            gap: 8px;
            margin-top: 10px;
        }

        @media (max-width: 768px) {
            .multi-actions-ds {
                flex-wrap: wrap;
            }
        }
    </style>
@endsection
@section('contant')
    @php
        $splitNumbers = function (?string $value) {
            return collect(preg_split('/[\r\n,]+/', (string) $value))
                ->map(fn($item) => trim($item))
                ->filter()
                ->values();
        };
        $vodafoneNumbers = $splitNumbers(setting('vodafone_cash_numbers'));
        if ($vodafoneNumbers->isEmpty()) {
            $vodafoneNumbers = collect(['']);
        }
        $instapayNumbers = $splitNumbers(setting('instapay_numbers'));
        if ($instapayNumbers->isEmpty()) {
            $instapayNumbers = collect(['']);
        }
    @endphp
    <div class="dash-page">
        <div class="page-breadcrumb fade-up-ds">
            <a href="{{ route('dashboard.home') }}">الرئيسية</a>
            <span class="sep">/</span>
            <span class="current">الإعدادات</span>
        </div>
        <div class="page-header-ds fade-up-ds">
            <h1>الإعدادات العامة</h1>
        </div>

        <form action="{{ route('dashboard.update-settings') }}" enctype="multipart/form-data" method="post"
            class="fade-up-ds delay-1-ds">
            @csrf
            <div class="form-card-ds">
                <div class="form-card-header-ds">
                    <div class="fch-icon-ds" style="background:#e0e7ff">⚙️</div>
                    <div>
                        <h2>بيانات الموقع والتواصل</h2>
                        <p>الاسم، الرابط، العنوان ووسائل التواصل.</p>
                    </div>
                </div>
                <div class="form-card-body-ds">
                    <div class="form-grid-ds">
                        <div class="form-group-ds">
                            <label class="form-label-ds">إسم الموقع</label>
                            <input type="text" name="website_name" class="form-control-ds"
                                value="{{ setting('website_name') }}">
                        </div>
                        <div class="form-group-ds">
                            <label class="form-label-ds">رابط الموقع</label>
                            <input type="url" name="website_url" class="form-control-ds"
                                value="{{ setting('website_url') }}">
                        </div>
                        <div class="form-group-ds">
                            <label class="form-label-ds">الرقم الضريبي</label>
                            <input type="number" name="tax_number" class="form-control-ds"
                                value="{{ setting('tax_number') }}">
                        </div>
                        <div class="form-group-ds">
                            <label class="form-label-ds">العنوان</label>
                            <input type="text" name="address" class="form-control-ds" value="{{ setting('address') }}">
                        </div>
                        <div class="form-group-ds">
                            <label class="form-label-ds">رقم المبنى</label>
                            <input type="number" name="building_number" class="form-control-ds"
                                value="{{ setting('building_number') }}">
                        </div>
                        <div class="form-group-ds">
                            <label class="form-label-ds">الشارع</label>
                            <input type="text" name="street_number" class="form-control-ds"
                                value="{{ setting('street_number') }}">
                        </div>
                        <div class="form-group-ds">
                            <label class="form-label-ds">رقم الهاتف</label>
                            <input type="tel" name="phone" class="form-control-ds" value="{{ setting('phone') }}">
                        </div>
                        <div class="form-group-ds">
                            <label class="form-label-ds">رقم الواتس</label>
                            <input type="tel" name="whatsapp" class="form-control-ds" value="{{ setting('whatsapp') }}">
                        </div>
                        <div class="form-group-ds">
                            <label class="form-label-ds">فيسبوك</label>
                            <input type="text" name="facebook" class="form-control-ds"
                                value="{{ setting('facebook') }}">
                        </div>
                        <div class="form-group-ds">
                            <label class="form-label-ds">يوتيوب</label>
                            <input type="text" name="youtube" class="form-control-ds" value="{{ setting('youtube') }}">
                        </div>
                        <div class="form-group-ds">
                            <label class="form-label-ds">انستجرام</label>
                            <input type="text" name="instagram" class="form-control-ds"
                                value="{{ setting('instagram') }}">
                        </div>
                        <div class="form-group-ds" style="grid-column:1/-1">
                            <div class="multi-accounts-ds">
                                <div class="multi-accounts-title-ds">📞 أرقام فودافون كاش (يمكن إضافة عدة أرقام)</div>
                                <div class="multi-accounts-help-ds">أضف رقم واحد أو أكثر، الطالب سيختار الرقم الذي يحوّل إليه.</div>
                                <div id="vodafoneRows">
                                    @foreach ($vodafoneNumbers as $num)
                                        <div class="multi-row-ds">
                                            <button type="button" class="multi-del-ds" onclick="removeAccountRow(this)" title="حذف">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path></svg>
                                            </button>
                                            <input type="text" name="vodafone_cash_numbers[]" class="form-control-ds" placeholder="01000000000" value="{{ $num }}">
                                        </div>
                                    @endforeach
                                </div>
                                <div class="multi-actions-ds">
                                    <button type="button" class="btn-ds btn-secondary-ds" onclick="addAccountRow('vodafoneRows', 'vodafone_cash_numbers[]', '01000000000')">+ إضافة رقم فودافون كاش آخر</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group-ds" style="grid-column:1/-1">
                            <div class="multi-accounts-ds">
                                <div class="multi-accounts-title-ds">💳 حسابات انستاباي (يمكن إضافة عدة حسابات)</div>
                                <div class="multi-accounts-help-ds">أضف رقم واحد أو أكثر من حسابات انستاباي ليستقبل الطالب عليها التحويل.</div>
                                <div id="instapayRows">
                                    @foreach ($instapayNumbers as $num)
                                        <div class="multi-row-ds">
                                            <button type="button" class="multi-del-ds" onclick="removeAccountRow(this)" title="حذف">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path></svg>
                                            </button>
                                            <input type="text" name="instapay_numbers[]" class="form-control-ds" placeholder="01000000000" value="{{ $num }}">
                                        </div>
                                    @endforeach
                                </div>
                                <div class="multi-actions-ds">
                                    <button type="button" class="btn-ds btn-secondary-ds" onclick="addAccountRow('instapayRows', 'instapay_numbers[]', '01000000000')">+ إضافة حساب انستاباي آخر</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group-ds">
                            <label class="form-label-ds">رقم الحساب (الايبان)</label>
                            <input type="text" name="iban" class="form-control-ds" value="{{ setting('iban') }}">
                        </div>
                        <div class="form-group-ds">
                            <label class="form-label-ds">تفعيل الضريبة</label>
                            <select name="is_tax" id="tax" class="form-control-ds">
                                <option value="1" @selected(setting('is_tax') == 1)>مفعل</option>
                                <option value="0" @selected(setting('is_tax') == 0)>غير مفعل</option>
                            </select>
                        </div>
                        <div class="form-group-ds">
                            <label class="form-label-ds">تفعيل ارسال البريد الالكتروني</label>
                            <select name="email_status" id="emailStatus" class="form-control-ds">
                                <option value="">-- اختر --</option>
                                <option value="1">مفعل</option>
                                <option value="0">غير مفعل</option>
                            </select>
                        </div>
                        <div class="form-group-ds">
                            <label class="form-label-ds">حالة الموقع</label>
                            <select name="website_status" id="siteStatus" class="form-control-ds">
                                <option value="">-- اختر --</option>
                                <option value="1" @selected(setting('website_status') == 1)>مفعل</option>
                                <option value="0" @selected(setting('website_status') == 0)>غير مفعل</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-divider-ds">الشعار والأيقونة</div>
                    <div class="form-grid-ds">
                        <div class="form-group-ds">
                            <label class="form-label-ds">صورة الشعار</label>
                            <input type="file" name="logo" id="siteLogo" class="form-control-ds"
                                accept="image/*">
                            @if (setting('logo'))
                                <div class="mt-2"><img src="{{ display_file(setting('logo')) }}" alt=""
                                        style="width:70px;height:70px;object-fit:contain;"></div>
                            @endif
                        </div>
                        <div class="form-group-ds">
                            <label class="form-label-ds">صورة أيقونة المتصفح</label>
                            <input type="file" name="fav" class="form-control-ds" accept="image/*">
                            @if (setting('fav'))
                                <div class="mt-2"><img src="{{ display_file(setting('fav')) }}" alt=""
                                        style="width:70px;height:70px;object-fit:contain;"></div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">رسالة تعطيل الموقع</label>
                        <textarea name="maintainance_message" class="form-control-ds" rows="4"
                            placeholder="نعتذر الموقع مغلق للصيانة ...">{{ setting('maintainance_message') }}</textarea>
                    </div>
                </div>
                <div class="form-card-footer-ds">
                    <button type="submit" class="btn-ds btn-success-ds">حفظ التعديلات</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        function addAccountRow(containerId, inputName, placeholder) {
            var container = document.getElementById(containerId);
            if (!container) return;

            var row = document.createElement('div');
            row.className = 'multi-row-ds';
            row.innerHTML = `
                <button type="button" class="multi-del-ds" onclick="removeAccountRow(this)" title="حذف">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path></svg>
                </button>
                <input type="text" name="${inputName}" class="form-control-ds" placeholder="${placeholder}" value="">
            `;
            container.appendChild(row);
        }

        function removeAccountRow(btn) {
            var row = btn.closest('.multi-row-ds');
            if (!row) return;
            var parent = row.parentElement;
            if (!parent) return;

            if (parent.querySelectorAll('.multi-row-ds').length <= 1) {
                var input = row.querySelector('input');
                if (input) input.value = '';
                return;
            }
            row.remove();
        }
    </script>
@endpush
