<?php

function validate_message($message)
{
    // function to check if message is correct (must have at least 10 caracters (after trimming))
    // trim xóa ký tự đầu và cuối chuỗi
    if(strlen(trim($message)) < 10){
        return "Message must be at least 10 characters long";
    }
}

function validate_username($username)
{
    // function to check if username is correct (must be alphanumeric => Use the function 'ctype_alnum()')
    // Kiểm tra các kí tự số và chuỗi. Nó trả về TRUE nếu mọi ký tự trong chuỗi str là một chữ cái hoặc một chữ số, nếu không là FALSE.
    if(ctype_alnum($username) == false){
      return  "Username should contains only letters and numbers";
    }

}

function validate_email($email)
{
    // function to check if email is correct (must contain '@')
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return  "email must contain '@'";
      }

}


$user_error = "";
$email_error = "";
$terms_error = "";
$message_error = "";
$username = "";
$email = "";
$message = "";

$form_valid = false;


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Here is the list of error messages that can be displayed:
    //
    // "Message must be at least 10 caracters long"
    // "You must accept the Terms of Service"
    // "Please enter a username"
    // "Username should contains only letters and numbers"
    // "Please enter an email"
    // "email must contain '@'"

    if (empty($_POST['username'])) {
        $user_error = "Please enter a username";
    } else {
        $username = $_POST['username'];
        $user_error = validate_username($username);
    }

    if (empty($_POST['email'])) {
        $email_error = "Please enter an email";
    } else {
        $email = $_POST['email'];
        $email_error = validate_email($email);
    }

    if (empty($_POST['message'])) {
        $message_error = "Please enter a message";
    } else {
        $message = htmlspecialchars($_POST['message']);
        $message_error = validate_message($message);
    }

    if (!isset($_POST['terms'])) {
        $terms_error = "You must accept the Terms of Service";
    }
// Khi các cái biến lỗi bị rỗng thì $form_valid sẽ đúng
    if (empty($user_error) && empty($email_error) && empty($message_error) && empty($terms_error)) {
        $form_valid = true;
    }

}

?>

<form action="#" method="post">
    <div class="row mb-3 mt-3">
        <div class="col">
            <input type="text" class="form-control" placeholder="Enter Name" name="username">
            <small class="form-text text-danger"> <?php echo $user_error; ?></small>
        </div>
        <div class="col">
            <input type="text" class="form-control" placeholder="Enter email" name="email">
            <small class="form-text text-danger"> <?php echo $email_error; ?></small>
        </div>
    </div>
    <div class="mb-3">
        <textarea name="message" placeholder="Enter message" class="form-control"></textarea>
        <small class="form-text text-danger"> <?php echo $message_error; ?></small>
    </div>
    <div class="mb-3">
        <input type="checkbox" class="form-control-check" name="terms" id="terms" value="terms"> <label for="terms">I accept the Terms of Service</label>
        <small class="form-text text-danger"> <?php echo $terms_error; ?></small>
    </div>
    <div class="d-grid">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>

<hr>

<?php
if ($form_valid == true) :
?>
    <div class="card">
        <div class="card-header">
            <p><?php echo $username; ?></p>
            <p><?php echo $email; ?></p>
        </div>
        <div class="card-body">
            <p class="card-text"><?php echo $message; ?></p>
        </div>
    </div>
<?php
endif;
?>