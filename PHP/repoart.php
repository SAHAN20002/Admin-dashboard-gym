<?php
require('fpdf.php');

date_default_timezone_set('Asia/Colombo'); // Set your timezone here, e.g., 'America/New_York'

include 'phpcon.php';

session_start();
$current_time = date("Y-m-d H:i:s");
if(!isset($_SESSION['admin_Id'])) {
   header('Location: index.php');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
    $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';
    $include_charts = isset($_POST['include_charts']) ? true : false;
    $report_type = $_POST['report_type'];

    function generate_full_revenue_report($start_date, $end_date, $include_charts, $conn) {
      // SQL query
      $stmt = $conn->prepare("SELECT u.user_id, u.user_name, u.email, u.gender, 
                              m.membership_id, m.start_date, m.end_date, m.cost, m.membership_type
                              FROM users u
                              JOIN membership_user m ON u.user_id = m.user_id
                              WHERE m.start_date >= ? AND m.start_date <= ?");
      $stmt->bind_param("ss", $start_date, $end_date);  
      $stmt->execute();
      $result = $stmt->get_result();

      
      $pdf = new FPDF();
      $pdf->AddPage();
      $pdf->SetFont('Arial', 'B', 12);

      
      $pdf->Image('C:\wamp64\www\sahan\admin-main\IMG\logo.png', 10, 6, 30);

      
      $pdf->Cell(80);
      $pdf->Cell(0, 10, "Generated on: " . date("Y-m-d H:i:s"), 0, 1, 'R');
      $pdf->Ln(20);

      
      $pdf->Cell(0, 10, "Search Period: " . $start_date . " to " . $end_date, 0, 1, 'L');
      $pdf->Ln(10);

      
      $pdf->Cell(0, 10, "Full Revenue Report", 0, 1, 'C');
      $pdf->Ln();

      
      $pdf->SetFont('Arial', 'B', 10);
      $pdf->Cell(30, 10, 'User ID', 1);
      $pdf->Cell(40, 10, 'User Name', 1);
      $pdf->Cell(60, 10, 'Email', 1);
      $pdf->Cell(20, 10, 'Gender', 1);
      $pdf->Cell(35, 10, 'Membership Plan', 1);
      $pdf->Cell(25, 10, 'Cost', 1);
      $pdf->Ln();

      // Data for charts
      $data_for_charts = [];

      // Populate table with data
      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              $pdf->SetFont('Arial', '', 10);
              $pdf->Cell(30, 10, $row['user_id'], 1);
              $pdf->Cell(40, 10, $row['user_name'], 1);
              $pdf->Cell(60, 10, $row['email'], 1);
              $pdf->Cell(20, 10, $row['gender'], 1);
              $pdf->Cell(35, 10, $row['membership_id'], 1);
              $pdf->Cell(25, 10, $row['cost'], 1);
              $pdf->Ln();

              
              $data_for_charts[] = $row;
          }
      } else {
          $pdf->Cell(0, 10, "No records found for the given date range.", 0, 1);
      }

      
      if ($include_charts) {
          generate_charts($data_for_charts);  
          $pdf->Image('chart.png', 10, $pdf->GetY(), 190);
      }
      
    $pdf->Ln(20);  

    
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 10, "Note: This is an auto-generated report. For any inquiries, please contact our support team.", 0, 1, 'C');
    $pdf->Ln(5);
    $pdf->Cell(0, 10, "Email: Support.fitnesszone@gmail.com| Phone: +94-70-341-1511", 0, 1, 'C');
      
      $report_file_name = "Full_Revenue_Report_" . time() . ".pdf";
      $pdf->Output('F', 'reports/' . $report_file_name);

      
      $stmt = $conn->prepare("INSERT INTO generated_reports (report_name) VALUES (?)");
      $stmt->bind_param("s", $report_file_name);
      $stmt->execute();

      
      $_SESSION['last_generated_report'] = $report_file_name;

      
      $conn->close();

      
      $pdf->Output();
  }

  function generate_week_revenue_report($start_date, $end_date, $include_charts, $conn) {
    // SQL query
    $stmt = $conn->prepare("SELECT u.user_id, u.user_name, u.email, u.gender, 
                            m.membership_id, m.start_date, m.end_date, m.cost, m.membership_type
                            FROM users u
                            JOIN membership_user m ON u.user_id = m.user_id
                            WHERE m.start_date >= ? AND m.start_date <= ? AND m.membership_type = 'Week'");
    $stmt->bind_param("ss", $start_date, $end_date);  // Bind the start and end dates
    $stmt->execute();
    $result = $stmt->get_result();

    // PDF Generation
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);

    // Company letterhead
    $pdf->Image('C:\wamp64\www\sahan\admin-main\IMG\logo.png', 10, 6, 30);

    // Aligning header and adding date/time
    $pdf->Cell(80);
    $pdf->Cell(0, 10, "Generated on: " . date("Y-m-d H:i:s"), 0, 1, 'R');
    $pdf->Ln(20);

    // Dynamic search period
    $pdf->Cell(0, 10, "Search Period: " . $start_date . " to " . $end_date, 0, 1, 'L');
    $pdf->Ln(10);

    // Header
    $pdf->Cell(0, 10, "Week Revenue Report", 0, 1, 'C');
    $pdf->Ln();

    // Column Headers
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(30, 10, 'User ID', 1);
    $pdf->Cell(40, 10, 'User Name', 1);
    $pdf->Cell(60, 10, 'Email', 1);
    $pdf->Cell(20, 10, 'Gender', 1);
    $pdf->Cell(35, 10, 'Membership Plan', 1);
    $pdf->Cell(25, 10, 'Cost', 1);
    $pdf->Ln();

    // Data for charts
    $data_for_charts = [];

    // Populate table with data
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(30, 10, $row['user_id'], 1);
            $pdf->Cell(40, 10, $row['user_name'], 1);
            $pdf->Cell(60, 10, $row['email'], 1);
            $pdf->Cell(20, 10, $row['gender'], 1);
            $pdf->Cell(35, 10, $row['membership_id'], 1);
            $pdf->Cell(25, 10, $row['cost'], 1);
            $pdf->Ln();

            // Collect data for charts
            $data_for_charts[] = $row;
        }
    } else {
        $pdf->Cell(0, 10, "No records found for the given date range.", 0, 1);
    }

    // Include charts if requested
    if ($include_charts) {
        generate_charts($data_for_charts);  // Ensure you have a chart generation function
        $pdf->Image('chart.png', 10, $pdf->GetY(), 190);
    }
    // Move the cursor to the bottom for additional text
  $pdf->Ln(20);  // Add space after charts or table

  // Add text at the bottom of the PDF
  $pdf->SetFont('Arial', 'I', 10);
  $pdf->Cell(0, 10, "Note: This is an auto-generated report. For any inquiries, please contact our support team.", 0, 1, 'C');
  $pdf->Ln(5);
  $pdf->Cell(0, 10, "Email: Support.fitnesszone@gmail.com| Phone: +94-70-341-1511", 0, 1, 'C');
    // Save the PDF
    $report_file_name = "Week_M_Revenue_Report" . time() . ".pdf";
    $pdf->Output('F', 'reports/' . $report_file_name);

    // Save report name to the database using prepared statements
    $stmt = $conn->prepare("INSERT INTO generated_reports (report_name) VALUES (?)");
    $stmt->bind_param("s", $report_file_name);
    $stmt->execute();

    // Optionally, store the filename in the session
    $_SESSION['last_generated_report'] = $report_file_name;

    // Close connection
    $conn->close();

    // Output the PDF
    $pdf->Output();
}

