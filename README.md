# Secure File Download and Decryption System

## Introduction
This project is a PHP-based secure file download and decryption system. It allows users to download files that are stored in an encrypted format on the server, ensuring data security during storage and transfer. The system retrieves encrypted files, decrypts them using AES-256-CBC, and streams them to the user's browser with the correct filename and MIME type.

## Purpose
The project aims to provide a secure mechanism for storing and delivering sensitive files. It addresses the following needs:
- **Security**: Files are encrypted on the server to prevent unauthorized access.
- **User Experience**: Downloads are delivered with user-friendly filenames and proper MIME types.
- **Scalability**: The system uses a database to manage file metadata, making it suitable for handling multiple files.

This project is ideal for applications requiring secure file handling, such as document management systems, private file-sharing platforms, or secure content delivery.

## How It Works
The workflow for downloading and decrypting a file is as follows:
1. **User Request**: A user accesses a download link (e.g., `/download.php?id=123`), where `id` corresponds to a file record in the database.
2. **Database Lookup**: The `download.php` script queries the database using the provided `id` to retrieve the file's metadata, including the original filename, encrypted filename, encryption key, initialization vector (IV), and MIME type.
3. **File Retrieval**: The script locates the encrypted file in the `/uploads/encrypted_files` directory using the encrypted filename.
4. **Decryption**: The file's binary content is decrypted using `openssl_decrypt()` with AES-256-CBC, the stored key, and IV.
5. **Streaming**: The decrypted file is streamed to the browser with appropriate HTTP headers (`Content-Type`, `Content-Disposition`, and `Content-Length`) to ensure correct handling and naming.

## Project Directory Structure
```
/project-root
├── /config
│   └── database.php          # Database configuration (connection settings)
├── /includes
│   ├── encryption.php       # Encryption/decryption helper functions
│   └── db_connect.php       # Database connection logic
├── /uploads
│   └── encrypted_files/     # Directory for storing encrypted files (not tracked in VCS)
├── download.php             # Handles file download and decryption
├── .env                     # Environment variables (e.g., DB credentials)
├── .htaccess               # Security rules to restrict direct access to uploads
└── README.md               # Project documentation
```

## Requirements
### Server
- **PHP**: 8.1 or higher with `openssl`, `pdo_mysql`, and `mbstring` extensions
- **Web Server**: Apache (with `.htaccess` support) or Nginx
- **Database**: MySQL 5.7 or higher (or MariaDB)
- **File System**: Writable `/uploads/encrypted_files` directory

### Database Schema
- **Table**: `files`
  - `id` (INT, PRIMARY KEY, AUTO_INCREMENT): Unique file ID
  - `original_filename` (VARCHAR): User-friendly filename (e.g., "document.pdf")
  - `encrypted_filename` (VARCHAR): Unique filename for encrypted file (e.g., "abc123.enc")
  - `encryption_key` (BINARY(32)): 256-bit AES encryption key
  - `iv` (BINARY(16)): Initialization vector for AES-256-CBC
  - `mime_type` (VARCHAR): File MIME type (e.g., "application/pdf")

### Dependencies
- **Optional**: `vlucas/phpdotenv` for environment variable management
  - Install via Composer: `composer require vlucas/phpdotenv`

## Setup Instructions
1. **Clone the Repository**:
   ```bash
   git clone https://github.com/your-username/your-repo.git
   cd your-repo
   ```

2. **Install Dependencies** (if using phpdotenv):
   ```bash
   composer install
   ```

3. **Set Up the Database**:
   - Create a MySQL database (e.g., `file_storage`).
   - Create the `files` table with the schema above:
     ```sql
     CREATE TABLE files (
         id INT AUTO_INCREMENT PRIMARY KEY,
         original_filename VARCHAR(255) NOT NULL,
         encrypted_filename VARCHAR(255) NOT NULL UNIQUE,
         encryption_key BINARY(32) NOT NULL,
         iv BINARY(16) NOT NULL,
         mime_type VARCHAR(100) NOT NULL
     );
     ```

4. **Configure Environment**:
   - Copy `.env.example` to `.env` and update with your database credentials:
     ```
     DB_HOST=localhost
     DB_NAME=file_storage
     DB_USER=root
     DB_PASS=your_password
     ```

5. **Set Up File Storage**:
   - Create the `/uploads/encrypted_files` directory with write permissions:
     ```bash
     mkdir -p uploads/encrypted_files
     chmod 755 uploads/encrypted_files
     ```

6. **Secure Uploads Directory**:
   - Ensure the `.htaccess` file in `/uploads/encrypted_files` contains:
     ```
     Deny from all
     ```
   - For Nginx, add equivalent rules to deny direct access.

7. **Test the System**:
   - Upload a file (requires a separate upload script, not included here).
   - Access `/download.php?id=1` to test downloading a file with ID 1.

## Security Considerations
- **File Access**: The `.htaccess` file prevents direct access to `/uploads/encrypted_files`.
- **SQL Injection**: Uses PDO prepared statements to sanitize inputs.
- **Encryption**: Files are encrypted with AES-256-CBC, a secure symmetric encryption algorithm.
- **HTTPS**: Deploy the application over HTTPS to secure data in transit.
- **Input Validation**: The `download.php` script validates the `id` parameter to ensure it’s numeric.
- **MIME Type Safety**: Store and verify MIME types to prevent content-type spoofing.

## Additional Notes
- **File Upload**: This project focuses on the download and decryption workflow. A separate upload script is needed to store files and populate the database.
- **Scalability**: For high-traffic systems, consider adding caching, rate limiting, or authentication.
- **Error Handling**: The system includes basic error handling (e.g., file not found, decryption failure). Enhance as needed for production.
- **Testing**: Test with various file types (e.g., PDF, PNG, TXT) to ensure MIME type handling and decryption work correctly.

## Contributing
Contributions are welcome! Please submit issues or pull requests via GitHub. Ensure code follows PSR-12 standards and includes appropriate tests.

## License
This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.<!-- Initial commit: Set up project with README and .gitignore -->
<!-- Add initial project documentation in README.md -->
<!-- Update README with setup instructions -->
