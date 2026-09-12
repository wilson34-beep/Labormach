CREATE DATABASE IF NOT EXISTS `labormatch_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `labormatch_db`;
SET NAMES utf8mb4;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS activity_logs;
DROP TABLE IF EXISTS badge_views;
DROP TABLE IF EXISTS notifications;
DROP TABLE IF EXISTS training_registrations;
DROP TABLE IF EXISTS trainings;
DROP TABLE IF EXISTS saved_jobs;
DROP TABLE IF EXISTS applications;
DROP TABLE IF EXISTS jobs;
DROP TABLE IF EXISTS skills;
DROP TABLE IF EXISTS employers;
DROP TABLE IF EXISTS job_seekers;
DROP TABLE IF EXISTS announcements;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS barangays;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE barangays (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  municipality VARCHAR(120) NOT NULL DEFAULT 'General MacArthur',
  province VARCHAR(120) NOT NULL DEFAULT 'Eastern Samar',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  barangay_id INT NULL,
  name VARCHAR(140) NOT NULL,
  email VARCHAR(140) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('municipal_admin','barangay_admin','employer','jobseeker') NOT NULL,
  contact_number VARCHAR(40) NULL,
  profile_photo VARCHAR(255) NULL,
  status ENUM('pending','active','verified','suspended','rejected') NOT NULL DEFAULT 'pending',
  email_verified_at DATETIME NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NULL,
  municipal_admin_guard TINYINT AS (CASE WHEN role = 'municipal_admin' THEN 1 ELSE NULL END) VIRTUAL,
  barangay_admin_barangay_id INT AS (CASE WHEN role = 'barangay_admin' THEN barangay_id ELSE NULL END) VIRTUAL,
  UNIQUE KEY uq_one_municipal_admin (municipal_admin_guard),
  UNIQUE KEY uq_one_barangay_admin_per_barangay (barangay_admin_barangay_id),
  CONSTRAINT fk_users_barangay FOREIGN KEY (barangay_id) REFERENCES barangays(id) ON DELETE SET NULL
);

CREATE TABLE job_seekers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL UNIQUE,
  birthdate DATE NULL,
  gender VARCHAR(30) NULL,
  address VARCHAR(255) NULL,
  education VARCHAR(120) NULL,
  employment_status ENUM('unemployed','employed','underemployed','student','fresh_graduate') DEFAULT 'unemployed',
  previous_employer VARCHAR(160) NULL,
  position VARCHAR(120) NULL,
  years_experience INT NOT NULL DEFAULT 0,
  previous_salary DECIMAL(10,2) NULL,
  expected_salary DECIMAL(10,2) NULL,
  skills TEXT NULL,
  soft_skills TEXT NULL,
  certifications TEXT NULL,
  licenses TEXT NULL,
  profile_photo VARCHAR(255) NULL,
  resume_path VARCHAR(255) NULL,
  certificate_path VARCHAR(255) NULL,
  looking_for_work TINYINT(1) NOT NULL DEFAULT 1,
  verification_status ENUM('pending','verified','rejected') NOT NULL DEFAULT 'pending',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NULL,
  CONSTRAINT fk_seekers_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE employers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL UNIQUE,
  business_name VARCHAR(180) NOT NULL,
  business_address VARCHAR(255) NULL,
  business_type VARCHAR(120) NULL,
  industry VARCHAR(120) NULL,
  contact_person VARCHAR(140) NULL,
  company_description TEXT NULL,
  logo_path VARCHAR(255) NULL,
  business_permit_path VARCHAR(255) NULL,
  supporting_document_path VARCHAR(255) NULL,
  verification_status ENUM('pending','verified','rejected') NOT NULL DEFAULT 'pending',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NULL,
  CONSTRAINT fk_employers_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE skills (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category VARCHAR(120) NOT NULL,
  name VARCHAR(120) NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uq_skill (category, name)
);

CREATE TABLE jobs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  employer_id INT NOT NULL,
  barangay_id INT NULL,
  title VARCHAR(180) NOT NULL,
  description TEXT NOT NULL,
  category VARCHAR(120) NOT NULL,
  required_skills TEXT NULL,
  education_requirement VARCHAR(140) NULL,
  experience_years INT NOT NULL DEFAULT 0,
  salary_min DECIMAL(10,2) NULL,
  salary_max DECIMAL(10,2) NULL,
  employment_type ENUM('Full-Time','Part-Time','Contractual','Temporary','Internship','Work From Home') NOT NULL,
  vacancies INT NOT NULL DEFAULT 1,
  location VARCHAR(180) NULL,
  contact_info VARCHAR(180) NULL,
  deadline DATE NULL,
  status ENUM('draft','pending','approved','active','rejected','closed','archived','expired') NOT NULL DEFAULT 'draft',
  rejection_reason VARCHAR(255) NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NULL,
  CONSTRAINT fk_jobs_employer FOREIGN KEY (employer_id) REFERENCES employers(id) ON DELETE CASCADE,
  CONSTRAINT fk_jobs_barangay FOREIGN KEY (barangay_id) REFERENCES barangays(id) ON DELETE SET NULL
);

CREATE TABLE applications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  job_id INT NOT NULL,
  jobseeker_id INT NOT NULL,
  resume_path VARCHAR(255) NULL,
  status ENUM('applied','screening','shortlisted','interview','hired','rejected') NOT NULL DEFAULT 'applied',
  match_score INT NOT NULL DEFAULT 0,
  interview_date DATE NULL,
  interview_time TIME NULL,
  interview_location VARCHAR(180) NULL,
  interview_type ENUM('Face-to-face','Online','Phone Interview') NULL,
  interview_notes TEXT NULL,
  hiring_result VARCHAR(120) NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NULL,
  UNIQUE KEY uq_application (job_id, jobseeker_id),
  CONSTRAINT fk_app_job FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE,
  CONSTRAINT fk_app_seeker FOREIGN KEY (jobseeker_id) REFERENCES job_seekers(id) ON DELETE CASCADE
);

CREATE TABLE saved_jobs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  job_id INT NOT NULL,
  jobseeker_id INT NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uq_saved_job (job_id, jobseeker_id),
  CONSTRAINT fk_saved_job FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE,
  CONSTRAINT fk_saved_seeker FOREIGN KEY (jobseeker_id) REFERENCES job_seekers(id) ON DELETE CASCADE
);

CREATE TABLE trainings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(180) NOT NULL,
  provider VARCHAR(160) NOT NULL,
  category VARCHAR(120) NOT NULL,
  description TEXT NULL,
  slots INT NOT NULL DEFAULT 0,
  location VARCHAR(180) NULL,
  status ENUM('open','closed','completed','cancelled') NOT NULL DEFAULT 'open',
  start_date DATE NULL,
  end_date DATE NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE training_registrations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  training_id INT NOT NULL,
  jobseeker_id INT NOT NULL,
  status ENUM('registered','attended','completed','cancelled') NOT NULL DEFAULT 'registered',
  certificate_path VARCHAR(255) NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uq_training_registration (training_id, jobseeker_id),
  CONSTRAINT fk_tr_training FOREIGN KEY (training_id) REFERENCES trainings(id) ON DELETE CASCADE,
  CONSTRAINT fk_tr_seeker FOREIGN KEY (jobseeker_id) REFERENCES job_seekers(id) ON DELETE CASCADE
);

CREATE TABLE announcements (
  id INT AUTO_INCREMENT PRIMARY KEY,
  created_by INT NULL,
  title VARCHAR(180) NOT NULL,
  message TEXT NOT NULL,
  audience ENUM('public','all','employer','jobseeker','admin') NOT NULL DEFAULT 'public',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_ann_user FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE notifications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  title VARCHAR(180) NOT NULL,
  message TEXT NOT NULL,
  is_read TINYINT(1) NOT NULL DEFAULT 0,
  is_seen TINYINT(1) NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_notif_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE badge_views (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  badge_key VARCHAR(160) NOT NULL,
  viewed_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY unique_user_badge (user_id, badge_key),
  CONSTRAINT fk_badge_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE activity_logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NULL,
  action VARCHAR(120) NOT NULL,
  details TEXT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_log_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

INSERT INTO barangays (name) VALUES
('Aguinaldo'),
('Alang-alang'),
('Binalay'),
('Calutan'),
('Camcuevas'),
('Domrog'),
('Limbujan'),
('Macapagal'),
('Magsaysay'),
('Osmeña'),
('Pingan'),
('Laurel'),
('Roxas'),
('Quezon'),
('Quirino'),
('San Isidro'),
('San Roque'),
('Santa Cruz (Opong)'),
('Santa Fe'),
('Tandang Sora'),
('Tugop'),
('Vigan'),
('Barangay 1 (Poblacion)'),
('Barangay 2 (Poblacion)'),
('Barangay 3 (Poblacion)'),
('Barangay 4 (Poblacion)'),
('Barangay 5 (Poblacion)'),
('Barangay 6 (Poblacion)'),
('Barangay 7 (Poblacion)'),
('Barangay 8 (Poblacion)');

INSERT INTO users (barangay_id, name, email, password_hash, role, contact_number, status, email_verified_at) VALUES
(NULL, 'General MacArthur Administrator', 'admin@generalmacarthur.gov.ph', '$2y$10$8RxvJKI4CEsr2KeKGKaILuQ2xj2/Np3Q5YpnHIFYjp9BJXZQ/3jCe', 'municipal_admin', '055-000-0001', 'verified', NOW()),
(1, 'Barangay Employment Admin', 'barangay@generalmacarthur.gov.ph', '$2y$10$8RxvJKI4CEsr2KeKGKaILuQ2xj2/Np3Q5YpnHIFYjp9BJXZQ/3jCe', 'barangay_admin', '055-000-0002', 'verified', NOW()),
(1, 'ABC Construction', 'employer@example.com', '$2y$10$ewYQYTAxKFy0EdI8SH5QheXrMa.AzcIIRUbVcymHdvuLqL6y6w4ja', 'employer', '0917-111-2222', 'verified', NOW()),
(1, 'Juan Dela Cruz', 'jobseeker@example.com', '$2y$10$S3Vwdf7ia7vcmRPNs1xmR.qas3PTNxj2HLPLbcwI2z2.qHiA5vqCu', 'jobseeker', '0917-555-0182', 'verified', NOW()),
(2, 'Maria Santos', 'maria@example.com', '$2y$10$S3Vwdf7ia7vcmRPNs1xmR.qas3PTNxj2HLPLbcwI2z2.qHiA5vqCu', 'jobseeker', '0917-555-0183', 'verified', NOW());

INSERT INTO employers (user_id, business_name, business_address, business_type, industry, contact_person, company_description, verification_status)
VALUES (3, 'ABC Construction', 'Aguinaldo, General MacArthur, Eastern Samar', 'Contractor', 'Construction', 'Ramon Abella', 'Local construction and maintenance services.', 'verified');

INSERT INTO job_seekers (user_id, birthdate, gender, address, education, employment_status, position, years_experience, expected_salary, skills, soft_skills, certifications, verification_status)
VALUES
(4, '1998-05-10', 'Male', 'Aguinaldo, General MacArthur, Eastern Samar', 'College', 'unemployed', 'Construction Worker', 3, 800.00, 'Masonry, Carpentry, Plumbing, Welding', 'Teamwork, Reliability', 'Masonry NC II', 'verified'),
(5, '1997-09-02', 'Female', 'Alang-alang, General MacArthur, Eastern Samar', 'Vocational', 'underemployed', 'Caregiver', 2, 700.00, 'Caregiving, Housekeeping, Customer Service', 'Patience, Communication', 'Caregiving NC II', 'verified');

INSERT INTO skills (category, name) VALUES
('Information Technology','Programming'),('Information Technology','Web Development'),('Information Technology','Database Management'),
('Construction','Masonry'),('Construction','Carpentry'),('Construction','Welding'),('Construction','Electrical Installation'),('Construction','Plumbing'),
('Hospitality','Cooking'),('Hospitality','Housekeeping'),('Hospitality','Customer Service'),
('Agriculture','Farming'),('Agriculture','Livestock Management'),('Agriculture','Fishing');

INSERT INTO jobs (employer_id, barangay_id, title, description, category, required_skills, education_requirement, experience_years, salary_min, salary_max, employment_type, vacancies, location, contact_info, deadline, status)
VALUES
(1, 1, 'Masonry Worker', 'Assist in hollow block laying and wall repair.', 'Construction', 'Masonry, Carpentry', 'High School', 1, 700.00, 900.00, 'Contractual', 3, 'Aguinaldo, General MacArthur', '0917-111-2222', DATE_ADD(CURDATE(), INTERVAL 30 DAY), 'active'),
(1, 2, 'Maintenance Helper', 'Support repair, painting, and general maintenance tasks.', 'Construction', 'Plumbing, Carpentry, Electrical Installation', 'High School', 1, 650.00, 850.00, 'Part-Time', 2, 'Alang-alang, General MacArthur', '0917-111-2222', DATE_ADD(CURDATE(), INTERVAL 20 DAY), 'approved');

INSERT INTO applications (job_id, jobseeker_id, status, match_score)
VALUES (1, 1, 'screening', 92), (2, 2, 'applied', 78);

INSERT INTO trainings (title, provider, category, description, slots, location, status, start_date, end_date)
VALUES
('Welding NC II Training', 'TESDA', 'Construction', 'Skills training for local welding certification.', 25, 'General MacArthur Training Center', 'open', DATE_ADD(CURDATE(), INTERVAL 10 DAY), DATE_ADD(CURDATE(), INTERVAL 40 DAY)),
('Job Readiness Seminar', 'Municipal Employment Office', 'Employment', 'Resume writing, interview preparation, and workplace orientation.', 60, 'Municipal Hall', 'open', DATE_ADD(CURDATE(), INTERVAL 5 DAY), DATE_ADD(CURDATE(), INTERVAL 5 DAY));

INSERT INTO announcements (created_by, title, message, audience)
VALUES
(1, 'LaborMatch Registration Open', 'Job seekers and employers in General MacArthur may now register in the LaborMatch system.', 'public'),
(1, 'Skills Verification Day', 'Bring your resume, certificates, and valid ID to the municipal office for profile verification.', 'jobseeker');
