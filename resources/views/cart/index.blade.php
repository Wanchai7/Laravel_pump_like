<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('layouts.navigation')
    <div class="container mt-5">
        <h1>Shopping Cart</h1>

        @if(empty($cart))
            <div class="alert alert-info">
                Your cart is empty.
            </div>
            <a href="/products" class="btn btn-primary">Continue Shopping</a>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($cart as $id => $details)
                        @php $total += $details['price'] * $details['quantity']; @endphp
                        <tr>
                            <td data-th="Product">{{ $details['name'] }}</td>
                            <td data-th="Price">${{ number_format($details['price'], 2) }}</td>
                            <td data-th="Quantity">
                                <form action="/cart/update" method="POST" class="d-flex">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <input type="number" name="quantity" value="{{ $details['quantity'] }}" class="form-control form-control-sm" style="width: 70px;"/>
                                    <button type="submit" class="btn btn-secondary btn-sm ms-2">Update</button>
                                </form>
                            </td>
                            <td data-th="Subtotal" class="text-center">${{ number_format($details['price'] * $details['quantity'], 2) }}</td>
                            <td class="actions" data-th="">
                                <form action="/cart/remove" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-end">
                <h3>Total: ${{ number_format($total, 2) }}</h3>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="/products" class="btn btn-secondary">Continue Shopping</a>
                <div>
                    <a href="/cart/clear" class="btn btn-danger">Clear Cart</a>
                    <a href="#" class="btn btn-success">Proceed to Checkout</a>
                </div>
            </div>
        @endif
    </div>
</body>
</html>
