CREATE TABLE password_reset (
    id_reset int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    reset_email text NOT NULL,
    reset_selector TEXT NOT NULL,
    reset_token LONGTEXT NOT NULL
    reset_expiry TEXT NOT NULL
);