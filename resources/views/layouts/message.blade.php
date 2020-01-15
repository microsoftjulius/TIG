@if($errors->any())
    <div class="alert alert-danger alert-dismissible show" role="alert">
        {{ $errors->first() }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(session()->has('message'))
    <div class="alert alert-success alert-dismissible show" role="alert">
        {{ session()->get('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif