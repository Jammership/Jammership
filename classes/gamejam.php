<?php
class GameJam
{
    private PDO $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Create a new game jam
     */
    public function createJam($title, $description, $startDate, $endDate, $type, $thumbnail, $organizerId)
    {
        $query = "INSERT INTO jams (title, description, start_date, end_date, type, thumbnail, organizator_id)
                  VALUES (:title, :description, :start_date, :end_date, :type, :thumbnail, :organizator_id)";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':start_date', $startDate, PDO::PARAM_STR);
        $stmt->bindParam(':end_date', $endDate, PDO::PARAM_STR);
        $stmt->bindParam(':type', $type, PDO::PARAM_STR);
        $stmt->bindParam(':thumbnail', $thumbnail, PDO::PARAM_STR);
        $stmt->bindParam(':organizator_id', $organizerId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Get all game jams
     */
    public function getAllJams()
    {
        $query = "SELECT j.*, u.username as organizer_name
                 FROM jams j
                 JOIN users u ON j.organizator_id = u.id
                 ORDER BY j.start_date DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get jams created by a specific organizer
     */
    public function getJamsByOrganizer($organizerId)
    {
        $query = "SELECT * FROM jams WHERE organizator_id = :organizator_id ORDER BY created_at DESC";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':organizator_id', $organizerId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get a specific jam by ID
     */
    public function getJamById($jamId)
    {
        $query = "SELECT j.*, u.username as organizer_name
                 FROM jams j
                 JOIN users u ON j.organizator_id = u.id
                 WHERE j.id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $jamId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Update jam status based on dates
     */
    public function updateJamStatuses()
    {
        $now = date('Y-m-d H:i:s');

        // Update to active
        $this->db->query("UPDATE jams SET status = 'active'
                         WHERE start_date <= '$now' AND end_date >= '$now'");

        // Update to ended
        $this->db->query("UPDATE jams SET status = 'ended'
                         WHERE end_date < '$now'");

        // Update to upcoming
        $this->db->query("UPDATE jams SET status = 'upcoming'
                         WHERE start_date > '$now'");
    }

    /**
     * Apply to a jam
     */
    public function applyToJam($jamId, $userId)
    {
        // Check if already applied
        $checkQuery = "SELECT * FROM applications WHERE jam_id = :jam_id AND user_id = :user_id";
        $checkStmt = $this->db->prepare($checkQuery);
        $checkStmt->bindParam(':jam_id', $jamId, PDO::PARAM_INT);
        $checkStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {
            return ['success' => false, 'message' => 'You have already applied to this jam'];
        }

        // Insert new application
        $query = "INSERT INTO applications (jam_id, user_id) VALUES (:jam_id, :user_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':jam_id', $jamId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Application submitted successfully'];
        } else {
            return ['success' => false, 'message' => 'Failed to submit application'];
        }
    }

    public function getJamApplications($jamId)
    {
        $query = "SELECT a.*, u.username, u.email, u.profile_pic
              FROM applications a
              JOIN users u ON a.user_id = u.id
              WHERE a.jam_id = :jam_id
              ORDER BY a.applied_at DESC";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':jam_id', $jamId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get jams organized by a user with application counts
     */
    public function getOrganizerJams($organizerId)
    {
        $query = "SELECT j.*, 
                (SELECT COUNT(*) FROM applications WHERE jam_id = j.id) as application_count
              FROM jams j
              WHERE j.organizator_id = :organizator_id
              ORDER BY j.created_at DESC";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':organizator_id', $organizerId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Update application status
     */
    public function updateApplicationStatus($applicationId, $status)
    {
        $query = "UPDATE applications SET status = :status WHERE id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':id', $applicationId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function updateJam($jamId, $title, $description, $startDate, $endDate, $type, $thumbnail)
    {
        // First check if thumbnail needs updating
        if ($thumbnail) {
            $query = "UPDATE jams SET 
                  title = :title, 
                  description = :description, 
                  start_date = :start_date, 
                  end_date = :end_date, 
                  type = :type, 
                  thumbnail = :thumbnail 
                  WHERE id = :id";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':thumbnail', $thumbnail, PDO::PARAM_STR);
        } else {
            $query = "UPDATE jams SET 
                  title = :title, 
                  description = :description, 
                  start_date = :start_date, 
                  end_date = :end_date, 
                  type = :type 
                  WHERE id = :id";

            $stmt = $this->db->prepare($query);
        }

        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':start_date', $startDate, PDO::PARAM_STR);
        $stmt->bindParam(':end_date', $endDate, PDO::PARAM_STR);
        $stmt->bindParam(':type', $type, PDO::PARAM_STR);
        $stmt->bindParam(':id', $jamId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Delete a game jam
     */
    public function deleteJam($jamId, $organizerId)
    {
        // First check if the jam belongs to this organizer
        $checkQuery = "SELECT * FROM jams WHERE id = :id AND organizator_id = :organizer_id";
        $checkStmt = $this->db->prepare($checkQuery);
        $checkStmt->bindParam(':id', $jamId, PDO::PARAM_INT);
        $checkStmt->bindParam(':organizer_id', $organizerId, PDO::PARAM_INT);
        $checkStmt->execute();

        if ($checkStmt->rowCount() === 0) {
            return ['success' => false, 'message' => 'Unauthorized to delete this jam'];
        }

        // Delete all applications for this jam first
        $deleteAppsQuery = "DELETE FROM applications WHERE jam_id = :jam_id";
        $deleteAppsStmt = $this->db->prepare($deleteAppsQuery);
        $deleteAppsStmt->bindParam(':jam_id', $jamId, PDO::PARAM_INT);
        $deleteAppsStmt->execute();

        // Now delete the jam
        $deleteJamQuery = "DELETE FROM jams WHERE id = :id";
        $deleteJamStmt = $this->db->prepare($deleteJamQuery);
        $deleteJamStmt->bindParam(':id', $jamId, PDO::PARAM_INT);

        if ($deleteJamStmt->execute()) {
            return ['success' => true, 'message' => 'Game jam deleted successfully'];
        } else {
            return ['success' => false, 'message' => 'Failed to delete game jam'];

        }
    }
}