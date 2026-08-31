@extends('admin.layout.main')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Global Settings</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Settings</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Manage Global Settings</h3>
                    </div>
                    
                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="marquee_text">Scrolling Marquee Text (Header)</label>
                                <textarea name="marquee_text" id="marquee_text" class="form-control" rows="4" placeholder="Enter text that will scroll across the top of the website">{{ old('marquee_text', $marqueeText) }}</textarea>
                                <small class="text-muted">You can use HTML tags like &lt;span class="text-danger"&gt; for colored text.</small>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Save Settings</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