function generate_month_revenue_report($start_date, $end_date, $include_charts, $conn) {
  // SQL query
  $stmt = $conn->prepare("SELECT u.user_id, u.user_name, u.email, u.gender, 
                          m.membership_id, m.start_date, m.end_date, m.cost, m.membership_type
                          FROM users u
                          JOIN membership_user m ON u.user_id = m.user_id
                          WHERE m.start_date >= ? AND m.start_date <= ? AND m.membership_type = 'Month'");
  $stmt->bind_param("ss", $start_date, $end_date);  // Bind the start and end dates
  $stmt->execute();
  $result = $stmt->get_result();

  // PDF Generation
  $pdf = new FPDF();
  $pdf->AddPage();
  $pdf->SetFont('Arial', 'B', 12);

  // Company letterhead
  $pdf->Image('C:\wamp64\www\sahan\admin-main\IMG\logo.png', 10, 6, 30);

  // Aligning header and adding date/time
  $pdf->Cell(80);
  $pdf->Cell(0, 10, "Generated on: " . date("Y-m-d H:i:s"), 0, 1, 'R');
  $pdf->Ln(20);

  // Dynamic search period
  $pdf->Cell(0, 10, "Search Period: " . $start_date . " to " . $end_date, 0, 1, 'L');
  $pdf->Ln(10);

  // Header
  $pdf->Cell(0, 10, "Month Mebership Plan Revenue Report", 0, 1, 'C');
  $pdf->Ln();

  // Column Headers
  $pdf->SetFont('Arial', 'B', 10);
  $pdf->Cell(30, 10, 'User ID', 1);
  $pdf->Cell(40, 10, 'User Name', 1);
  $pdf->Cell(60, 10, 'Email', 1);
  $pdf->Cell(20, 10, 'Gender', 1);
  $pdf->Cell(35, 10, 'Membership Plan', 1);
  $pdf->Cell(25, 10, 'Cost', 1);
  $pdf->Ln();

  // Data for charts
  $data_for_charts = [];

  // Populate table with data
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $pdf->SetFont('Arial', '', 10);
          $pdf->Cell(30, 10, $row['user_id'], 1);
          $pdf->Cell(40, 10, $row['user_name'], 1);
          $pdf->Cell(60, 10, $row['email'], 1);
          $pdf->Cell(20, 10, $row['gender'], 1);
          $pdf->Cell(35, 10, $row['membership_id'], 1);
          $pdf->Cell(25, 10, $row['cost'], 1);
          $pdf->Ln();

          // Collect data for charts
          $data_for_charts[] = $row;
      }
  } else {
      $pdf->Cell(0, 10, "No records found for the given date range.", 0, 1);
  }

  // Include charts if requested
  if ($include_charts) {
      generate_charts($data_for_charts);  // Ensure you have a chart generation function
      $pdf->Image('chart.png', 10, $pdf->GetY(), 190);
  }
  // Move the cursor to the bottom for additional text
