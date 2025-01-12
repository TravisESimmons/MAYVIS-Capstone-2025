
<?php 

// INCLUDE CONNECTION IN PARENT SCRIPT BEFORE INCLUDING THIS
require_once('./PHPMailer/PHPMailerAutoload.php');
$errors = [];
$cases = array("0"=>
    "<p>You have recieved a new proposal. Please sign into your MAYVIS account to view its details.</p>",
    "1"=> "<p>A client has updated the status of your proposal. Please sign in to view its details.</p>");


// functions

function allows_notifications($conn, $proposal_id, $case) {
    
    // if sending to employee
    if ($case == "employee") {
        $employee_email = get_employee($conn, $proposal_id);
        $sql = $conn->prepare("SELECT notifications FROM users WHERE user_email = ?");
        $sql->bind_param("i", $employee_email);
        $sql->execute();

        //results
        $result = $sql->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $notifications = $row['notifications'];
            if ($notifications == '0'){
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    } else {
        return false;
    }

}

// get associated contacts associated with the client tied to the proposal
function get_contacts($conn, $proposal_id) {
    // sql statement
    $sql = $conn->prepare("SELECT * FROM proposals WHERE proposal_id = ?");
    $sql->bind_param("i", $proposal_id);
    $sql->execute();
    
    $result = $sql->get_result();
    // deal with result
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $client_id = $row['client_id'];
        
        // contacts table where email matches client id
        $sql = $conn->prepare("SELECT * FROM contacts WHERE client_id = ?");
        $sql->bind_param("i", $client_id);
        $sql->execute();

        $result = $sql->get_result();
        
        if ($result->num_rows > 0) {
            $emails = array();
            while ($row_contacts = $result->fetch_assoc()) {
                $emails[] = $row_contacts['email'];
            }
            return $emails;
        } else {
            return null;
        }
    } else {
        return null;
    }
}

// get employee associated with the proposal
function get_employee($conn, $proposal_id) {
    // sql statement
    $sql = $conn->prepare("SELECT users.user_email from users JOIN employees on employees.employee_id = users.user_id JOIN proposals on proposals.employee_id = employees.employee_id WHERE proposal_id = ?");
    $sql->bind_param("i", $proposal_id);
    $sql->execute();
    
    $result = $sql->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $employee_email = $row['user_email'];
        return $employee_email;
    } else {
        return null;
    }
}

// send to client
function send_to_client($conn, $proposal_id, $case_number) {
    global $cases;
    $emails = get_contacts($conn, $proposal_id);
    if (!empty($emails)) {
        foreach ($emails as $email) {
            // creating email
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'ssl';
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = '465';
            $mail->isHTML();
            $mail->Username = ''; // change
            $mail->Password = ''; // create and enter app password
            $mail->SetFrom(''); // change to no-reply or whatever you need
        
            // email content
            $mail->Subject = '';
                // message -- change to whatever you want yours to say
            $message = $cases[$case_number];
            $mail->Body = $message;
            $mail->AddAddress($email); // you will have to initialize the $email earlier in your script

            try {
                $mail->Send();
            } catch (Exception $e) {
                echo "Error sending email: " . $mail->ErrorInfo;
            }
        }
    } else {
        echo "<p>No client associated with the proposal.</p>";
    }


}


function proposal_update($conn, $proposal_id, $case_number) {
    global $cases;
    $employee_email = get_employee($conn, $proposal_id);
    if (!empty($employee_email)) {
        // creating email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = '465';
        $mail->isHTML();
        $mail->Username = ''; // change
        $mail->Password = ''; // create and enter app password
        $mail->SetFrom(''); // change to no-reply or whatever you need
    
        // email content
        $mail->Subject = '';
            // message -- change to whatever you want yours to say
        $message = $cases[$case_number];
        $mail->Body = $message;
        $mail->AddAddress($employee_email); // you will have to initialize the $email earlier in your script
        try {
            $mail->Send();
        } catch (Exception $e) {
            echo "Error sending email: " . $mail->ErrorInfo;
        }
    } else {
        echo "<p>There was an error, please try submitting again. If the error persists, please contact us directly.</p>";
    }
}



?>