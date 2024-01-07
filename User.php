<!--Purpose: User class to handle numerous user functions-->
<?php

class User
{
    // User Attributes
    private $user_id;
    private $firstName;
    private $lastName;
    private $email;
    private $role;
    private $conn;

    public function __construct($conn, $user_id = null, $firstName = null, $lastName = null, $email = null, $role = null)
    {
        $this->user_id = $user_id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->role = $role;
        $this->conn = $conn;
    }

    // Getter Functions
    public function getUserId()
    {
        return $this->user_id;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getRole()
    {
        return $this->role;
    }

    // Purpose: To logout the user
    public function logout()
    {
        $_SESSION = array();
        session_destroy();
    }

    // Purpose: To get an array of all users and their details.
      public static function getAllUsers($conn) {
      $users = array();

      // Prepare a query to retrieve all users with their roles by joining tables
      $selectQuery = "SELECT users.user_id, users.email, users.first_name, users.last_name, roles.role_name
                        FROM users
                        JOIN user_role ON users.user_id = user_role.user_id
                        JOIN roles ON user_role.role_id = roles.role_id";

      $stmt = mysqli_prepare($conn, $selectQuery);

      if ($stmt) {
            // Execute the statement
            mysqli_stmt_execute($stmt);

            // Check for query execution success
            if ($result = mysqli_stmt_get_result($stmt)) {
                  // Get user records and create User objects
                  while ($row = mysqli_fetch_assoc($result)) {
                  $user = new User($conn,$row['user_id'], $row['email'], $row['first_name'], $row['last_name'], $row['role_name']);
                  $users[] = $user;
                  }

                  // Free the result set
                  mysqli_free_result($result);
            } else {
                  // Handle query result error
                  throw new Exception("Error fetching results: " . mysqli_stmt_error($stmt));
            }

            
            mysqli_stmt_close($stmt);
      } else {
            // Handle prepared statement error
            throw new Exception("Error preparing statement: " . mysqli_error($conn));
      }

            return $users;
      }

    // Purpose: Get user instance by Username.
    public function getUserByUsername($username) {
            $username = mysqli_real_escape_string($this->conn, $username);

            // Query to get user details by username
            $query = "SELECT * FROM users WHERE username = '$username'";

            // Execute the query
            $result = mysqli_query($this->conn, $query);

            // Check if the query was successful
            if ($result) {
                // Get user details as an associative array
                $user = mysqli_fetch_assoc($result);

                // Free the result set
                mysqli_free_result($result);

                return $user;
            } else {
                // Handle the error
                echo "Error: " . mysqli_error($this->conn);
                return false;
            }
        }


    // Purpose: Function to delete an account.
    public function deleteAccount($user_id)
    {
        // Ensure user_id is valid and exists
        if ($user_id) {
            // Delete user_role record for the user
            $stmtUserRole = $this->conn->prepare("DELETE FROM user_role WHERE user_id = ?");
            $stmtUserRole->bind_param("i", $user_id);

            // Execute the statement
            $stmtUserRole->execute();

            // Delete the user from the users table
            $stmtUser = $this->conn->prepare("DELETE FROM users WHERE user_id = ?");
            $stmtUser->bind_param("i", $user_id);

            // Execute the statement
            if ($stmtUser->execute()) {
                // Logout the user after deleting the account
                $this->logout();
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    // Purpose: Gets hashed password by Id
    public function getPasswordById($user_id) {
      // Prepared Statement
       $stmt = $this->conn->prepare("SELECT password FROM users WHERE user_id = ?");
       $stmt->bind_param("i", $user_id);
       $stmt->execute();
       $result = $stmt->get_result();
       $row = $result->fetch_assoc();
       $stmt->close();

       return $row ? $row['password'] : null;
   }

   // Purpose: To update a users password in the database based on user ID.
    public function updatePassword($user_id, $new_password) {
        // Hash the new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the password in the database
        $stmt = $this->conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
        $stmt->bind_param("si", $hashed_password, $user_id);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }


    // Purpose: Returs userId of a username.
    public function getUserIdByUsername($username)
    {
        // Prepare SQL Statement 
        $sql = "SELECT user_id FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username); // Bind params
        $stmt->execute(); // execute
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['user_id'];
        } else {
            return null; // Username not found
        }
    }

    // Purpose: Return all user details based on Id.
    public static function getUserDetailsById($conn, $user_id)
    {
        if (!is_numeric($user_id) || $user_id <= 0) {
            return null;
        }

        // Get user and role data from the database
        $sql = "SELECT users.*, roles.role_name
                FROM users
                JOIN user_role ON users.user_id = user_role.user_id
                JOIN roles ON user_role.role_id = roles.role_id
                WHERE users.user_id = ?";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("i", $user_id);

        // Execute the statement
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Check if the user ID exists
        if ($result->num_rows > 0) {
            // Fetch user data
            $row = $result->fetch_assoc();

            // Create and return a User object with the fetched data
            return new User(
                $conn,
                $row["user_id"],
                $row["first_name"],
                $row["last_name"],
                $row["email"],
                $row["role_name"]
            );
        } else {
            return null; // User not found
        }
    }


    // Purpose: Function to handle signing up a user in the database.
    public function signup($firstName, $lastName, $email, $username, $password)
    {
        // Check if the username already exists
        $check_username_sql = "SELECT * FROM users WHERE username = ?";
        $check_stmt = $this->conn->prepare($check_username_sql);
        $check_stmt->bind_param("s", $username);
        $check_stmt->execute();
        $existing_user = $check_stmt->fetch();
        $check_stmt->close();

        if ($existing_user) {
            // Username already exists
            header("Location: signup.html?error=usernameexists");
            exit();
        }

        // If username doesnt already exist insert user data into the database using prepared statements
        $sql = "INSERT INTO users (first_name, last_name, email, username, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("sssss", $firstName, $lastName, $email, $username, $password);

        $this->conn->begin_transaction();

        if ($stmt->execute()) {
            $user_id = $stmt->insert_id;

            // Assign Role
            $role_sql = "INSERT INTO user_role (user_id, role_id) VALUES (?, (SELECT role_id FROM roles WHERE role_name = 'user'))";
            $role_stmt = $this->conn->prepare($role_sql);
            $role_stmt->bind_param("i", $user_id);

            if (!$role_stmt->execute()) {
                // Roll back the transaction on role assignment failure
                $this->conn->rollback();
                $role_stmt->close();

                // Redirect with an error message
                header("Location: signup.html?error=registrationfailed");
                exit();
            }

            // Commit the transaction
            $this->conn->commit();
            $role_stmt->close();

            // Registration successful
            // Redirect to home page
            header("Location: index.php");
            exit();
        }

        // Roll back the transaction on user insertion failure
        $this->conn->rollback();

        // Redirect with an error message
        header("Location: signup.html?error=registrationfailed");
        exit();
    }


    // Purpose: Function to handle signing in of user and assigning user details to user instance.
    public function signin($username, $password)
    {
        // Validate the data
        if (empty($username) || empty($password)) {
            // Handle validation errors
            header("Location: signin.html?error=emptyfields");
            exit();
        }

        // Get user and role data from the database
        $sql = "SELECT users.*, roles.role_name
                FROM users
                JOIN user_role ON users.user_id = user_role.user_id
                JOIN roles ON user_role.role_id = roles.role_id
                WHERE users.username = ?";
        $stmt = $this->conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("s", $username);

        $stmt->execute();

        $result = $stmt->get_result();

        // Check if the username exists
        if ($result->num_rows > 0) {
            // Get user data
            $row = $result->fetch_assoc();

            // Update user attributes
            $this->user_id = $row["user_id"];
            $this->firstName = $row["first_name"];
            $this->lastName = $row["last_name"];
            $this->email = $row["email"];
            $this->role = $row["role_name"];

            $db_password_hash = $row["password"];

            // Check if the entered password matches the stored hash
            if (password_verify($password, $db_password_hash)) {
                // store user information in the session
                session_start();
                $_SESSION["user_id"] = $this->user_id;
                $_SESSION["username"] = $username;
                $_SESSION["role"] = $this->role;

                // Redirect to the home page
                header("Location: index.php");
                exit();
            } else {
                // redirect back to the sign-in page with an error message
                header("Location: signinpage.php?error=incorrectpassword");
                exit();
            }
        } else {
            // redirect back to the sign-in page with an error message
            header("Location: signinpage.php?error=usernotfound");
            exit();
        }

        $stmt->close();
    }

    // Purpose: To promtoe or demote a user to a new role.
    public function promoteToRole($userId, $newRole)
    {
        // Validate the new role to ensure it's a valid role
        $validRoles = ['User', 'Moderator', 'Admin'];

        if (!in_array($newRole, $validRoles)) {
            return false;
        }

        // Update the user role in the user_role table
        $updateRoleSql = "UPDATE user_role SET role_id = (SELECT role_id FROM roles WHERE role_name = ?) WHERE user_id = ?";
        $stmt = $this->conn->prepare($updateRoleSql);

        $stmt->bind_param("si", $newRole, $userId);

        $result = $stmt->execute();

        $stmt->close();

        return $result;
    }
}

?>
