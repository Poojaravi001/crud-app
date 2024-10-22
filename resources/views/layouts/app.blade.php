<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laravel CRUD with Sidebar</title>
  
  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  
  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  
  <style>
    /* Sidebar Styling */
    .sidebar {
      width: 250px;
      height: 100vh;
      background-color: #343a40;
      position: fixed;
      top: 0;
      left: 0;
      padding: 20px;
    }

    .sidebar a {
      color: #adb5bd;
      text-decoration: none;
      display: block;
      margin: 15px 0;
      font-size: 18px;
    }

    .sidebar a:hover {
      color: #fff;
    }

    /* Content section to avoid overlap with the sidebar */
    .content {
      margin-left: 250px;
      padding: 20px;
    }

    .navbar {
      margin-left: 250px;
    }
  </style>
</head>

<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <h4 class="text-white">Menu</h4>
    <a href="#"><i class="bi bi-bag"></i> Purchase</a>
    <a href="#"><i class="bi bi-cart"></i> Sales</a>
    <a href="#"><i class="bi bi-box-seam"></i> Stock Details</a>
    <a href="#"><i class="bi bi-clipboard-data"></i> Report</a>
  </div>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg bg-black">
    <div class="container-fluid">
      <a class="navbar-brand text-white" href="/">Laravel CRUD</a>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="content">
    <div class="container mt-5">
      <div class="row">
        @if($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show">
          <strong>Success!</strong> {{ $message }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @yield('main')
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>
