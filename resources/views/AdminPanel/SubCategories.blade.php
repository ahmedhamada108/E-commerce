<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NobleUI Responsive Bootstrap 4 Dashboard Template</title>
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
    <link rel="shortcut icon" href="../../../assets/images/favicon.png" />
</head>
<body class="sidebar-dark">
<div class="main-wrapper">
    <!-- partial:partials/_sidebar.html -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <a href="#" class="sidebar-brand">
                Noble<span>UI</span>
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
                    <a class="nav-link" data-toggle="collapse" href="#uiComponents" role="button" aria-expanded="false" aria-controls="uiComponents">
                        <i class="link-icon" data-feather="feather"></i>
                        <span class="link-title">UI Kit</span>
                        <i class="link-arrow" data-feather="chevron-down"></i>
                    </a>
                    <div class="collapse" id="uiComponents">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="pages/ui-components/alerts.html" class="nav-link">Alerts</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/ui-components/badges.html" class="nav-link">Badges</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/ui-components/breadcrumbs.html" class="nav-link">Breadcrumbs</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/ui-components/buttons.html" class="nav-link">Buttons</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/ui-components/button-group.html" class="nav-link">Button group</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/ui-components/cards.html" class="nav-link">Cards</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/ui-components/carousel.html" class="nav-link">Carousel</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/ui-components/collapse.html" class="nav-link">Collapse</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/ui-components/dropdowns.html" class="nav-link">Dropdowns</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/ui-components/list-group.html" class="nav-link">List group</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/ui-components/media-object.html" class="nav-link">Media object</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/ui-components/modal.html" class="nav-link">Modal</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/ui-components/navs.html" class="nav-link">Navs</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/ui-components/navbar.html" class="nav-link">Navbar</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/ui-components/pagination.html" class="nav-link">Pagination</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/ui-components/popover.html" class="nav-link">Popovers</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/ui-components/progress.html" class="nav-link">Progress</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/ui-components/scrollbar.html" class="nav-link">Scrollbar</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/ui-components/scrollspy.html" class="nav-link">Scrollspy</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/ui-components/spinners.html" class="nav-link">Spinners</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/ui-components/tooltips.html" class="nav-link">Tooltips</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#advancedUI" role="button" aria-expanded="false" aria-controls="advancedUI">
                        <i class="link-icon" data-feather="anchor"></i>
                        <span class="link-title">Advanced UI</span>
                        <i class="link-arrow" data-feather="chevron-down"></i>
                    </a>
                    <div class="collapse" id="advancedUI">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="pages/advanced-ui/cropper.html" class="nav-link">Cropper</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/advanced-ui/owl-carousel.html" class="nav-link">Owl carousel</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/advanced-ui/sweet-alert.html" class="nav-link">Sweet Alert</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#forms" role="button" aria-expanded="false" aria-controls="forms">
                        <i class="link-icon" data-feather="inbox"></i>
                        <span class="link-title">Forms</span>
                        <i class="link-arrow" data-feather="chevron-down"></i>
                    </a>
                    <div class="collapse" id="forms">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="pages/forms/basic-elements.html" class="nav-link">Basic Elements</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/forms/advanced-elements.html" class="nav-link">Advanced Elements</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/forms/editors.html" class="nav-link">Editors</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/forms/wizard.html" class="nav-link">Wizard</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link"  data-toggle="collapse" href="#charts" role="button" aria-expanded="false" aria-controls="charts">
                        <i class="link-icon" data-feather="pie-chart"></i>
                        <span class="link-title">Charts</span>
                        <i class="link-arrow" data-feather="chevron-down"></i>
                    </a>
                    <div class="collapse" id="charts">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="pages/charts/apex.html" class="nav-link">Apex</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/charts/chartjs.html" class="nav-link">ChartJs</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/charts/flot.html" class="nav-link">Flot</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/charts/morrisjs.html" class="nav-link">Morris</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/charts/peity.html" class="nav-link">Peity</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/charts/sparkline.html" class="nav-link">Sparkline</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#tables" role="button" aria-expanded="false" aria-controls="tables">
                        <i class="link-icon" data-feather="layout"></i>
                        <span class="link-title">Table</span>
                        <i class="link-arrow" data-feather="chevron-down"></i>
                    </a>
                    <div class="collapse" id="tables">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="pages/tables/basic-table.html" class="nav-link">Basic Tables</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/tables/data-table.html" class="nav-link">Data Table</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#icons" role="button" aria-expanded="false" aria-controls="icons">
                        <i class="link-icon" data-feather="smile"></i>
                        <span class="link-title">Icons</span>
                        <i class="link-arrow" data-feather="chevron-down"></i>
                    </a>
                    <div class="collapse" id="icons">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="pages/icons/feather-icons.html" class="nav-link">Feather Icons</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/icons/flag-icons.html" class="nav-link">Flag Icons</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/icons/mdi-icons.html" class="nav-link">Mdi Icons</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item nav-category">Pages</li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#general-pages" role="button" aria-expanded="false" aria-controls="general-pages">
                        <i class="link-icon" data-feather="book"></i>
                        <span class="link-title">Special pages</span>
                        <i class="link-arrow" data-feather="chevron-down"></i>
                    </a>
                    <div class="collapse" id="general-pages">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="pages/general/blank-page.html" class="nav-link">Blank page</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/general/faq.html" class="nav-link">Faq</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/general/invoice.html" class="nav-link">Invoice</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/general/profile.html" class="nav-link">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/general/pricing.html" class="nav-link">Pricing</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/general/timeline.html" class="nav-link">Timeline</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#authPages" role="button" aria-expanded="false" aria-controls="authPages">
                        <i class="link-icon" data-feather="unlock"></i>
                        <span class="link-title">Authentication</span>
                        <i class="link-arrow" data-feather="chevron-down"></i>
                    </a>
                    <div class="collapse" id="authPages">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="pages/auth/login.html" class="nav-link">Login</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/auth/register.html" class="nav-link">Register</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#errorPages" role="button" aria-expanded="false" aria-controls="errorPages">
                        <i class="link-icon" data-feather="cloud-off"></i>
                        <span class="link-title">Error</span>
                        <i class="link-arrow" data-feather="chevron-down"></i>
                    </a>
                    <div class="collapse" id="errorPages">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="pages/error/404.html" class="nav-link">404</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/error/500.html" class="nav-link">500</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item nav-category">Docs</li>
                <li class="nav-item">
                    <a href="https://www.nobleui.com/html/documentation/docs.html" target="_blank" class="nav-link">
                        <i class="link-icon" data-feather="hash"></i>
                        <span class="link-title">Documentation</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- partial -->
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
                                    <p class="name font-weight-bold mb-0">Amiah Burton</p>
                                    <p class="email text-muted mb-3">amiahburton@gmail.com</p>
                                </div>
                            </div>
                            <div class="dropdown-body">
                                <ul class="profile-nav p-0 pt-3">
                                    <li class="nav-item">
                                        <a href="pages/general/profile.html" class="nav-link">
                                            <i data-feather="user"></i>
                                            <span>Profile</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="javascript:;" class="nav-link">
                                            <i data-feather="edit"></i>
                                            <span>Edit Profile</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="javascript:;" class="nav-link">
                                            <i data-feather="repeat"></i>
                                            <span>Switch User</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="javascript:;" class="nav-link">
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
        </nav>
        <!-- partial -->
        <div class="page-content">
            <div class="row">
                @if (session()->has('success'))
                    <div class="alert alert-success" style="width: 100% !important;text-align: center;" role="alert">{{session()->get('success') }}</div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger" style="width: 100% !important;text-align: center;" role="alert">{{session()->get('error') }}</div>
                @endif
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Sub Category</h6>
                            <div class="table-responsive">
                                <button type="button" style="float: right;" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                    Add
                                </button><br><br>
            {{--  start add modal--}}
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Add new Category</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="{{route('add.subncategory')}}">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="col-form-label">Sub-Category Name:</label>
                                                        <input type="text" name="subcategory" class="form-control" id="recipient-name">
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="btn-group">
                                                            <div class="form-group">
                                                                <label>The Main Category</label>
                                                                <select name="main_category" class="js-example-basic-single w-100">
                                                                    @foreach($All_Categories as $category)
                                                                    <option value="{{$category->id}}">{{$category->category}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Add</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
{{--               End add modal--}}
{{--            Start the table --}}
                                <table id="dataTableExample" class="table">
                                    <thead>
                                    <tr>
                                        <th>Sub-Category Name</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($All_Sub_category as $SubCategories)
                                        <tr id="subcategory{{$SubCategories->id}}">
                                        <td>{{$SubCategories->sub_category_name}}</td>
                                        <td class="btn-group">
                                            <!-- Button trigger modal -->
                                            <a href="{{route('GetId',$SubCategories->id)}}" class="btn btn-primary" data-toggle="modal" data-target="#editsubcategory{{$SubCategories->id}}">
                                                Edit
                                            </a>
                                            <a href="{{route('delete.subcategory',$SubCategories->id)}}" class="btn btn-danger">Delete</a>
                                        </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                            {{--             start Edit modal--}}
                                @foreach($All_Sub_category as $SubCategories)
                                <div class="modal fade" id="editsubcategory{{$SubCategories->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit the sub-Category</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="post" action="{{route('update.subcategory',$SubCategories->id)}}">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label for="recipient-name" class="col-form-label">Sub-Category Name:</label>
                                                                    <input type="text" value="{{$SubCategories->sub_category_name}}" name="subcategory" class="form-control" id="recipient-name">
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="btn-group">
                                                                        <div class="form-group">
                                                                            <label>The Main Category</label>
                                                                            <select name="main_category" class="js-example-basic-single w-100">
                                                                                @foreach($All_Categories as $category)
                                                                                    <option value="{{$category->id}}" {{$category->id==$SubCategories->category_id ? 'selected' : ''}}>{{$category->category}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                @endforeach
{{--          End Edit modal--}}
{{--            End the table --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer d-flex flex-column flex-md-row align-items-center justify-content-between">
            <p class="text-muted text-center text-md-left">Copyright © 2020 <a href="https://www.nobleui.com" target="_blank">NobleUI</a>. All rights reserved</p>
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
