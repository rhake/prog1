@if (session('success'))
    <div class="flash flash-ok">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="flash flash-danger">{{ session('error') }}</div>
@endif
@if ($errors->any())
    <div class="flash flash-danger">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif
