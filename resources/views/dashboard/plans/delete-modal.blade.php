<div class="modal fade" id="delete{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">حذف الاشتراك</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('dashboard.plans.destroy', $item->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="confirm-body-ds">
                    <div class="confirm-icon-ds danger-ds">⚠️</div>
                    <h3>هل أنت متأكد من الحذف؟</h3>
                    <p>سيتم حذف الخطة «{{ $item->name }}» بشكل نهائي ولا يمكن التراجع عن هذا الإجراء.</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">نعم، احذف</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                </div>
            </form>
        </div>
    </div>
</div>
