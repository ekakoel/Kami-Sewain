@extends('layouts.user-base')

@section('title', 'Orders')

@section('main')
  <main class="flex-shrink-0">
    <div class="header-container">
      <div class="header-caption">
          <div class="header-title">{!! $page_properties?$page_properties->slider_title:"Orders"; !!}</div>
          <p>{!! $page_properties?$page_properties->slider_caption:"Wedding Equipment and Facilities"; !!}</p>
      </div>
    </div>
    <div class="section-container">
      <div class="row">
        
        <div class="col-md-8">
          @if (session('success'))
              <div class="alert alert-success">
                  {{ session('success') }}
              </div>
          @endif
          @if (session('error'))
              <div class="alert alert-danger">
                  {{ session('error') }}
              </div>
          @endif
          <div class="card-box m-b-18">
            <div class="card-box-header">
              <div class="card-box-title">Active Orders</div>
            </div>
            <div class="card-box-body">
              @if (count($orders)>0)
                <table id="orderTable" class="data-table table stripe hover nowrap">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Order No</th>
                      <th>Rental Date</th>
                      <th>Total</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($orders as $no=>$order)
                      <tr>
                        <td class="text-center">
                          {{ ++$no }}
                        </td>
                        <td>{{ $order->order_no }}</td>
                        <td>{{ date('d M Y',strtotime($order->rental_start_date)) }} - {{ date('d M Y',strtotime($order->rental_end_date)) }}</td>
                        <td>Rp {{ number_format($order->total_price, 0, ",", ".") }}</td>
                        <td>{{ $order->status }}</td>
                        <td>
                          <div class="table-action-container">
                            <a href="{{ route('orders.detail',$order->order_no) }}"><i class="fa-solid fa-eye"></i></a>
                            @if ($order->status == 'Payment')
                              <a href="#" data-toggle="modal" data-target="#destroyOrder{{ $order->id }}" type="button"><i class="fa-solid fa-trash"></i></a>
                            @endif
                          </div>
                          <div class="modal fade" id="destroyOrder{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myLargeModalLabel">Delete Order</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="formDestroyOrder{{ $order->id }}" action="{{ route('orders.destroy',$order->order_no) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <p>Are you sure you want to delete order {{ $order->order_no }}?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn button-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                                        <button type="submit" form="formDestroyOrder{{ $order->id }}" class="btn button-secondary"><i class="fas fa-check"></i> Yes</button>
                                    </div>
                                </div>
                            </div>
                          </div>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              @else
                <div class="alert alert-warning" role="alert">
                  Your order is empty. <a href="{{ route('products.index') }}" class="alert-link">Start shopping!</a>
                </div>
              @endif
            </div>
          </div>
          @if (count($order_history)>0)
          <div class="card-box m-b-18">
            <div class="card-box-header">
              <div class="card-box-title">Order History</div>
            </div>
            <div class="card-box-body">
                <table id="orderTable" class="data-table table stripe hover nowrap">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Order No</th>
                      <th>Rental Date</th>
                      <th>Total</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($order_history as $no=>$order)
                      <tr>
                        <td class="text-center">
                          {{ ++$no }}
                        </td>
                        <td>{{ $order->order_no }}</td>
                        <td>{{ date('d M Y',strtotime($order->rental_start_date)) }} - {{ date('d M Y',strtotime($order->rental_end_date)) }}</td>
                        <td>Rp {{ number_format($order->total_price, 0, ",", ".") }}</td>
                        <td>{{ $order->status == "Payment"?"Canceled":$order->status; }}</td>
                        <td>
                          <div class="table-action-container">
                            <a href="{{ route('orders.detail',$order->order_no) }}">
                              <i class="fa-solid fa-eye"></i>
                            </a>
                          </div>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            @endif
          
        </div>
        <div class="col-md-3"></div>
      </div>
    </div>
    {{-- FLOATING BUTTON --}}
    <a href="javascript:history.back()" class="floating-btn">
      <i class="fas fa-arrow-left"></i>
    </a>
    <script>
      window.addEventListener('popstate', function(event) {
        window.location.reload();
      });
      document.getElementById('backButton').addEventListener('click', function (event) {
          event.preventDefault();
          window.history.back();
      });
    </script>
  </main>
  @include('layouts.partials.footer-secondary')
@endsection