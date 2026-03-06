<div class="modal fade" id="delete{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <span class="modal-icon" style="background:#fef2f2">🗑️</span>
                    حذف درس
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('dashboard.lectuers.destroy', $item->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="confirm-body-ds">
                    <div class="confirm-icon-ds danger-ds">⚠️</div>
                    <h3>هل أنت متأكد من الحذف؟</h3>
                    <p>سيتم حذف الدرس «{{ $item->title }}» ولا يمكن التراجع.</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">نعم، احذف</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                </div>
            </form>
        </div>
    </div>
</div>
