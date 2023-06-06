@extends('layouts.master')
@section('content')
    @include('layouts.partials.header')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Categories</h6>
            <a href="" class="btn btn-primary btn-icon-split fr">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Create</span>
            </a>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>{{ __('Category Name') }}</th>
                        </tr>
                    </thead>

                    <tbody>


                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@include('layouts.partials.scripts')

<script>
  $(document).ready(function() {
  $.ajax({
    url: '/api/categories', // Replace with your API endpoint
    method: 'GET',
    success: function(response) {
      // Loop through the vendor data and append rows to the table
      console.log(response['data']);
      for (var i = 0; i < response['data'].length; i++) {
        var category = response['data'][i];

        var newRow = '<tr>' +
          '<td>' + category.name + '</td>' +
          '</tr>';
        $('#dataTable tbody').append(newRow);
      }
    },
    error: function(xhr, status, error) {
      console.log(error);
      // Handle error case
    }
  });
});

</script>