$pdf->Ln(20);  // Add space after charts or table

// Add text at the bottom of the PDF
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 10, "Note: This is an auto-generated report. For any inquiries, please contact our support team.", 0, 1, 'C');
$pdf->Ln(5);
$pdf->Cell(0, 10, "Email: Support.fitnesszone@gmail.com| Phone: +94-70-341-1511", 0, 1, 'C');
  // Save the PDF
  $report_file_name = "Month_M_Revenue_Report" . time() . ".pdf";
  $pdf->Output('F', 'reports/' . $report_file_name);

  // Save report name to the database using prepared statements
  $stmt = $conn->prepare("INSERT INTO generated_reports (report_name) VALUES (?)");
  $stmt->bind_param("s", $report_file_name);
  $stmt->execute();

  // Optionally, store the filename in the session
  $_SESSION['last_generated_report'] = $report_file_name;

  // Close connection
  $conn->close();

  // Output the PDF
  $pdf->Output();
}

function generate_year_revenue_report($start_date, $end_date, $include_charts, $conn) {
  // SQL query
  $stmt = $conn->prepare("SELECT u.user_id, u.user_name, u.email, u.gender, 
                          m.membership_id, m.start_date, m.end_date, m.cost, m.membership_type
                          FROM users u
                          JOIN membership_user m ON u.user_id = m.user_id
                          WHERE m.start_date >= ? AND m.start_date <= ? AND m.membership_type = 'Year'");
  $stmt->bind_param("ss", $start_date, $end_date);  // Bind the start and end dates
  $stmt->execute();
  $result = $stmt->get_result();

  // PDF Generation
  $pdf = new FPDF();
  $pdf->AddPage();
  $pdf->SetFont('Arial', 'B', 12);

  // Company letterhead
  $pdf->Image('C:\wamp64\www\sahan\admin-main\IMG\logo.png', 10, 6, 30);

  // Aligning header and adding date/time
  $pdf->Cell(80);
  $pdf->Cell(0, 10, "Generated on: " . date("Y-m-d H:i:s"), 0, 1, 'R');
  $pdf->Ln(20);

  // Dynamic search period
  $pdf->Cell(0, 10, "Search Period: " . $start_date . " to " . $end_date, 0, 1, 'L');
  $pdf->Ln(10);

  // Header
  $pdf->Cell(0, 10, "Year Mebership Plan Revenue Report", 0, 1, 'C');
  $pdf->Ln();

  // Column Headers
  $pdf->SetFont('Arial', 'B', 10);
  $pdf->Cell(30, 10, 'User ID', 1);
  $pdf->Cell(40, 10, 'User Name', 1);
  $pdf->Cell(60, 10, 'Email', 1);
  $pdf->Cell(20, 10, 'Gender', 1);
  $pdf->Cell(35, 10, 'Membership Plan', 1);
  $pdf->Cell(25, 10, 'Cost', 1);
  $pdf->Ln();

  // Data for charts
  $data_for_charts = [];

  // Populate table with data
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $pdf->SetFont('Arial', '', 10);
          $pdf->Cell(30, 10, $row['user_id'], 1);
          $pdf->Cell(40, 10, $row['user_name'], 1);
          $pdf->Cell(60, 10, $row['email'], 1);
          $pdf->Cell(20, 10, $row['gender'], 1);
          $pdf->Cell(35, 10, $row['membership_id'], 1);
          $pdf->Cell(25, 10, $row['cost'], 1);
          $pdf->Ln();

          // Collect data for charts
          $data_for_charts[] = $row;
      }
  } else {
      $pdf->Cell(0, 10, "No records found for the given date range.", 0, 1);
  }

  // Include charts if requested
  if ($include_charts) {
      generate_charts($data_for_charts);  // Ensure you have a chart generation function
      $pdf->Image('chart.png', 10, $pdf->GetY(), 190);
  }
  // Move the cursor to the bottom for additional text
