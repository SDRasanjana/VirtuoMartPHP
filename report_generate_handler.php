<?php
require_once('report_generator.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $report_type = $_POST['report_type'];
    $report_generator = new ReportGenerator();

    if ($report_type === 'daily') {
        $date = $_POST['date'];
        $report_generator->generateDailyReport($date);
        $report_generator->Output('D', 'Daily_Report_' . $date . '.pdf', true);
    } elseif ($report_type === 'weekly') {
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $report_generator->generateWeeklyReport($start_date, $end_date);
        $report_generator->Output('D', 'Weekly_Report_' . $start_date . '_to_' . $end_date . '.pdf', true);
    }
}
?>