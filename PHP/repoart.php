<?php
require('fpdf.php');
// class PDF extends FPDF {
//   // Footer method to add footer details
//   function Footer() {
//       // Set position at 15 mm from bottom
//       $this->SetY(-15);
      
//       // Set font for footer
//       $this->SetFont('Arial', 'c', 8);
      
//       // Add gym details in the footer
//       $this->Cell(0, 10, 'Fitness Zone Gym | Address: 123 Gym Street, City, Country | Phone: +123 456 7890 | Email: info@fitnesszone.com', 0, 0, 'C');
//   }
// }

date_default_timezone_set('Asia/Colombo'); // Set your timezone here, e.g., 'America/New_York'

include 'phpcon.php';

session_start();
$current_time = date("Y-m-d H:i:s");
if(!isset($_SESSION['admin_Id'])) {
   header('Location: index.php');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $report_type = $_POST['report_type'];
    $include_charts = isset($_POST['include_charts']) ? true : false;


    $stmt = $conn->prepare("SELECT u.user_id, u.user_name, u.email, u.gender, 
                            m.membership_id, m.start_date, m.end_date, m.cost, m.membership_type
                            FROM users u
                            JOIN membership_user m ON u.user_id = m.user_id
                            WHERE m.start_date >= ? AND m.end_date <= ?");
    $stmt->bind_param("ss", $start_date, $end_date);  // Bind the start and end dates
    $stmt->execute();
    $result = $stmt->get_result();

    // Create a new PDF instance
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);
    // Include company letterhead (make sure to provide the correct path to the image)
$pdf->Image('C:\wamp64\www\sahan\admin-main\IMG\logo.png', 10, 6, 30);  // Adjust the path and dimensions

// Move to the right to align the header properly
$pdf->Cell(80);

// Add current date and time

$pdf->Cell(0, 10, "Generated on: " . $current_time , 0, 1, 'R');  // Align to right
$pdf->Ln(20);

// Add search time period (adjust $search_start and $search_end with your dynamic values)
$search_start = "2024-10-01";  // Example start date
$search_end = "2024-10-10";    // Example end date
$pdf->Cell(0, 10, "Search Period: " . $search_start . " to " . $search_end, 0, 1, 'L');
$pdf->Ln(10);

    
    // Add header
    $pdf->Cell(0, 10, "Full Revenue Report", 0, 1, 'C');
    $pdf->Ln();
    
    // Add column headers
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(30, 10, 'User ID', 1);
    $pdf->Cell(40, 10, 'User Name', 1);
    $pdf->Cell(60, 10, 'Email', 1);
    $pdf->Cell(20, 10, 'Gender', 1);
    $pdf->Cell(35, 10, 'Membership Plan', 1);
    $pdf->Cell(25, 10, 'Cost', 1);
   
    $pdf->Ln();

    // Store data for charts
    $data_for_charts = [];

    // Populate table with data
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(30, 10, $row['user_id'], 1);
            $pdf->Cell(40, 10, $row['user_name'], 1);
            $pdf->Cell(60, 10, $row['email'], 1);
            $pdf->Cell(20, 10, $row['gender'], 1);
            $pdf->Cell(35, 10, $row['membership_id'], 1);
            $pdf->Cell(25, 10, $row['cost'], 1);
            $pdf->Ln();

            // Collect data for chart
            $data_for_charts[] = $row;
        }
    } else {
        $pdf->Cell(0, 10, "No records found for the given date range.", 0, 1);
    }

    // Optionally generate and include charts
    if ($include_charts) {
        generate_charts($data_for_charts);  // Function to generate chart
        $pdf->Image('chart.png', 10, $pdf->GetY(), 190); // Add chart image to PDF
    }
    $report_file_name = "report_" . time() . ".pdf";
    $pdf->Output('F', 'reports/' . $report_file_name);  // Save the PDF file to the reports folder

// Optionally, store the filename in the session or database for retrieval later
   $_SESSION['last_generated_report'] = $report_file_name;

   $report_name = $report_file_name;
   $query = "INSERT INTO generated_reports (report_name) VALUES ('$report_name')";
   mysqli_query($conn, $query);


    // Output the PDF
    $pdf->Output();

    $conn->close();
}

