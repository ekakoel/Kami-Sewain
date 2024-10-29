@extends('layouts.user-base')

@section('title', 'History')

@section('main')

<div class="container">
  <div class="row row--grid">
    <!-- breadcrumb -->
    <div class="col-12">
      <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Welcome</a></li>
        <li class="breadcrumb-item breadcrumb-item--active">History</li>
      </ul>
    </div>
    <!-- end breadcrumb -->

    <!-- title -->
    <div class="col-12">
      <div class="main-title main-title--page">
        <h1>Active Order</h1>
      </div>
    </div>
    <!-- end title -->
  </div>

  <div class="row row--grid">
    <div class="col-12">
      <!-- content tabs -->
      <div class="tab-content">
        <div class="tab-pane fade show active" id="tab-1" role="tabpanel">
          <div class="row row--grid">
            <div class="col-12">
              <!-- cart -->
              <div class="cart">
                <div class="cart-table-wrap">
                  <div class="cart-table-scroll">
                    <table id="orderTable" class="data-table table stripe hover nowrap">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Order No</th>
                          <th>Rental Start Date</th>
                          <th>Rental End Date</th>
                          <th>Payment Status</th>
                          <th>Payment Method</th>
                          <th>Total</th>
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
                            <td>{{ date('d M Y',strtotime($order->rental_start_date)) }}</td>
                            <td>{{ date('d M Y',strtotime($order->rental_end_date)) }}</td>
                            <td>{{ $order->payment_status }}</td>
                            <td>{{ $order->payment_method }}</td>
                            <td>Rp {{ number_format($order->total, 0, ",", ".") }}</td>
                            <td>
                              <div class="table-action-container">
                                <a href="#" data-toggle="modal" data-target="#detail-{{ $order->id }}">
                                  <i class="fa-solid fa-eye"></i>
                                </a>
                              </div>
                            </td>
                          </tr>
                          <div class="modal fade" id="detail-{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myLargeModalLabel">Order Detail</h4><br>
                                        <div class="modal-status">
                                          {{ $order->payment_status }}
                                        </div>
                                        {{-- <button type="button" class="btn-close-modal" data-dismiss="modal" aria-hidden="true"><i class="fa-solid fa-x"></i></button> --}}
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-6">Order Number:</div>
                                            <div class="col-6 text-right">{{ $order->order_no }}</div>
                                            <div class="col-6">Rental Start Date:</div>
                                            <div class="col-6 text-right">{{ date('d M Y',strtotime($order->rental_start_date)) }}</div>
                                            <div class="col-6">Rental End Date:</div>
                                            <div class="col-6 text-right">{{ date('d M Y',strtotime($order->rental_end_date)) }}</div>
                                            <div class="col-12"><hr></div>
                                            <div class="col-12">
                                              <div class="modal-subtitle">
                                                Shipping
                                              </div> 
                                            </div>
                                            <div class="col-12"><div class="modal-list-title">Recipient:</div></div>
                                            <div class="col-12"><div class="modal-list">{{ $order->shipping->recipient }}</div></div>
                                            <div class="col-12"><div class="modal-list-title">Telephone:</div></div>
                                            <div class="col-12"><div class="modal-list"><i>{{ $order->shipping->telephone }}</i></div></div>
                                            <div class="col-12"><div class="modal-list-title">Address:</div></div>
                                            <div class="col-12"><div class="modal-list"><i>{{ $order->shipping->address }}, {{ $order->shipping->city }}, {{ $order->shipping->country }}, ({{ $order->shipping->postcode }})</i></div></div>
                                            <div class="col-12"><hr></div>
                                              <div class="modal-subtitle">
                                                Product
                                              </div> 
                                            @foreach ($order->products as $no=>$product)
                                              <div class="col-5">{{ ++$no.". ".$product->name }}</div>
                                              <div class="col-3 text-right">{{ $product->pivot->quantity." unit" }}</div>
                                              <div class="col-4 text-right">Rp {{ number_format($product->pivot->total_price, 0, ",", ".") }}</div>
                                            @endforeach
                                            <div class="col-12"><hr></div>
                                            <div class="col-6">Total Price</div>
                                            <div class="col-6 text-right">Rp {{ number_format($order->total, 0, ",", ".") }}</div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!-- end cart -->
            </div>
          </div>

          
        </div>
      </div>
      <!-- end content tabs -->
    </div>
  </div>
</div>

@endsection