$pdf->Ln(20);  // Add space after charts or table

// Add text at the bottom of the PDF
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 10, "Note: This is an auto-generated report. For any inquiries, please contact our support team.", 0, 1, 'C');
$pdf->Ln(5);
$pdf->Cell(0, 10, "Email: Support.fitnesszone@gmail.com| Phone: +94-70-341-1511", 0, 1, 'C');
  // Save the PDF
  $report_file_name = "Year_M_Revenue_Report" . time() . ".pdf";
  $pdf->Output('F', 'reports/' . $report_file_name);

  // Save report name to the database using prepared statements
  $stmt = $conn->prepare("INSERT INTO generated_reports (report_name) VALUES (?)");
  $stmt->bind_param("s", $report_file_name);
  $stmt->execute();

  // Optionally, store the filename in the session
  $_SESSION['last_generated_report'] = $report_file_name;

  // Close connection
  $conn->close();

  // Output the PDF
  $pdf->Output();
}

function generate_instructor_report($start_date, $end_date, $include_charts, $conn) {
  // SQL query
  $stmt = $conn->prepare("SELECT u.user_id, u.user_name, u.email, u.gender, 
                          m.Id, m.s_date, m.e_date, m.cost, m.Instructor_Id
                          FROM users u
                          JOIN instructor_user m ON u.user_id = m.user_Id 
                          WHERE m.s_date >= ? AND m.s_date <= ?");
  $stmt->bind_param("ss", $start_date, $end_date);  // Bind the start and end dates
  $stmt->execute();
  $result = $stmt->get_result();

  // PDF Generation
  $pdf = new FPDF();
  $pdf->AddPage();
  $pdf->SetFont('Arial', 'B', 12);

  // Company letterhead
  $pdf->Image('C:\wamp64\www\sahan\admin-main\IMG\logo.png', 10, 6, 30);

  // Aligning header and adding date/time
  $pdf->Cell(80);
  $pdf->Cell(0, 10, "Generated on: " . date("Y-m-d H:i:s"), 0, 1, 'R');
  $pdf->Ln(20);

  // Dynamic search period
  $pdf->Cell(0, 10, "Search Period: " . $start_date . " to " . $end_date, 0, 1, 'L');
  $pdf->Ln(10);

  // Header
  $pdf->Cell(0, 10, "Instructor Plan Revenue Report", 0, 1, 'C');
  $pdf->Ln();

  // Column Headers
  $pdf->SetFont('Arial', 'B', 10);
  $pdf->Cell(30, 10, 'User ID', 1);
  $pdf->Cell(40, 10, 'User Name', 1);
  $pdf->Cell(60, 10, 'Email', 1);
  $pdf->Cell(20, 10, 'Gender', 1);
  $pdf->Cell(35, 10, 'Instructor', 1);
  $pdf->Cell(25, 10, 'Cost', 1);
  $pdf->Ln();

  // Data for charts
  $data_for_charts = [];

  // Populate table with data
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $pdf->SetFont('Arial', '', 10);
          $pdf->Cell(30, 10, $row['user_id'], 1);
          $pdf->Cell(40, 10, $row['user_name'], 1);
          $pdf->Cell(60, 10, $row['email'], 1);
          $pdf->Cell(20, 10, $row['gender'], 1);
          $pdf->Cell(35, 10, $row['Instructor_Id'], 1);
          $pdf->Cell(25, 10, $row['cost'], 1);
          $pdf->Ln();

          // Collect data for charts
          $data_for_charts[] = $row;
      }
  } else {
      $pdf->Cell(0, 10, "No records found for the given date range.", 0, 1);
  }

  // Include charts if requested
  if ($include_charts) {
      generate_charts($data_for_charts);  // Ensure you have a chart generation function
      $pdf->Image('chart.png', 10, $pdf->GetY(), 190);
  }
  // Move the cursor to the bottom for additional text
