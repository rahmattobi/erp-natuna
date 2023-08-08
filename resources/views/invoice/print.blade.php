<!DOCTYPE html>
<html>
<head>
  <title>Invoice</title>
  <!-- Load Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Optional: Load jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
</head>
<body>
  <div class="container">
    <!-- Header -->
    <div class="row">
      <div class="col-md-6">
        <img src="{{ public_path('adminAssets/img/logo.jpg') }}" alt="Logo" width="100">
      </div>
      <div class="col-md-6 text-end">
        <p>Company Address</p>
        <p>City, Country</p>
        <!-- Add more company address details here -->
      </div>
    </div>
    <!-- Invoice details -->
    <div class="row mt-4">
      <div class="col-md-12">
        <h2>Invoice</h2>
        <!-- Add more invoice details here (e.g., invoice number, date, etc.) -->
      </div>
    </div>
    <!-- Invoice items table -->
    <div class="row mt-4">
      <div class="col-md-12">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Item</th>
              <th>Description</th>
              <th>Quantity</th>
              <th>Price</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <!-- Add invoice items and calculate total price -->
            <tr>
              <td>Item 1</td>
              <td>Description 1</td>
              <td>2</td>
              <td>10.00</td>
              <td>20.00</td>
            </tr>
            <!-- Add more items here -->
          </tbody>
        </table>
      </div>
    </div>
    <!-- Invoice total -->
    <div class="row mt-4">
      <div class="col-md-12">
        <p class="text-end">Total: $100.00</p>
      </div>
    </div>
  </div>

  <script>
    // Optional: Add your JavaScript logic here if needed.
  </script>
</body>
</html>
