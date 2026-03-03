@auth
    @if (auth()->user()->type === 'student')
        <button type="button"
                class="favorite-btn btn btn-link p-0 border-0 text-decoration-none {{ ($isFavorite ?? false) ? 'favorited' : '' }}"
                data-subject-id="{{ $subject->id }}"
                data-favorite-url="{{ route('front.favorites.toggle', $subject) }}"
                title="{{ ($isFavorite ?? false) ? 'إزالة من المفضلة' : 'إضافة للمفضلة' }}"
                aria-label="{{ ($isFavorite ?? false) ? 'إزالة من المفضلة' : 'إضافة للمفضلة' }}">
            <i class="fa-{{ ($isFavorite ?? false) ? 'solid' : 'regular' }} fa-heart favorite-icon"></i>
        </button>
    @endif
@endauth