$pdf->Ln(20);  // Add space after charts or table

// Add text at the bottom of the PDF
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 10, "Note: This is an auto-generated report. For any inquiries, please contact our support team.", 0, 1, 'C');
$pdf->Ln(5);
$pdf->Cell(0, 10, "Email: Support.fitnesszone@gmail.com| Phone: +94-70-341-1511", 0, 1, 'C');
  // Save the PDF
  $report_file_name = "Instructor_P_Revenue_Report" . time() . ".pdf";
  $pdf->Output('F', 'reports/' . $report_file_name);

  // Save report name to the database using prepared statements
  $stmt = $conn->prepare("INSERT INTO generated_reports (report_name) VALUES (?)");
  $stmt->bind_param("s", $report_file_name);
  $stmt->execute();

  // Optionally, store the filename in the session
  $_SESSION['last_generated_report'] = $report_file_name;

  // Close connection
  $conn->close();

  // Output the PDF
  $pdf->Output();
}

function generate_user_report( $include_charts, $conn) {
  // SQL query
  $stmt = $conn->prepare("SELECT user_id, user_name, email, gender,NIC,membership_status,instructor_status,p_number,age,membership_plan,instructor FROM users");
  $stmt->execute();
  $result = $stmt->get_result();

  // PDF Generation
  $pdf = new FPDF();
  $pdf->AddPage('L');
  $pdf->SetFont('Arial', 'B', 12);

  // Company letterhead
  $pdf->Image('C:\wamp64\www\sahan\admin-main\IMG\logo.png', 10, 6, 30);

  // Aligning header and adding date/time
  $pdf->Cell(80);
  $pdf->Cell(0, 10, "Generated on: " . date("Y-m-d H:i:s"), 0, 1, 'R');
  $pdf->Ln(20);

  

  // Header
  $pdf->Cell(0, 10, "User Information Report", 0, 1, 'C');
  $pdf->Ln();

  // Column Headers
  $pdf->SetFont('Arial', 'B', 10);
  $pdf->Cell(30, 10, 'User ID', 1);
  $pdf->Cell(30, 10, 'User Name', 1);
  $pdf->Cell(60, 10, 'Email', 1);
  $pdf->Cell(15, 10, 'Gender', 1);
  $pdf->Cell(30, 10, 'Phone Number', 1);
  $pdf->Cell(10, 10, 'Age', 1);
  $pdf->Cell(20, 10, 'Membership', 1);
  $pdf->Cell(20, 10, 'Instructor', 1);
  $pdf->Cell(25, 10, 'NIC', 1);
  $pdf->Cell(30, 10, 'Membership Plan', 1);
  $pdf->Cell(30, 10, 'Instructor', 1);
  $pdf->Ln();

  // Data for charts
  $data_for_charts = [];

  // Populate table with data
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $pdf->SetFont('Arial', '', 10);
          $pdf->Cell(30, 10, $row['user_id'], 1);
          $pdf->Cell(30, 10, $row['user_name'], 1);
          $pdf->Cell(60, 10, $row['email'], 1);
          $pdf->Cell(15, 10, $row['gender'], 1);
          $pdf->Cell(30, 10, $row['p_number'], 1);
          $pdf->Cell(10, 10, $row['age'], 1);
          $pdf->Cell(20, 10, $row['membership_status'], 1);
          $pdf->Cell(20, 10, $row['instructor_status'], 1);
          $pdf->Cell(25, 10, $row['NIC'], 1);
          $pdf->Cell(30, 10, $row['membership_plan'], 1);
          $pdf->Cell(30, 10, $row['instructor'], 1);
          $pdf->Ln();

          // Collect data for charts
          $data_for_charts[] = $row;
      }
  } else {
      $pdf->Cell(0, 10, "No records found for the given date range.", 0, 1);
  }

  // Include charts if requested
  if ($include_charts) {
      generate_charts($data_for_charts);  // Ensure you have a chart generation function
      $pdf->Image('chart.png', 10, $pdf->GetY(), 190);
  }
  // Move the cursor to the bottom for additional text