function generate_charts($data) {
    // Create chart image (you can use Google Charts or Chart.js instead for web rendering)
    $image = imagecreatetruecolor(400, 300);
    $background_color = imagecolorallocate($image, 255, 255, 255);
    imagefill($image, 0, 0, $background_color);

    // Example bar chart data (this can be customized)
    $bar_color = imagecolorallocate($image, 0, 102, 204);
    $x = 50;
    foreach ($data as $entry) {
        $bar_height = $entry['cost'] / 1000;  // Example scaling factor for bars
        imagefilledrectangle($image, $x, 300 - $bar_height, $x + 30, 300, $bar_color);
        $x += 50;
    }

    // Save chart image as PNG
    imagepng($image, "chart.png");
    imagedestroy($image);  // Free memory
}

    // Use the report type and date range to generate the report
    // switch ($report_type) {
    //     case 'full_revenue':
    //         // Generate Full Revenue Report
    //         echo "<script>alert('Generating Full Revenue Report from $start_date to $end_date');</script>";
    //         break;
    //     case 'week_revenue':
    //       echo "<script>alert('Generating week Revenue Report from $start_date to $end_date');</script>";
    //         break;
    //     case 'month_revenue':
    //       echo "<script>alert('Generating Month Revenue Report from $start_date to $end_date');</script>";
    //         break;
    //     case 'year_revenue':
    //       echo "<script>alert('Generating year Revenue Report from $start_date to $end_date');</script>";
    //         break;
    //     case 'instructor':
    //       echo "<script>alert('Generating Insreutor Revenue Report from $start_date to $end_date');</script>";
    //         break;
    //     default:
    //         echo "Invalid report type!";
    //         break;
    // }

    // Optionally include charts if requested
    // if ($include_charts) {
    //     // Code to generate charts (e.g., using Google Charts or Chart.js)
    // }

    // Output the generated report (e.g., display it or download as PDF)

?>








<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Report Generator</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  
</head>
<body>
  <div class="container mt-5">
    <!-- Title -->
    <h1 class="text-center">Report Generator</h1>
    <button class="btn btn-secondary mb-3" onclick="window.history.back();">Back</button>
    <!-- Form Section -->
    <div class="card mt-4">
      <div class="card-body">
      <form action="repoart.php" method="POST">
  <div class="row mb-3">
    <!-- Date Range Input -->
    <div class="col-md-6">
      <label for="startDate" class="form-label">Start Date</label>
      <input type="date" class="form-control" id="startDate" name="start_date" required>
    </div>
    <div class="col-md-6">
      <label for="endDate" class="form-label">End Date</label>
      <input type="date" class="form-control" id="endDate" name="end_date" required>
    </div>
  </div>

  <div class="row mb-3">
    <!-- Report Type Dropdown -->
    <div class="col-md-6">
      <label for="reportType" class="form-label">Report Type</label>
      <select class="form-select" id="reportType" name="report_type" required>
        <option value="full_revenue">Full Revenue Report</option>
        <option value="week_revenue">Week Revenue Report</option>
        <option value="month_revenue">Month Revenue Report</option>
        <option value="year_revenue">Year Revenue Report</option>
        <option value="instructor">Instructor Report</option>
      </select>
    </div>

    <div class="col-md-6">
      <!-- Checkbox for Including Charts -->
      <div class="form-check mt-4">
        <input class="form-check-input" type="checkbox" id="includeCharts" name="include_charts">
        <label class="form-check-label" for="includeCharts">
          Include Charts
        </label>
      </div>
    </div>
  </div>

  <!-- Generate Button -->
  <div class="text-center">
    <button type="submit" class="btn btn-primary">Generate Report</button>
  </div>
</form>

      </div>
    </div>

  <!-- Generated Report Section -->
<div class="card mt-4">
  <div class="card-body">
    <h5 class="card-title">Generated Reports</h5>
    <?php 
    // Fetch all generated reports from the database
    $query = "SELECT report_name, generated_at FROM generated_reports ORDER BY generated_at DESC";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) { 
    ?>
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Report Name</th>
              <th scope="col">Generated At</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php 
          $index = 1;
          while ($row = mysqli_fetch_assoc($result)) {
              $report_name = $row['report_name'];
              $generated_at = date("d/m/Y H:i", strtotime($row['generated_at']));
          ?>
            <tr>
              <th scope="row"><?= $index++ ?></th>
              <td><?= $report_name ?></td>
              <td><?= $generated_at ?></td>
              <td>
                <!-- View Button -->
                <a href="reports/<?= $report_name ?>" class="btn btn-primary btn-sm" target="_blank">View</a>
                <!-- Download Button -->
                <a href="reports/<?= $report_name ?>" download class="btn btn-secondary btn-sm">Download</a>
                <!-- Delete Button -->
                <form action="delete_report.php" method="POST" style="display:inline-block;">
                  <input type="hidden" name="report_name" value="<?= $report_name ?>">
                  <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this report?');">Delete</button>
                </form>
              </td>
            </tr>
          <?php 
          } 
          ?>
          </tbody>
        </table>
    <?php 
    } else { 
    ?>
        <p>No reports generated yet.</p>
    <?php 
    } 
    ?>
  </div>
</div>




  </div>

  <!-- Bootstrap JS (optional) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
