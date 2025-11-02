<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>

<body>

    <div class="p-2 bg-dark text-center text-white d-flex justify-content-between">
        <h3>Laravel</h2>
            @auth
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        {{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile.show') }}">Profile</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a class="btn btn-outline-primary" href="{{ route('login') }}">Login</a>
                <a class="btn btn-primary" href="{{ route('register') }}">Register</a>
            @endauth
    </div>
    <div class="container">

        <div class="row">
            <div class="d-flex p-0 my-2 justify-content-end">
                <a class="bg-dark text-white p-2 text-decoration-none" href="{{ route('products.create') }}">Create</a>
            </div>
            <div>
                @if (Session::has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('success') }}
                    </div>
                @endif

                @if (Session::has('error'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('error') }}
                    </div>
                @endif
            </div>
            <div class="card p-0">
                <div class="card-header bg-dark text-white">
                    <h4>Products</h4>
                </div>
                <div class="card-body">
                    <table class="table table-stripped">
                        <thead>
                            <th>Id</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>SKU</th>
                            <th>Price</th>

                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @if ($products->isNotEmpty())
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td><img class="rounded"
                                                src="{{ asset('uploads/products/' . $product->image) }}" width="100">
                                        </td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->sku }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>
                                            @if ($product->status == 'Active')
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">InActive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('products.edit', $product->id) }}"
                                                class="btn btn-dark btn-sm">Edit</a>
                                            <form method="POST"
                                                action="{{ route('products.destroy', $product->id) }}">

                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm">Delete</button>
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <td colspan="7" class="text-center">No Product Found</td>
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