$pdf->Ln(20);  // Add space after charts or table

// Add text at the bottom of the PDF
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 10, "Note: This is an auto-generated report. For any inquiries, please contact our support team.", 0, 1, 'C');
$pdf->Ln(5);
$pdf->Cell(0, 10, "Email: Support.fitnesszone@gmail.com| Phone: +94-70-341-1511", 0, 1, 'C');
  // Save the PDF
  $report_file_name = "User_Data_Report" . time() . ".pdf";
  $pdf->Output('F', 'reports/' . $report_file_name);

  // Save report name to the database using prepared statements
  $stmt = $conn->prepare("INSERT INTO generated_reports (report_name) VALUES (?)");
  $stmt->bind_param("s", $report_file_name);
  $stmt->execute();

  // Optionally, store the filename in the session
  $_SESSION['last_generated_report'] = $report_file_name;

  // Close connection
  $conn->close();

  // Output the PDF
  $pdf->Output();
}

function generate_online_clz_report( $include_charts, $conn) {
  // SQL query
  $stmt = $conn->prepare("SELECT Id, Topic, Instructor_name, Time,date,Link FROM zoom_clz");
  $stmt->execute();
  $result = $stmt->get_result();

  // PDF Generation
  $pdf = new FPDF();
  $pdf->AddPage('L');
  $pdf->SetFont('Arial', 'B', 12);

  // Company letterhead
  $pdf->Image('C:\wamp64\www\sahan\admin-main\IMG\logo.png', 10, 6, 30);

  // Aligning header and adding date/time
  $pdf->Cell(80);
  $pdf->Cell(0, 10, "Generated on: " . date("Y-m-d H:i:s"), 0, 1, 'R');
  $pdf->Ln(20);

  

  // Header
  $pdf->Cell(0, 10, "Online Class Information Report", 0, 1, 'C');
  $pdf->Ln();

  // Column Headers
  $pdf->SetFont('Arial', 'B', 10);
  $pdf->Cell(20, 10, 'Class ID', 1);
  $pdf->Cell(20, 10, 'Topic', 1);
  $pdf->Cell(30, 10, 'Instructor Name', 1);
  $pdf->Cell(40, 10, 'Time', 1);
  $pdf->Cell(20, 10, 'Date', 1);
  $pdf->Cell(150, 10, 'Link', 1);
  
  $pdf->Ln();

  // Data for charts
  $data_for_charts = [];

  // Populate table with data
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $pdf->SetFont('Arial', '', 10);
          $pdf->Cell(20, 10, $row['Id'], 1);
          $pdf->Cell(20, 10, $row['Topic'], 1);
          $pdf->Cell(30, 10, $row['Instructor_name'], 1);
          $pdf->Cell(40, 10, $row['Time'], 1);
          $pdf->Cell(20, 10, $row['date'], 1);
          $pdf->Cell(150, 10, $row['Link'], 1);
          
          $pdf->Ln();

          // Collect data for charts
          $data_for_charts[] = $row;
      }
  } else {
      $pdf->Cell(0, 10, "No records found for the given date range.", 0, 1);
  }

  // Include charts if requested
  if ($include_charts) {
      generate_charts($data_for_charts);  // Ensure you have a chart generation function
      $pdf->Image('chart.png', 10, $pdf->GetY(), 190);
  }
  // Move the cursor to the bottom for additional text
