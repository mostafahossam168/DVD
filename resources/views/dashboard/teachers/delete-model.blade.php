<div class="modal fade" id="delete{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">حذف المعلم</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('dashboard.teachers.destroy', $item->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    هل أنت متأكد من حذف المعلم ؟
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary btn-sm px-3" data-bs-dismiss="modal">نعم</button>
                </div>
            </form>
        </div>
    </div>
</div>
