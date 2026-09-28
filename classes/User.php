<?php

class User
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }


    //=======================================================================================
    // ============================================Image upload function===============================
    // ======================================================================================


    public function imageUpload(array $image): string
    {
        if ($image['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('Image upload failed.');
        }

        if ($image['size'] > 2 * 1024 * 1024) {
            throw new Exception('Maximum 2MB allowed.');
        }

        $allowedTypes = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp'
        ];

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($image['tmp_name']);

        if (!isset($allowedTypes[$mime])) {
            throw new Exception('Invalid image type.');
        }

        if (getimagesize($image['tmp_name']) === false) {
            throw new Exception('Invalid image.');
        }

        $uploadDir="../uploads/users/";

        if(!is_dir($uploadDir)) {
            mkdir($uploadDir,0777, true);
        }

        $newImageName = bin2hex(random_bytes(16)) . '.' . $allowedTypes[$mime];

        if (!move_uploaded_file($image['tmp_name'],$uploadDir . $newImageName)) {
            throw new Exception('Unable to upload image.');
        }

        return $newImageName;
    }


    //=======================================================================================
    // ============================================Insert User===============================
    // ======================================================================================

    public function addUser($name,$email,$password,?array $image,$gender,$banks): bool {
        
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $newImageName = null;
        
        if ($image !== null) {
            $newImageName = $this->imageUpload($image);
        }

        if ($newImageName !== null){
            $sql = "INSERT INTO sign_up
            (user_name, user_email, user_password, user_image, user_gender, user_banks)
            VALUES (?, ?, ?, ?, ?, ?)";
        
            $stmt = $this->conn->prepare($sql);
        
            if (!$stmt) {
                die("Prepare failed: " . $this->conn->error);
            }
        
            $stmt->bind_param(
                "ssssss",
                $name,
                $email,
                $passwordHash,
                $newImageName,
                $gender,
                $banks
            );
        
            return $stmt->execute();
        }

    }
        

    // ==========================================================================================
    // ===================================GET Users Data in DataTable=================================
    // ==========================================================================================
    
    public function getAllUsers()
    {
        $sql = "SELECT
                    user_id,
                    user_name,
                    user_email,
                    user_gender,
                    user_image,
                    user_banks 
                    FROM sign_up
                
                ORDER BY user_id DESC";

        $result = $this->conn->query($sql);

        $users = [];

        if ($result) {

            while ($row = $result->fetch_assoc()) {

                $users[] = $row;
            }
        }

        return $users;
    }

    // ===========================================================================================
    // ====================================DELETE User============================================
    // ===========================================================================================

    public function deleteUser($id)
    {
        $sql = "DELETE FROM sign_up WHERE user_id = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    // =======================================================================================
    // =====================================UPDATE User========================================
    // ========================================================================================

    public function updateUser(int $id,string $name,string $email,string $gender,?array $image,string $banks): bool {

        $newImageName = null;

        if ($image !== null) {

            $newImageName = $this->imageUpload($image);

        }

        if ($newImageName !== null) {

            $sql = "UPDATE sign_up
            SET user_name = ?,
                user_email = ?,
                user_gender = ?,
                user_banks = ?,
                user_image = ?
            WHERE user_id = ?";

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param(
                "sssssi",
                $name,
                $email,
                $gender,
                $banks,
                $newImageName,
                $id
            );

            return $stmt->execute();

        } else {

            $sql = "UPDATE sign_up
            SET user_name = ?,
                user_email = ?,
                user_gender = ?,
                user_banks = ?
            WHERE user_id = ?";

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param(
                "ssssi",
                $name,
                $email,
                $gender,
                $banks,
                $id
            );

            return $stmt->execute();
        }

    
    }


}