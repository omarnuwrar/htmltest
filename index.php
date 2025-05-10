<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Mark Lookup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 50px;
        }
        .container {
            max-width: 800px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            padding: 30px;
        }
        .result-card {
            margin-top: 20px;
            border-left: 5px solid #0d6efd;
        }
        .mark-badge {
            font-size: 18px;
            padding: 8px 15px;
        }
        .error-message {
            color: #dc3545;
            padding: 15px;
            border-radius: 5px;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">Student Mark Lookup</h1>

        <form method="POST" action="" class="mb-4">
            <div class="mb-3">
                <label for="studentName" class="form-label">Enter Student Name:</label>
                <input type="text" class="form-control" id="studentName" name="studentName"
                       placeholder="e.g., Alexander" required
                       value="<?php echo isset($_POST['studentName']) ? htmlspecialchars($_POST['studentName']) : ''; ?>">
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['studentName'])) {
            $studentName = trim($_POST['studentName']);

            // API endpoint URL
            $apiUrl = 'https://jubilant-space-broccoli-wrrj6ww7rw46cg7pv-5000.app.github.dev/api/students/search';

            // Headers to include in the request
            $headers = [
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36',
                'Cookie: tunnel_phishing_protection=tidy-field-6k3l0ws.usw3; .Tunnels.Relay.WebForwarding.Cookies=CfDJ8Cs4yarcs6pKkdu0hlKHsZtg_7pAp2XsTnXWU1m7-d7k_YNxoHXrBaSmtPpE-IL920Gd3isHdjvHV6gNVjObmT-cfYo23UVcnruFUBY6aJrF2BFDjk92-QLA2un2tLSntSlxYaXBsD7TDRUL-fcHPuXc9e2sTCjzT39j-D1julaMsYkNu4UgCcWFuxOvwLzRInPLbUanjCNXNPvHqIvXvS6PWasLNEqiw_nS52UfEIzv39OcSZPuaIvhu5WBl0-EbEDyMbxKa_Rr1sqRAq8s15FK9Tsobb12n6ZIUsF0e2i6Jck17ofeutvz-ZfV3W1NDKVaEkXAm_uc9XEnmA8JRxsDeG2NvPG6T3JRqzp5WymXuqoaTiK3sfT5teOe7YTr83pqh2K2qgAUcgx7b8iKtxQvE6EfE39FVjSuXHHcKEGWYQ-536W5NSt-GWYcTvBXCJ8C6n2AZBvbDffCxNNJUrg5k_nFsBac7jh82DQWiUd9qTIcfrsrBI6f3gvFOWfSabcJKJUdKN2klbeInKeHvx8XjokWjBgaL3kapjRpFIT3B5yIZjhA5HHb1MV4qKvUqljgm3MOfiqu6CsozFIHHeLw7RXkflzA4ymTRbKMWEj5NxIL8dfNdmoY8e0wvFxIyB7K1tv0M9StbvfxVuD5UhfQik0agl2pp0L1IsgZ-pBldj-UeXWJiAUZrQJsKTstdK79UP39Uyx0dSdyCzQnSz0GkSBEQlfXUeDqxXOjTNSqINUNP4_ZbEbwd8RpFAjPEqIX5t-KTj5eaQi3TpmguPkjj-1klrbV1t0OykMMUQznNyBtvHjymbO3ajCALEwSYPiegN_2bJPE2nopBI73dUTqdQIWSKNoVwkATWylpu1uIpegzAuL-Po9-hNv56XRGb8LWFLfchSmneGcJEa2C58wp_nn6aVbj-pmuml7XdZtRxXxAWG5Pm2un2mKuyDZV2Q1txIzVuF9Z9Ml8CBou9Di98IlSy3Axhou7cx3g269mBfNe0Bv8Wj5Kx6Sihi692Zo1MYCdLYBhHZWuMXA7JXEeF8XW9Gi6RYHkN_n7rbDAy1H7GrTkLRmt7wx1d02qQEWUuvr_8aL2LcRlwjRXXlBJf0raTBb3sUO7q6i0xKhrT3dtZLhHtnxj9G_ZZWzzVCkZUqOOor-yoK6p-9R6bWXFMeZLkIIrsdYjkCxsMXalEvHmXNUn-WSF8Tf0fI6Hf32mXFnBkQrA8CcG6-NlT8Y1jh9a-XNAfAnNrop2LwiCD_KzTBD9MXU4bpeQp8eLTERFCwgvhastSupI1O3eDJIgc0Uku9_OOpkyvytQR_maE0foO5TVGrkd68_hRzOBnHzP4B9CJdCEvC5TsDR3SF6iA--H9Xlpt9LC5hL402PRtvnM4moS98G0AK7Mw-1duIRYVbpyEnRFGtSO5aFvDq8Ygk3zV9G6Nn0SngwFsIAx56uw1BOdNVvlFwhNMBARuN-ZqCJ_9SWcgh_VxZkoczvminxdNOl6brqf_3WyBeD7PYWcPXI2P1PV1Y5y9lg53gU5RTIcbMYqbJe1BWZCaHem2Q8XhxUA_JHbbsuHfJhkqwNrfiUUt_1lvgEWW6ew_9u-wy2Uj-YNvaAt_ks-Gg'
            ];

            // Initialize cURL session
            $ch = curl_init();

            // Set cURL options
            curl_setopt($ch, CURLOPT_URL, $apiUrl . '?name=' . urlencode($studentName));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            // Execute the request
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            // Check for errors
            if (curl_errno($ch)) {
                echo '<div class="error-message mt-4">Error: ' . curl_error($ch) . '</div>';
            } else {
                // Process the response
                if ($httpCode == 200) {
                    $data = json_decode($response, true);

                    if (is_array($data) && !empty($data)) {
                        echo '<h3 class="mt-4">Results:</h3>';

                        foreach ($data as $student) {
                            // Determine badge color based on mark
                            $badgeColor = 'secondary';
                            if (isset($student['mark'])) {
                                if ($student['mark'] >= 90) {
                                    $badgeColor = 'success';
                                } elseif ($student['mark'] >= 70) {
                                    $badgeColor = 'primary';
                                } elseif ($student['mark'] >= 50) {
                                    $badgeColor = 'warning';
                                } else {
                                    $badgeColor = 'danger';
                                }
                            }

                            echo '<div class="card result-card mb-3">';
                            echo '<div class="card-body">';
                            echo '<div class="d-flex justify-content-between align-items-center">';
                            echo '<div>';
                            echo '<h5 class="card-title">' . htmlspecialchars($student['name']) . '</h5>';
                            echo '<p class="card-text text-muted">ID: ' . htmlspecialchars($student['id']) . '</p>';
                            echo '</div>';
                            echo '<span class="badge bg-' . $badgeColor . ' mark-badge">' .
                                 (isset($student['mark']) ? htmlspecialchars($student['mark']) : 'N/A') .
                                 '</span>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<div class="alert alert-info mt-4">No students found with the name "' . htmlspecialchars($studentName) . '".</div>';
                    }
                } else {
                    echo '<div class="error-message mt-4">Error: API returned status code ' . $httpCode . '</div>';
                }
            }

            // Close cURL session
            curl_close($ch);
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
