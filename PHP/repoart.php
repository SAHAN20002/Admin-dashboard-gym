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
        <form>
          <div class="row mb-3">
            <!-- Date Range Input -->
            <div class="col-md-6">
              <label for="startDate" class="form-label">Start Date</label>
              <input type="date" class="form-control" id="startDate">
            </div>
            <div class="col-md-6">
              <label for="endDate" class="form-label">End Date</label>
              <input type="date" class="form-control" id="endDate">
            </div>
          </div>
          <div class="row mb-3">
            <!-- Report Type Dropdown -->
            <div class="col-md-6">
              <label for="reportType" class="form-label">Report Type</label>
              <select class="form-select" id="reportType">
                <option value="summary">Full Rewenew Report</option>
                <option value="summary">Week Rewenew Report</option>
                <option value="summary">Month Rewenew Report</option>
                <option value="summary">Year Rewenew Report</option>
                <option value="detailed">Instructor Report</option>
                
              </select>
            </div>
            <div class="col-md-6">
              <!-- Checkbox for Including Charts -->
              <div class="form-check mt-4">
                <input class="form-check-input" type="checkbox" id="includeCharts">
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
        <h5 class="card-title">Generated Report</h5>
        <div id="reportContent">
          <!-- Report content will appear here after generation -->
          <p>No report generated yet.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS (optional) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
