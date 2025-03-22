<?php
if (isset($_GET['success'])) {
    echo '<div class="alert alert-success">Customer data saved successfully.</div>';
}

$customers = [];
if (file_exists('customer.txt')) {
    $lines = file('customer.txt', FILE_IGNORE_NEW_LINES);
    foreach ($lines as $line) {
        if (!empty(trim($line))) {
            $customers[] = explode(',', $line);
        }
    }
}

if (empty($customers)) {
    echo '<div class="alert alert-info">No customers registered yet.</div>';
} else {
    echo '<table class="table table-bordered">';
    echo '<tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Gender</th></tr>';

    foreach ($customers as $index => $customer) {
        if (count($customer) >= 5) {
            echo '<tr>';
            echo '<td>' . $customer[0] . '</td>';
            echo '<td>' . $customer[1] . '</td>';
            echo '<td>' . $customer[2] . '</td>';
            echo '<td>' . $customer[3] . '</td>';
            echo '</tr>';
        }
    }

    echo '</table>';
}
