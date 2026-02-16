<div class="modal fade" id="showDes{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تفاصيل الكورس</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- <textarea name="" id="" cols="100" class="w-100" disabled rows="15">/textarea> --}}
                {!! $item->description !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">إلغاء</button>
            </div>
        </div>
    </div>
</div>
