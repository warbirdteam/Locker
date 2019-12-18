<?php
class Hash {

    public function unhash($input)
    {
        password_verify($input,$hashed_password);
    }

    public function hash($input)
    {
        return password_hash($input, PASSWORD_DEFAULT);
    }

}
?>
