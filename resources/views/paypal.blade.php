<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel PayPal Payment Gateway Integration Example - ItSolutionStuff.com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row mt-5 mb-5">
            <div class="col-10 offset-1 mt-5">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="text-white">Tạp hóa
                        </h3>
                    </div>
                    <div class="card-body">

                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ $message }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($message = Session::get('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>{{ $message }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="d-flex">
                            <div class="card m-1" style="width: 18rem;">
                                <div class="h-75">
                                    <img src="https://cdn.tgdd.vn/Files/2022/07/07/1445532/laptop-like-new-99-la-gi-co-tot-khong-co-nen-1.jpg" class="card-img-top" alt="...">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Laptop</h5>
                                    <h4 class="card-title">$1000.00 USD</h4>
                                    <p class="card-text">Some quick example text to build on the card title and make up
                                        the
                                        bulk of the card's content.</p>
                                    <a href="{{ route('paypal.payment', ['id' => 1, 'user_id' => $user->id]) }}" class="btn btn-primary">Buy now</a>
                                </div>
                            </div>

                            <div class="card m-1" style="width: 18rem;">
                                <div class="h-75">
                                    <img src="https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:80/plain/https://cellphones.com.vn/media/catalog/product/1/_/1_253_7.jpg" class="card-img-top" alt="...">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">iPad</h5>
                                    <h4 class="card-title">$500.00 USD</h4>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                    <a href="{{ route('paypal.payment', ['id' => 2, 'user_id' => $user->id]) }}" class="btn btn-primary">Buy now</a>
                                </div>
                            </div>

                            <div class="card m-1" style="width: 18rem;">
                                <div class="h-75">
                                    <img src="https://chosathaiphong.com/wp-content/uploads/2018/04/dep-tong-lao-1.jpg" class="card-img-top" alt="...">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Dep Lao's</h5>
                                    <h4 class="card-title">$100.00 USD</h4>
                                    <p class="card-text">Some quick example text to build on the card title and make up
                                        the
                                        bulk of the card's content.</p>
                                    <a href="{{ route('paypal.payment', ['id' => 3, 'user_id' => $user->id]) }}" class="btn btn-primary">Buy now</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <br>
                <a class="btn btn-primary" href="{{ route('export') }}">Export list</a>
                <h5 class="mt-5">List orders</h5>
                @foreach($orders as $order)
                    <h6 onclick="updateDetail({{$order->id}})">{{$order->id_order}} - {{$order->status}}</h6>
                @endforeach

                <div id="detail" style="background-color: aquamarine"></div>
            </div>
        </div>
    </div>
</body>
<script>
    const updateDetail = (id) => {
        const data = {!!$orders!!}
        const order = JSON.parse(data.filter((i)=>i.id===id)[0].data)
        let divDetail = document.getElementById('detail').innerHTML = `
        <h6>ID: ${order.id}</h6>
        <h6>Intent: ${order.intent}</h6>
        <h6>Status: ${order.status}</h6>
        <h6>Items: ${JSON.stringify(order.purchase_units[0].items,null, 2)}</h6>
        ` ;
    }
</script>
</html>
