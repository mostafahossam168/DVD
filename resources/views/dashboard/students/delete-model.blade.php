<div class="modal fade" id="delete{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <span class="modal-icon" style="background:#fef2f2">🗑️</span>
                    حذف طالب
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('dashboard.students.destroy', $item->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="confirm-body-ds">
                    <div class="confirm-icon-ds danger-ds">⚠️</div>
                    <h3>هل أنت متأكد من الحذف؟</h3>
                    <p>سيتم حذف الطالب «{{ $item->full_name ?? $item->email }}» بشكل نهائي ولا يمكن التراجع عن هذا الإجراء.</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                        نعم، احذف
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                </div>
            </form>
        </div>
    </div>
</div>
