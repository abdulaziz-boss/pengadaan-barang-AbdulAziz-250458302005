@if(auth()->check())
    @switch(auth()->user()->role)
        @case('admin')
            @include('livewire.atom.sidebar.admin')
            @break

        @case('staff')
            @include('livewire.atom.sidebar.staff')
            @break

        @case('manager')
            @include('livewire.atom.sidebar.manager')
            @break
    @endswitch
@endif
