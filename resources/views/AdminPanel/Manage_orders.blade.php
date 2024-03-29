<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Manage orders | Evara-Shop</title>
    <!-- core:css -->
    <link rel="stylesheet" href="../../../assets/vendors/core/core.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="../../../assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <!-- end plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../../../assets/fonts/feather-font/css/iconfont.css">
    <link rel="stylesheet" href="../../../assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="../../../assets/css/demo_1/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/images1/icon.png">
</head>
<body class="sidebar-dark">
<div class="main-wrapper">
    <!-- partial:partials/_sidebar.html -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <a href="#" class="sidebar-brand">
                Evara<span>Shop</span>
            </a>
            <div class="sidebar-toggler not-active">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <div class="sidebar-body">
            <ul class="nav">
                <li class="nav-item nav-category">Main</li>
                <li class="nav-item">
                    <a href="{{route('dashboard')}}" class="nav-link">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item nav-category">Manage The Products</li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#emails" role="button" aria-expanded="false" aria-controls="emails">
                        <i class="link-icon" data-feather="folder"></i>
                        <span class="link-title">The Categories</span>
                        <i class="link-arrow" data-feather="chevron-down"></i>
                    </a>
                    <div class="collapse" id="emails">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="{{route('MainCategory')}}" class="nav-link">The Main Categories</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('SubCategory')}}" class="nav-link">The Sub-Categories</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="{{route('ManageProducts')}}" class="nav-link">
                        <i class="link-icon" data-feather="shopping-cart"></i>
                        <span class="link-title">Manage The Products</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('manage.orders')}}" class="nav-link">
                        <i class="link-icon" data-feather="shopping-cart"></i>
                        <span class="link-title">Manage Orders</span>
                    </a>
                </li>
                <li class="nav-item nav-category">Manage the website</li>
                <li class="nav-item">
                    <a href="{{route('manage.mails')}}" class="nav-link">
                        <i class="link-icon" data-feather="mail"></i>
                        <span class="link-title">Manage Mails</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('settings.view')}}" class="nav-link">
                        <i class="link-icon" data-feather="settings"></i>
                        <span class="link-title">Manage Website Settings</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('manage.users')}}" class="nav-link">
                        <i class="link-icon" data-feather="settings"></i>
                        <span class="link-title">Manage users</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>    <!-- partial -->
    <div class="page-wrapper">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar">
            <a href="#" class="sidebar-toggler">
                <i data-feather="menu"></i>
            </a>
            <div class="navbar-content">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown nav-profile">
                        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="https://via.placeholder.com/30x30" alt="userr">
                        </a>
                        <div class="dropdown-menu" aria-labelledby="profileDropdown">
                            <div class="dropdown-header d-flex flex-column align-items-center">
                                <div class="figure mb-3">
                                    <img src="https://via.placeholder.com/80x80" alt="">
                                </div>
                                <div class="info text-center">
                                    <p class="name font-weight-bold mb-0">{{auth('web')->user()->name}}</p>
                                    <p class="email text-muted mb-3">{{auth('web')->user()->email}}</p>
                                </div>
                            </div>
                            <div class="dropdown-body">
                                <ul class="profile-nav p-0 pt-3">
                                    <li class="nav-item">
                                        <a href="{{url('admin/logout')}}" class="nav-link">
                                            <i data-feather="log-out"></i>
                                            <span>Log Out</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>        <!-- partial -->
        <div class="page-content">
            <div class="row">

                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Manage Orders</h6>
                            <div class="table-responsive">
{{--            Start the table --}}
                                <table id="dataTableExample" class="table">
                                    <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Username</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orders as $order)
                                    <tr id="category{{$order->id}}">
                                        <td> #{{$order->id}} </td>
                                        <td> {{$order->created_at->format('d.m.Y')}} </td>
                                        @if($order->status==0)
                                            <td> Pending</td>
                                        @elseif($order->status==1)
                                            <td> Accepted </td>
                                        @elseif($order->status==2)
                                            <td> Rejected</td>
                                        @elseif($order->status==3)
                                            <td> In Progress</td>
                                        @else
                                            <td> Delivered </td>
                                        @endif
                                        <td> {{$order->total_invoice}} </td>
                                        <td> {{$order->username}} </td>
                                        <td class="btn-group">
                                            <!-- Button trigger modal -->
                                            <a href="{{route('GetOrderId',$order->id)}}" class="btn btn-primary" data-toggle="modal" data-target="#editcategory{{$order->id}}">
                                                Edit
                                            </a>
                                            <a href="{{route('delete.order',$order->id)}}" class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                {{--   Start Edit modal--}}
                                            @foreach($orders as $order)
                                            <div class="modal fade" id="editcategory{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit Invoice</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="post" action="{{route('update.order',$order->id)}}" >
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label for="recipient-name" class="col-form-label">Order ID:</label>
                                                                    <input type="text" name="order_id" readonly class="form-control" id="recipient-name" value="{{$order->id}}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="recipient-name" class="col-form-label">Order date:</label>
                                                                    <input type="text" name="order_date" readonly class="form-control" id="recipient-name" value="{{$order->created_at->format('d.m.Y')}}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="recipient-name" class="col-form-label">Order Status:</label>
                                                                    <select name="order_status" class="js-example-basic-single w-100">
                                                                        <option value="0" {{0 ==$order->status ? 'selected' : ''}}>Pending</option>
                                                                        <option value="1"{{1 ==$order->status ? 'selected' : ''}}>Accepted</option>
                                                                        <option value="2" {{2 ==$order->status ? 'selected' : ''}}>Rejected</option>
                                                                        <option value="3" {{3 ==$order->status ? 'selected' : ''}}>In Progress</option>
                                                                        <option value="4" {{4 ==$order->status ? 'selected' : ''}}>Delivered</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="recipient-name" class="col-form-label">Total Invoice:</label>
                                                                    <input type="number" name="order_total"  class="form-control" id="recipient-name" value="{{$order->total_invoice}}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="recipient-name" class="col-form-label">Items:</label>
                                                                    <input type="number" name="order_items"  class="form-control" id="recipient-name" value="{{$order->items}}">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                @endforeach
{{--                End the Edit modal --}}

{{--            End the table --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer d-flex flex-column flex-md-row align-items-center justify-content-between">
            <p class="text-muted text-center text-md-left">Copyright © 2022 <a href="{{url('/')}}" target="_blank">Evara-Shop</a>. All rights reserved</p>
            <p class="text-muted text-center text-md-left mb-0 d-none d-md-block">Handcrafted With <i class="mb-1 text-primary ml-1 icon-small" data-feather="heart"></i></p>
        </footer>
        <!-- partial -->

    </div>
</div>

<!-- core:js -->
<script src="../../../assets/vendors/core/core.js"></script>
<!-- endinject -->
<!-- plugin js for this page -->
<script src="../../../assets/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="../../../assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
<!-- end plugin js for this page -->
<!-- inject:js -->
<script src="../../../assets/vendors/feather-icons/feather.min.js"></script>
<script src="../../../assets/js/template.js"></script>
<!-- endinject -->
<!-- custom js for this page -->
<script src="../../../assets/js/data-table.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<!-- end custom js for this page -->
</body>
</html>
