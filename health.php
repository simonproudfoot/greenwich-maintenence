<?php

function your_plugin_get_color_for_score($score)
{
    if ($score >= 80) {
        return '#00a32a'; // Green
    } elseif ($score >= 60) {
        return '#dba617'; // Orange
    } else {
        return '#d63638'; // Red
    }
}

function calculate_health_data()
{
  
    // Get the stored site health information
    $site_status_json = get_transient('health-check-site-status-result');

    // Parse the JSON string
    $site_status = json_decode($site_status_json, true);

    // Initialize the result object
    $result = new stdClass();

    // Calculate the status and score
    if (is_array($site_status) && isset($site_status['good'])) {
        $total_tests = intval($site_status['good']) +
            intval($site_status['recommended']) +
            (intval($site_status['critical']) * 1.5);
        $failed_tests = (intval($site_status['recommended']) * 0.5) +
            (intval($site_status['critical']) * 1.5);

        $score = 100;
        if ($total_tests > 0) {
            $score = 100 - ceil(($failed_tests / $total_tests) * 100);
        }

        // Determine status based on WordPress logic
        if ($score >= 80 && intval($site_status['critical']) === 0) {
            $status = 'Good';
        } else {
            $status = 'Should be improved';
        }

        $result->calculated = new stdClass();
        $result->calculated->score = $score;
        $result->calculated->status = $status;
        $result->calculated->color = your_plugin_get_color_for_score($score);

        // Add color-coded issue counts
        $result->issues = new stdClass();
        $result->issues->good = new stdClass();
        $result->issues->good->count = intval($site_status['good']);
        $result->issues->good->color = your_plugin_get_color_for_score(100);

        $result->issues->recommended = new stdClass();
        $result->issues->recommended->count = intval($site_status['recommended']);
        $result->issues->recommended->color = your_plugin_get_color_for_score(70);

        $result->issues->critical = new stdClass();
        $result->issues->critical->count = intval($site_status['critical']);
        $result->issues->critical->color = your_plugin_get_color_for_score(30);
    }

    return $result;
}

function get_site_health_data()
{
    $data = calculate_health_data();

    if (is_wp_error($data)) {
        wp_die($data->get_error_message(), 403);
    }

    return $data;
}