$pdf->Ln(20);  // Add space after charts or table

// Add text at the bottom of the PDF
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 10, "Note: This is an auto-generated report. For any inquiries, please contact our support team.", 0, 1, 'C');
$pdf->Ln(5);
$pdf->Cell(0, 10, "Email: Support.fitnesszone@gmail.com| Phone: +94-70-341-1511", 0, 1, 'C');
  // Save the PDF
  $report_file_name = "Online_Clz_Data_Report" . time() . ".pdf";
  $pdf->Output('F', 'reports/' . $report_file_name);

  // Save report name to the database using prepared statements
  $stmt = $conn->prepare("INSERT INTO generated_reports (report_name) VALUES (?)");
  $stmt->bind_param("s", $report_file_name);
  $stmt->execute();

  // Optionally, store the filename in the session
  $_SESSION['last_generated_report'] = $report_file_name;

  // Close connection
  $conn->close();

  // Output the PDF
  $pdf->Output();
}
    switch($report_type){
        case 'full_revenue':
            generate_full_revenue_report($start_date, $end_date, $include_charts,$conn);
            break;
        case 'week_revenue':
            generate_week_revenue_report($start_date, $end_date, $include_charts,$conn);
            break;
        case 'month_revenue':
            generate_month_revenue_report($start_date, $end_date, $include_charts,$conn);
            break;
        case 'year_revenue':
            generate_year_revenue_report($start_date, $end_date, $include_charts,$conn);
            break;
        case 'instructor':
            generate_instructor_report($start_date, $end_date, $include_charts,$conn);
            break;
        case 'User_Deatils':
            generate_user_report( $include_charts,$conn);
            break;
        case 'Online_Clz':
            generate_online_clz_report($include_charts,$conn);
            break;
        default:
            echo "Invalid report type!";
            break;
    }

    
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
    imagepng($image, "reports/chart.png");
    imagedestroy($image);  // Free memory
}

   
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
        <h3 class="text-center">Revenue and Instructor Report Generator</h3>
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
    <div class="container mt-5">
    <!-- Title -->
    
    
    <!-- Form Section -->
    <div class="card mt-4">
      <div class="card-body">
      <form action="Repoart.php" method="POST">
        
       <div class="row mb-3">
        <!-- Report Type Dropdown -->
        <h3 class="text-center">User and Online Class Report Generator</h3>
         <div class="col-md-6">
         
          <label for="reportType" class="form-label">Report Type</label>
          <select class="form-select" id="reportType" name="report_type" required>
             <option value="User_Deatils">User Details Report</option>
             <option value="Online_Clz">Online clz Report</option>
             
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
