<?php
require('library/fpdf.php');
require_once('classes/DbConnector.php');

class ReportGenerator extends FPDF {
    private $db;

    public function __construct() {
        parent::__construct();
        $this->db = new Database();
    }

    public function generateDailyReport($date) {
        $this->AddPage();
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'Daily Sales Report - ' . $date, 0, 1, 'C');
        
        $conn = $this->db->getConnection();
        
        // total sales...Daily 
        $sql = "SELECT SUM(total_amount) as daily_total FROM orders WHERE DATE(order_date) = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $date);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $daily_total = $row['daily_total'];

        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 10, 'Total Sales: $' . number_format($daily_total, 2), 0, 1);

        // Top selling items
        $sql = "SELECT p.name, COUNT(*) as quantity, SUM(o.total_amount) as total
            FROM orders o
            JOIN products p ON o.customer_id = p.id  -- This join might not be accurate, adjust as needed
            WHERE DATE(o.order_date) = ?
            GROUP BY p.id
            ORDER BY quantity DESC
            LIMIT 5";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $date);
        $stmt->execute();
        $result = $stmt->get_result();

        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Top Selling Products', 0, 1);
        $this->SetFont('Arial', '', 12);
        $this->Cell(80, 10, 'Product', 1);
        $this->Cell(40, 10, 'Quantity', 1);
        $this->Cell(40, 10, 'Total', 1);
        $this->Ln();

        while ($row = $result->fetch_assoc()) {
            $this->Cell(80, 10, $row['name'], 1);
            $this->Cell(40, 10, $row['quantity'], 1);
            $this->Cell(40, 10, '$' . number_format($row['total'], 2), 1);
            $this->Ln();
        }
    }

    public function generateWeeklyReport($start_date, $end_date) {
        $this->AddPage();
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'Weekly Sales Report - ' . $start_date . ' to ' . $end_date, 0, 1, 'C');
        
        $conn = $this->db->getConnection();
        
        // total sales...Weekly 
        $sql = "SELECT SUM(total_amount) as weekly_total FROM orders WHERE order_date BETWEEN ? AND ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $start_date, $end_date);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $weekly_total = $row['weekly_total'];

        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 10, 'Total Sales: $' . number_format($weekly_total, 2), 0, 1);

        // sales breakdown...Daily 
        $sql = "SELECT DATE(order_date) as date, SUM(total_amount) as daily_total
                FROM orders
                WHERE order_date BETWEEN ? AND ?
                GROUP BY DATE(order_date)
                ORDER BY date";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $start_date, $end_date);
        $stmt->execute();
        $result = $stmt->get_result();

        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Daily Sales Breakdown', 0, 1);
        $this->SetFont('Arial', '', 12);
        $this->Cell(80, 10, 'Date', 1);
        $this->Cell(80, 10, 'Total Sales', 1);
        $this->Ln();

        while ($row = $result->fetch_assoc()) {
            $this->Cell(80, 10, $row['date'], 1);
            $this->Cell(80, 10, '$' . number_format($row['daily_total'], 2), 1);
            $this->Ln();
        }
    }

    public function Output($dest = '', $name = '', $isUTF8 = false) {
        parent::Output($dest, $name, $isUTF8);
    }
}
?>