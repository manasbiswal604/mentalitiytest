<?php
// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve name from the form
  $name = isset($_POST['name']) ? $_POST['name'] : '';

  // Initialize an empty array to store all user selections
  $user_responses = [];

  // Loop through the questions and save user responses
  for ($i = 1; $i <= 28; $i++) {
    // Check if the question exists in the form submission
    if (isset($_POST['q' . $i])) {
      // Store the user's response for this question
      $user_responses['Question ' . $i] = $_POST['q' . $i];
    } else {
      // If the question is not answered, mark it as 'Not Answered'
      $user_responses['Question ' . $i] = 'Not Answered';
    }
  }

  // Store contributing factors selected by the user
  $contributing_factors = isset($_POST['contributing_factors']) ? $_POST['contributing_factors'] : [];
  $user_responses['Contributing Factors'] = $contributing_factors;

  // Store physical health conditions selected by the user
  $physical_health_conditions = isset($_POST['physical_health_conditions']) ? $_POST['physical_health_conditions'] : [];
  $user_responses['Physical Health Conditions'] = $physical_health_conditions;

  // Create a file name based on the user's name and current timestamp
  $file_name = 'results_' . $name . '_' . date('Ymd_His') . '.txt';

  // Open the file for writing
  $file_handle = fopen($file_name, 'w');

  // Write user responses to the file
  fwrite($file_handle, "User: $name\n\n");
  foreach ($user_responses as $question => $response) {
    if (is_array($response)) {
      // If the response is an array (for checkboxes), format it as a list
      fwrite($file_handle, "$question:\n");
      foreach ($response as $item) {
        fwrite($file_handle, "- $item\n");
      }
    } else {
      // If the response is a single value, write it directly
      fwrite($file_handle, "$question: $response\n");
    }
    fwrite($file_handle, "\n");
  }

  // Close the file
  fclose($file_handle);

  // Provide feedback to the user
  echo '<h1>Form Submitted Successfully!</h1>';
} else {
  // If the form is not submitted, redirect back to the form page
  header('Location: index.html');
  exit;
}
?>
