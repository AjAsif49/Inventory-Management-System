@extends('welcome')

@section('content')   
    <div class="container-fluid" id="container-wrapper">
        <div class="card-body">
            <div id="print">
                <h1>Product Barcodes</h1>
                <div class="row">
                    @forelse ($products as $product)
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <h2>{!! $product->product_name !!}</h2>
                                    {!! $product->barcode !!}
                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
