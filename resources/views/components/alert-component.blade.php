@php
    if (session()->has('error')) {
        ToastMagic::error(session('error'));
    }
    if (session()->has('success')) {
        ToastMagic::success(session('success'));
    }
    if ($errors->any()) {
        ToastMagic::error($errors->getBag('default'));
    }
@endphp

