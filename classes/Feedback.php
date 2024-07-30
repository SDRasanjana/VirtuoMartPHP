<?php
class Feedback {
    private $formID;
    private $name;
    private $email;
    private $subject;
    private $message;

    public function __construct($name, $email, $subject, $message) {
        $this->name = $name;
        $this->email = $email;
        $this->subject = $subject;
        $this->message = $message;
    }

    public function giveFeedback() {
        // This method would handle inserting the feedback into the database
        require_once './DbConnector.php';
        try {
            $dbConnector = new DbConnector();
            $conn = $dbConnector->getConnection();
            $stmt = $conn->prepare("INSERT INTO feedback (name, email, subject, message) VALUES (:name, :email, :subject, :message)");
            
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':subject', $this->subject);
            $stmt->bindParam(':message', $this->message);
          
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function viewFeedback() {
        // This method would retrieve and display feedback
        // Implementation depends on how you want to view feedback
    }
}
?>