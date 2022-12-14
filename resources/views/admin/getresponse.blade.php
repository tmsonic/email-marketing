@extends('layouts.backend.admin-app')


@push('css')

@endpush

@section('content')



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">{{ __("admin.gr_settings") }}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">{{ __("admin.home") }}</a></li>
              <li class="breadcrumb-item active">{{ __("admin.gr_settings") }}</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <!-- Update messages -->
        <div class="row">
            <div class="col-lg-12">
                @if(session('successMsg'))
                    <div class="alert alert-success" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>{{ session('successMsg') }}</strong>
                    </div>
                @endif

                @if(session('failureMsg'))
                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>{!! session('failureMsg') !!}</strong>
                    </div>
                @endif
            </div>
        </div>  <!-- /. Update messages -->

        <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">{{ __("admin.gr_settings") }}</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{route('admin.getresponse.update')}}" method="POST" class="form-horizontal">
                @csrf
                @method('PUT')
              <div class="card-body">

                <div class="row">
                    <div class="col-sm-5">
                        <h6 style="font-weight: 600; text-transform: uppercase;">{{ __("admin.gr_api_key") }}</h6>
                        <p style="font-size: 14px;">{{ __("admin.gr_api_key_info") }}</p>
                    </div>

                    <div class="col-sm-7">
                        <input class="form-control" name="api_key" type="text" value="{{ old('api_key', $config->api_key) }}">
                        <p style="color:red;">{{ $errors->first('api_key') }}</p>
                    </div>
                </div>

                <hr style="background: #ccc;">

                <div class="row">
                    <div class="col-sm-5">
                        <h6 style="font-weight: 600; text-transform: uppercase;">{{ __("admin.gr_email_list") }}</h6>
                        <p style="font-size: 14px;">{{ __("admin.gr_email_list_info") }}</p>
                    </div>

                    <div class="col-sm-7">
                        <input class="form-control" name="list_token" type="text" value="{{ old('list_token', $config->list_token) }}">
                        <p style="color:red;">{{ $errors->first('list_token') }}</p>
                    </div>
                </div>

                <hr style="background: #ccc;">


              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="submit" class="btn btn-info">{{ __("admin.save_settings") }}</button>
              </div>
              <!-- /.card-footer -->
            </form>
          </div>


      </div><!-- /.container-fluid -->
    </section>


    <!-- /.content -->
  </div>

  <!-- /.content-wrapper -->

  @endsection

@push('js')

@endpush
