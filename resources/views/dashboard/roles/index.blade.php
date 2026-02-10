@extends('dashboard.layouts.backend', ['title' => 'الصلاحيات'])

@section('contant')
    <div class="main-side">
        <div class="main-title">
            <div class="small">الرئيسية</div>
            <div class="large">الصلاحيات</div>
        </div>

        <div class="bar-obtions d-flex align-items-end justify-content-between flex-wrap gap-3 mb-4">
            <div class="row flex-fill g-3">
                <div class="d-flex align-items-center gap-2 mt-2">
                    @can('create_roles')
                        <a href="{{ route('dashboard.roles.create') }}" class="main-btn "><i class="fas fa-plus"></i> اضافة
                        </a>
                    @endcan
                    <a href="{{ route('dashboard.admins.index') }}" class="main-btn btn-main-color">الكل :
                        {{ Spatie\Permission\Models\Role::count() }}</a>
                </div>
            </div>
            <div class="box-search">
                <form action="">
                    <img src="{{ asset('dashboard/img/icons/search.png') }}" alt="icon" />
                    <input type="search" id="" value="{{ request('search') }}" name="search"
                        placeholder="@lang('Search')" />
                </form>
            </div>

        </div>
        <x-alert-component></x-alert-component>
        <div class="table-responsive">
            <table class="main-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td> {{ $item->name }}</td>
                            <td>
                                <div class="btn-holder d-flex align-items-center gap-3">
                                    @can('read_roles')
                                        <a href="{{ route('dashboard.roles.show', $item->id) }}"
                                            class="btn btn-info btn-sm text-white mx-1">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    @endcan
                                    @can('update_roles')
                                        <a href="{{ route('dashboard.roles.edit', $item->id) }}"
                                            class="btn btn-primary btn-sm text-white mx-1">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    @endcan
                                    @if (\Spatie\Permission\Models\Role::first()->id != $item->id)
                                        @can('delete_roles')
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#delete{{ $item->id }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        @endcan
                                    @endif
                                </div>
                                @include('dashboard.roles.delete-model', ['item' => $item])
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <br>
        {{ $items->links() }}

    </div>
@endsection
