CREATE TABLE journals (
    journal_id INT AUTO_INCREMENT PRIMARY KEY,
    journal_date DATE NOT NULL,
    journal_type ENUM('DEBIT', 'CREDIT') NOT NULL,
    journal_description VARCHAR(255) NOT NULL,
    journal_amount DECIMAL(10,2) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);