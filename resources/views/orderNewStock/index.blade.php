@extends('layout.master')
@push('scripts')
<script src="{{ asset('js/app.js') }}"></script>
@endpush
@section('style')
<style>
</style>
@endsection
@section('content')
<div class="row">
     <div class="col-lg-12 margin-tb">
         <div class="pull-left">
             <h2>Orders</h2>
         </div>
     </div>
 </div>

 @if ($message = Session::get('success'))
     <div class="alert alert-success">
         <p>{{ $message }}</p>
     </div>
 @endif
<table class="uk-table uk-table-small uk-table-divider">
  <thead>
    <tr>
      <th scope="col">Warehouse ID</th>
      <th scope="col">Order Date</th>
      <th scope="col">Delivery No.</th>
      <th scope="col">Invoice No.</th>
      <th scope="col">Company</th>
      <th scope="col">Status</th>
      <th scope="col" width="30%">Notes</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($warehouses as $warehouse)
    <tr>
        <td>{{ $warehouse->warehouse_id }}</td>
        <td>{{ $warehouse->created_at->format('Y-m-d') }}</td>
        <td>{{ $warehouse->warehouse_address_id }}</td>
        <td></td>
        <td>{{ $warehouse->company_name }}</td>
        <td>{{ $warehouse->warehouse_status }}</td>
        <td></td>
    </tr>
    @endforeach
  </tbody>
</table>

<div class="d-flex justify-content-center">
  {!! $warehouses->links() !!}
</div>
@endsection
